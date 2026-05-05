<template>
  <section id="projects" :class="['py-24 px-6', isDark ? 'bg-gray-900/50' : 'bg-white']">
    <div class="max-w-6xl mx-auto">
      <!-- Title + Admin Add button -->
      <div class="relative">
        <SectionTitle :title="t('projects.title')" :subtitle="t('projects.subtitle')" :isDark="isDark" />
        <button v-if="isAdmin" @click="showModal = true"
          class="absolute right-0 top-0 flex items-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-violet-600 to-cyan-500 text-white text-sm font-semibold hover:opacity-90 hover:-translate-y-0.5 transition-all shadow-lg shadow-violet-500/20">
          <span class="text-base leading-none">+</span> {{ t('projects.addProject') }}
        </button>
      </div>

      <!-- Loading skeleton -->
      <div v-if="loading" class="mt-10 grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="i in 6" :key="i"
          :class="['rounded-2xl overflow-hidden border animate-pulse', isDark ? 'bg-gray-900 border-gray-800' : 'bg-white border-gray-200']">
          <div :class="['h-48', isDark ? 'bg-gray-800' : 'bg-gray-100']"></div>
          <div class="p-6 space-y-3">
            <div :class="['h-3 rounded-full w-1/2', isDark ? 'bg-gray-800' : 'bg-gray-100']"></div>
            <div :class="['h-4 rounded-full w-3/4', isDark ? 'bg-gray-800' : 'bg-gray-100']"></div>
            <div :class="['h-3 rounded-full', isDark ? 'bg-gray-800' : 'bg-gray-100']"></div>
          </div>
        </div>
      </div>

      <!-- Empty state -->
      <div v-else-if="filteredProjects.length === 0" class="mt-16 text-center">
        <div class="text-5xl mb-4">📂</div>
        <p :class="['text-lg', isDark ? 'text-gray-500' : 'text-gray-400']">{{ t('projects.empty') }}</p>
        <button v-if="isAdmin" @click="showModal = true"
          class="mt-4 px-6 py-2.5 rounded-full bg-gradient-to-r from-violet-600 to-cyan-500 text-white text-sm font-semibold hover:opacity-90 transition-opacity">
          {{ t('projects.addFirst') }}
        </button>
      </div>

      <!-- Projects grid -->
      <div v-else class="mt-10 grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="project in filteredProjects" :key="project.id"
          @click="isAdmin && openEdit(project)"
          :class="['group rounded-2xl overflow-hidden border transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl', isDark ? 'bg-gray-900 border-gray-800 hover:border-violet-500/40 hover:shadow-violet-500/10' : 'bg-white border-gray-200 hover:border-violet-200 hover:shadow-violet-100', isAdmin ? 'cursor-pointer' : '']">

          <!-- Project image -->
          <div :class="['h-48 relative overflow-hidden', project.bg, !isAdmin && project.image_urls?.length ? 'cursor-zoom-in' : '']"
            @click="!isAdmin && project.image_urls?.length && openLightbox(project, 0)">
            <img v-if="project.image_urls && project.image_urls.length" :src="project.image_urls[0]" :alt="project.title"
              class="w-full h-full object-cover">
            <div v-else class="w-full h-full flex items-center justify-center">
              <span :class="['text-6xl font-black opacity-30 select-none', isDark ? 'text-white' : 'text-white']">
                {{ project.title.charAt(0) }}
              </span>
            </div>
            <!-- Hover overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-between p-4">
              <div class="flex items-center gap-2">
                <span class="text-white text-sm font-medium">{{ project.year }}</span>
                <span v-if="isAdmin" class="px-2 py-0.5 rounded-full bg-violet-500/70 text-white text-xs font-medium backdrop-blur-sm">
                  {{ t('projects.clickEdit') }}
                </span>
              </div>
              <div class="flex gap-2">
                <a v-if="project.demo_url" :href="project.demo_url" target="_blank" @click.stop
                  class="w-9 h-9 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white/40 transition-colors text-sm">↗</a>
                <a v-if="project.github_url" :href="project.github_url" target="_blank" @click.stop
                  class="w-9 h-9 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white/40 transition-colors text-sm">⌥</a>
                <button v-if="isAdmin" @click.stop="deleteProject(project.id)"
                  class="w-9 h-9 rounded-full bg-red-500/70 backdrop-blur-sm flex items-center justify-center text-white hover:bg-red-500 transition-colors text-sm">✕</button>
              </div>
            </div>
          </div>

          <div class="p-6">
            <div class="flex flex-wrap gap-2 mb-3">
              <template v-for="tag in project.tags" :key="tag">
                <img v-if="getTagLogo(tag)" :src="getTagLogo(tag)" :alt="tag" :title="tag" class="w-7 h-7 object-contain" />
                <span v-else :class="['px-2.5 py-0.5 rounded-full text-xs font-medium', isDark ? 'bg-violet-950 text-violet-300 border border-violet-800' : 'bg-violet-50 text-violet-700 border border-violet-200']">{{ tag }}</span>
              </template>
            </div>
            <h3 :class="['text-lg font-bold mb-2', isDark ? 'text-white' : 'text-gray-900']">{{ project.title }}</h3>
            <p :class="['text-sm leading-relaxed', isDark ? 'text-gray-400' : 'text-gray-600']">{{ project.desc }}</p>

            <div :class="['flex items-center justify-between mt-4 pt-4 border-t', isDark ? 'border-gray-800' : 'border-gray-100']">
              <span :class="['text-xs px-2.5 py-1 rounded-full font-medium', isDark ? 'bg-gray-800 text-gray-400' : 'bg-gray-100 text-gray-500']">
                {{ project.category }}
              </span>
              <div class="flex gap-3">
                <a v-if="project.demo_url" :href="project.demo_url" target="_blank"
                  :class="['text-xs font-medium transition-colors', isDark ? 'text-violet-400 hover:text-violet-300' : 'text-violet-600 hover:text-violet-500']">
                  {{ t('projects.liveDemo') }}
                </a>
                <a v-if="project.github_url" :href="project.github_url" target="_blank"
                  :class="['text-xs font-medium transition-colors', isDark ? 'text-gray-500 hover:text-gray-400' : 'text-gray-500 hover:text-gray-700']">
                  GitHub
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Admin logout -->
      <div class="text-center mt-12 flex items-center justify-center gap-4">
        <form v-if="isAdmin" method="POST" action="/admin/logout">
          <input type="hidden" name="_token" :value="csrfToken">
          <button type="submit"
            :class="['px-4 py-2 rounded-full text-xs font-medium border transition-all', isDark ? 'border-gray-700 text-gray-500 hover:border-red-700 hover:text-red-400' : 'border-gray-300 text-gray-400 hover:border-red-400 hover:text-red-500']">
            Logout Admin
          </button>
        </form>
      </div>
    </div>

    <!-- Image Lightbox -->
    <Teleport to="body">
      <div v-if="lightbox.open" class="fixed inset-0 z-[60] flex items-center justify-center"
        @click="closeLightbox" @keydown.esc="closeLightbox">
        <div class="absolute inset-0 bg-black/90 backdrop-blur-sm"></div>

        <!-- Close button -->
        <button @click="closeLightbox"
          class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-xl transition-colors">
          ✕
        </button>

        <!-- Counter -->
        <span v-if="lightbox.images.length > 1"
          class="absolute top-4 left-1/2 -translate-x-1/2 z-10 text-white/70 text-sm font-medium bg-black/40 px-3 py-1 rounded-full">
          {{ lightbox.index + 1 }} / {{ lightbox.images.length }}
        </span>

        <!-- Prev arrow -->
        <button v-if="lightbox.images.length > 1" @click.stop="lightbox.index = (lightbox.index - 1 + lightbox.images.length) % lightbox.images.length"
          class="absolute left-4 z-10 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-2xl transition-colors select-none">
          ‹
        </button>

        <!-- Image -->
        <img :src="lightbox.images[lightbox.index]" @click.stop
          class="relative z-10 max-w-[90vw] max-h-[85vh] object-contain rounded-xl shadow-2xl select-none">

        <!-- Next arrow -->
        <button v-if="lightbox.images.length > 1" @click.stop="lightbox.index = (lightbox.index + 1) % lightbox.images.length"
          class="absolute right-4 z-10 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-2xl transition-colors select-none">
          ›
        </button>

        <!-- Dot indicators -->
        <div v-if="lightbox.images.length > 1" class="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 flex gap-2">
          <button v-for="(_, i) in lightbox.images" :key="i" @click.stop="lightbox.index = i"
            :class="['w-2 h-2 rounded-full transition-all', i === lightbox.index ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white/60']">
          </button>
        </div>
      </div>
    </Teleport>

    <!-- Add Project Modal -->
    <Teleport to="body">
      <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" @click="closeModal"></div>

        <div :class="['relative w-full max-w-lg rounded-2xl border shadow-2xl z-10 max-h-[90vh] overflow-y-auto', isDark ? 'bg-gray-900 border-gray-700' : 'bg-white border-gray-200']">
          <!-- Header -->
          <div :class="['flex items-center justify-between px-6 py-5 border-b sticky top-0 z-10', isDark ? 'border-gray-800 bg-gray-900' : 'border-gray-100 bg-white']">
            <h2 :class="['text-lg font-bold', isDark ? 'text-white' : 'text-gray-900']">
              {{ editingProject ? '✏️ Edit Project' : '+ Add Project' }}
            </h2>
            <button @click="closeModal" :class="['w-8 h-8 rounded-full flex items-center justify-center transition-colors', isDark ? 'hover:bg-gray-800 text-gray-400' : 'hover:bg-gray-100 text-gray-500']">✕</button>
          </div>

          <!-- Form -->
          <form @submit.prevent="editingProject ? updateProject() : addProject()" class="p-6 space-y-4">
            <!-- Image upload (max 5) -->
            <div>
              <label :class="['block text-sm font-medium mb-1.5', isDark ? 'text-gray-300' : 'text-gray-700']">
                Project Images <span :class="isDark ? 'text-gray-500' : 'text-gray-400'">(max 5)</span>
              </label>
              <input type="file" accept="image/*" multiple class="hidden" ref="fileInput" @change="onImageChange">

              <!-- Previews grid -->
              <div v-if="imagePreviews.length" class="grid grid-cols-3 gap-2 mb-2">
                <div v-for="(preview, idx) in imagePreviews" :key="idx"
                  :class="['relative h-24 rounded-xl overflow-hidden border', isDark ? 'border-gray-700' : 'border-gray-200']">
                  <img :src="preview.url" class="w-full h-full object-cover" alt="Preview">
                  <button type="button" @click="removeImage(idx)"
                    class="absolute top-1 right-1 w-6 h-6 rounded-full bg-black/60 text-white flex items-center justify-center text-xs hover:bg-red-500 transition-colors">
                    ✕
                  </button>
                </div>
                <!-- Add more button if < 5 -->
                <div v-if="imagePreviews.length < 5" @click="fileInput.click()"
                  :class="['flex flex-col items-center justify-center h-24 rounded-xl border-2 border-dashed cursor-pointer transition-colors',
                    isDark ? 'border-gray-700 hover:border-violet-500 bg-gray-800/50' : 'border-gray-300 hover:border-violet-400 bg-gray-50']">
                  <span class="text-2xl">+</span>
                  <span :class="['text-xs', isDark ? 'text-gray-500' : 'text-gray-400']">Add more</span>
                </div>
              </div>

              <!-- Upload area (empty) -->
              <div v-else @click="fileInput.click()"
                :class="['flex flex-col items-center justify-center h-32 rounded-xl border-2 border-dashed cursor-pointer transition-colors',
                  isDark ? 'border-gray-700 hover:border-violet-500 bg-gray-800/50' : 'border-gray-300 hover:border-violet-400 bg-gray-50']">
                <span class="text-3xl mb-2">🖼️</span>
                <span :class="['text-sm font-medium', isDark ? 'text-gray-400' : 'text-gray-500']">Click to upload images</span>
                <span :class="['text-xs mt-1', isDark ? 'text-gray-600' : 'text-gray-400']">PNG, JPG, WEBP — up to 5 images, max 5MB each</span>
              </div>
            </div>

            <div>
              <label :class="labelClass">Project Title *</label>
              <input v-model="form.title" type="text" placeholder="My Awesome Project" required :class="inputClass">
            </div>

            <div>
              <label :class="labelClass">Description *</label>
              <textarea v-model="form.desc" rows="3" placeholder="What does this project do?" required
                :class="[inputClass, 'resize-none']"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label :class="labelClass">Category *</label>
                <select v-model="form.category" :class="inputClass">
                  <option v-for="tab in tabs.slice(1)" :key="tab">{{ tab }}</option>
                </select>
              </div>
              <div>
                <label :class="labelClass">Year *</label>
                <input v-model="form.year" type="text" placeholder="2024" :class="inputClass">
              </div>
            </div>

            <div>
              <label :class="labelClass">Tags</label>
              <div :class="['flex flex-wrap gap-2 p-3 rounded-xl border max-h-52 overflow-y-auto', isDark ? 'bg-gray-800 border-gray-700' : 'bg-gray-50 border-gray-300']">
                <button v-for="tech in techList" :key="tech.name" type="button" @click="toggleTag(tech.name)" :title="tech.name"
                  :class="['flex flex-col items-center gap-1 p-2 rounded-xl border-2 transition-all', isTagSelected(tech.name) ? 'border-violet-500 bg-violet-500/20' : isDark ? 'border-gray-700 hover:border-gray-600 bg-gray-900/50' : 'border-gray-200 hover:border-gray-300 bg-white']">
                  <img :src="tech.logo" :alt="tech.name" class="w-7 h-7 object-contain" />
                  <span :class="['text-[10px] leading-tight text-center w-12 truncate', isTagSelected(tech.name) ? 'text-violet-400 font-medium' : isDark ? 'text-gray-500' : 'text-gray-400']">{{ tech.name }}</span>
                </button>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div>
                <label :class="labelClass">Live Demo URL</label>
                <input v-model="form.demo_url" type="url" placeholder="https://..." :class="inputClass">
              </div>
              <div>
                <label :class="labelClass">GitHub URL</label>
                <input v-model="form.github_url" type="url" placeholder="https://github.com/..." :class="inputClass">
              </div>
            </div>

            <!-- Error -->
            <p v-if="error" class="text-red-400 text-sm px-1">{{ error }}</p>

            <div class="flex gap-3 pt-2">
              <button type="button" @click="closeModal"
                :class="['flex-1 py-3 rounded-xl text-sm font-semibold border transition-colors', isDark ? 'border-gray-700 text-gray-400 hover:bg-gray-800' : 'border-gray-300 text-gray-600 hover:bg-gray-50']">
                Cancel
              </button>
              <button type="submit" :disabled="submitting"
                class="flex-1 py-3 rounded-xl bg-gradient-to-r from-violet-600 to-cyan-500 text-white text-sm font-semibold hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                <span v-if="submitting" class="w-4 h-4 rounded-full border-2 border-white border-t-transparent animate-spin"></span>
                {{ submitting ? 'Saving...' : editingProject ? 'Update Project' : 'Save Project' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </Teleport>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import SectionTitle from './SectionTitle.vue'
import { t } from '../locale.js'

const props = defineProps(['isDark', 'isAdmin'])

const lightbox = ref({ open: false, images: [], index: 0 })
const showModal      = ref(false)
const editingProject = ref(null)
const projects       = ref([])
const loading        = ref(true)
const submitting     = ref(false)
const error          = ref('')
const fileInput      = ref(null)
// imagePreviews: [{ url: string, file: File|null, path: string|null }]
const imagePreviews  = ref([])
const removedPaths   = ref([])

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? ''

const CDN = 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons'
const techList = [
  { name: 'Vue.js',       logo: `${CDN}/vuejs/vuejs-original.svg` },
  { name: 'JavaScript',   logo: `${CDN}/javascript/javascript-original.svg` },
  { name: 'TypeScript',   logo: `${CDN}/typescript/typescript-original.svg` },
  { name: 'Laravel',      logo: `${CDN}/laravel/laravel-original.svg` },
  { name: 'PHP',          logo: `${CDN}/php/php-original.svg` },
  { name: 'Tailwind CSS', logo: `${CDN}/tailwindcss/tailwindcss-original.svg` },
  { name: 'MySQL',        logo: `${CDN}/mysql/mysql-original.svg` },
  { name: 'SQL Server',   logo: `${CDN}/microsoftsqlserver/microsoftsqlserver-plain.svg` },
  { name: 'React',        logo: `${CDN}/react/react-original.svg` },
  { name: 'MongoDB',      logo: `${CDN}/mongodb/mongodb-original.svg` },
  { name: 'Node.js',      logo: `${CDN}/nodejs/nodejs-original.svg` },
  { name: 'Python',       logo: `${CDN}/python/python-original.svg` },
  { name: 'Docker',       logo: `${CDN}/docker/docker-original.svg` },
  { name: 'PostgreSQL',   logo: `${CDN}/postgresql/postgresql-original.svg` },
  { name: 'Git',          logo: `${CDN}/git/git-original.svg` },
  { name: 'AWS',          logo: `${CDN}/amazonwebservices/amazonwebservices-plain-wordmark.svg` },
  { name: 'Firebase',     logo: `${CDN}/firebase/firebase-original.svg` },
  { name: 'Flutter',      logo: `${CDN}/flutter/flutter-original.svg` },
  { name: 'Dart',         logo: `${CDN}/dart/dart-original.svg` },
  { name: 'Android',      logo: `${CDN}/android/android-plain.svg` },
  { name: 'C#',           logo: `${CDN}/csharp/csharp-original.svg` },
  { name: 'Java',         logo: `${CDN}/java/java-original.svg` },
  { name: 'HTML',         logo: `${CDN}/html5/html5-original.svg` },
  { name: 'CSS',          logo: `${CDN}/css3/css3-original.svg` },
  { name: 'Bootstrap',    logo: `${CDN}/bootstrap/bootstrap-original.svg` },
  { name: 'Redis',        logo: `${CDN}/redis/redis-original.svg` },
  { name: 'VB.NET',       logo: `${CDN}/visualbasic/visualbasic-plain.svg` },
  { name: 'Livewire',    logo: `${CDN}/livewire/livewire-original.svg` },
  { name: 'Alpine.js',   logo: `${CDN}/alpinejs/alpinejs-original.svg` },
]
const techLogoMap = Object.fromEntries(techList.map(t => [t.name, t.logo]))
function getTagLogo(tag) { return techLogoMap[tag] ?? null }

const selectedTags = ref([])
function toggleTag(name) {
  const i = selectedTags.value.indexOf(name)
  if (i === -1) selectedTags.value.push(name)
  else selectedTags.value.splice(i, 1)
  form.value.tags = selectedTags.value.join(', ')
}
function isTagSelected(name) { return selectedTags.value.includes(name) }

const tabs = ['All', 'Full Stack', 'Frontend', 'Backend', 'Mobile', 'Other']

const emptyForm = () => ({ title: '', desc: '', tags: '', year: new Date().getFullYear().toString(), category: 'Full Stack', demo_url: '', github_url: '' })
const form = ref(emptyForm())

const filteredProjects = computed(() => projects.value)

const labelClass = computed(() => ['block text-sm font-medium mb-1.5', props.isDark ? 'text-gray-300' : 'text-gray-700'])
const inputClass = computed(() => [
  'w-full px-4 py-2.5 rounded-xl border text-sm outline-none transition-all focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20',
  props.isDark ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500' : 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-400',
])

function openLightbox(project, index) {
  lightbox.value = { open: true, images: project.image_urls, index }
}

function closeLightbox() {
  lightbox.value.open = false
}

function onLightboxKey(e) {
  if (!lightbox.value.open) return
  if (e.key === 'Escape') closeLightbox()
  if (e.key === 'ArrowRight') lightbox.value.index = (lightbox.value.index + 1) % lightbox.value.images.length
  if (e.key === 'ArrowLeft') lightbox.value.index = (lightbox.value.index - 1 + lightbox.value.images.length) % lightbox.value.images.length
}

function openEdit(project) {
  editingProject.value = project
  form.value = {
    title:      project.title,
    desc:       project.desc,
    tags:       Array.isArray(project.tags) ? project.tags.join(', ') : project.tags,
    year:       project.year,
    category:   project.category,
    demo_url:   project.demo_url ?? '',
    github_url: project.github_url ?? '',
  }
  const paths = project.image ?? []
  const urls  = project.image_urls ?? []
  imagePreviews.value = paths.map((path, i) => ({ url: urls[i] ?? '', file: null, path }))
  removedPaths.value = []
  selectedTags.value = Array.isArray(project.tags)
    ? [...project.tags]
    : String(project.tags ?? '').split(',').map(t => t.trim()).filter(Boolean)
  showModal.value = true
}

async function fetchProjects() {
  loading.value = true
  try {
    const res = await fetch('/api/projects')
    projects.value = await res.json()
  } finally {
    loading.value = false
  }
}

function compressImage(file, maxWidth = 1280, quality = 0.82) {
  return new Promise(resolve => {
    const img = new Image()
    const url = URL.createObjectURL(file)
    img.onload = () => {
      URL.revokeObjectURL(url)
      let { width, height } = img
      if (width > maxWidth) {
        height = Math.round(height * maxWidth / width)
        width = maxWidth
      }
      const canvas = document.createElement('canvas')
      canvas.width = width
      canvas.height = height
      canvas.getContext('2d').drawImage(img, 0, 0, width, height)
      canvas.toBlob(blob => {
        resolve(new File([blob], file.name.replace(/\.\w+$/, '.jpg'), { type: 'image/jpeg' }))
      }, 'image/jpeg', quality)
    }
    img.src = url
  })
}

async function onImageChange(e) {
  const files = Array.from(e.target.files)
  const remaining = 5 - imagePreviews.value.length
  for (const file of files.slice(0, remaining)) {
    const compressed = await compressImage(file)
    imagePreviews.value.push({ url: URL.createObjectURL(compressed), file: compressed, path: null })
  }
  if (fileInput.value) fileInput.value.value = ''
}

function removeImage(idx) {
  const item = imagePreviews.value[idx]
  if (item.path) removedPaths.value.push(item.path)
  imagePreviews.value.splice(idx, 1)
}

async function addProject() {
  error.value = ''
  submitting.value = true

  try {
    const fd = new FormData()
    fd.append('title',      form.value.title)
    fd.append('desc',       form.value.desc)
    fd.append('tags',       form.value.tags)
    fd.append('year',       form.value.year)
    fd.append('category',   form.value.category)
    if (form.value.demo_url)   fd.append('demo_url',   form.value.demo_url)
    if (form.value.github_url) fd.append('github_url', form.value.github_url)
    imagePreviews.value.filter(p => p.file).forEach(p => fd.append('images[]', p.file))

    const res = await fetch('/api/projects', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
      body: fd,
    })

    if (!res.ok) {
      const json = await res.json()
      error.value = Object.values(json.errors ?? {}).flat()[0] ?? 'Failed to save.'
      return
    }

    const project = await res.json()
    projects.value.unshift(project)
    closeModal()
  } finally {
    submitting.value = false
  }
}

async function updateProject() {
  error.value = ''
  submitting.value = true

  try {
    const fd = new FormData()
    fd.append('title',    form.value.title)
    fd.append('desc',     form.value.desc)
    fd.append('tags',     form.value.tags)
    fd.append('year',     form.value.year)
    fd.append('category', form.value.category)
    if (form.value.demo_url)   fd.append('demo_url',   form.value.demo_url)
    if (form.value.github_url) fd.append('github_url', form.value.github_url)
    imagePreviews.value.filter(p => p.file).forEach(p => fd.append('images[]', p.file))
    fd.append('removed_images', JSON.stringify(removedPaths.value))

    const res = await fetch(`/api/projects/${editingProject.value.id}`, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
      body: fd,
    })

    if (!res.ok) {
      const json = await res.json()
      error.value = Object.values(json.errors ?? {}).flat()[0] ?? 'Failed to update.'
      return
    }

    const updated = await res.json()
    const idx = projects.value.findIndex(p => p.id === updated.id)
    if (idx !== -1) projects.value[idx] = updated
    closeModal()
  } finally {
    submitting.value = false
  }
}

async function deleteProject(id) {
  if (!confirm('Delete this project?')) return
  await fetch(`/api/projects/${id}`, {
    method: 'DELETE',
    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
  })
  projects.value = projects.value.filter(p => p.id !== id)
}

function closeModal() {
  showModal.value = false
  editingProject.value = null
  form.value = emptyForm()
  imagePreviews.value = []
  removedPaths.value = []
  selectedTags.value = []
  if (fileInput.value) fileInput.value.value = ''
  error.value = ''
}

onMounted(() => {
  fetchProjects()
  window.addEventListener('keydown', onLightboxKey)
})

onUnmounted(() => {
  window.removeEventListener('keydown', onLightboxKey)
})
</script>
