<template>
  <section id="projects" :class="['py-24 px-6', isDark ? 'bg-gray-900/50' : 'bg-white']">
    <div class="max-w-6xl mx-auto">
      <SectionTitle title="Featured Projects" subtitle="What I've built" :isDark="isDark" />

      <!-- Filter tabs -->
      <div class="flex flex-wrap justify-center gap-2 mt-10">
        <button v-for="tab in tabs" :key="tab"
          @click="activeTab = tab"
          :class="['px-5 py-2 rounded-full text-sm font-semibold transition-all', activeTab === tab
            ? 'bg-gradient-to-r from-violet-600 to-cyan-500 text-white shadow-lg'
            : isDark ? 'bg-gray-800 text-gray-400 hover:bg-gray-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200']">
          {{ tab }}
        </button>
      </div>

      <!-- Projects grid -->
      <div class="mt-10 grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="project in filteredProjects" :key="project.title"
          :class="['group rounded-2xl overflow-hidden border transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl', isDark ? 'bg-gray-900 border-gray-800 hover:border-violet-500/40 hover:shadow-violet-500/10' : 'bg-white border-gray-200 hover:border-violet-200 hover:shadow-violet-100']">

          <!-- Project image placeholder -->
          <div :class="['h-48 flex items-center justify-center text-6xl relative overflow-hidden', project.bg]">
            {{ project.emoji }}
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-end p-4 gap-2">
              <a href="#" class="w-9 h-9 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white/40 transition-colors text-sm">↗</a>
              <a href="#" class="w-9 h-9 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white hover:bg-white/40 transition-colors text-sm">⌥</a>
            </div>
          </div>

          <div class="p-6">
            <!-- Tags -->
            <div class="flex flex-wrap gap-1.5 mb-3">
              <span v-for="tag in project.tags" :key="tag"
                :class="['px-2.5 py-0.5 rounded-full text-xs font-medium', isDark ? 'bg-violet-950 text-violet-300 border border-violet-800' : 'bg-violet-50 text-violet-700 border border-violet-200']">
                {{ tag }}
              </span>
            </div>
            <h3 :class="['text-lg font-bold mb-2', isDark ? 'text-white' : 'text-gray-900']">{{ project.title }}</h3>
            <p :class="['text-sm leading-relaxed', isDark ? 'text-gray-400' : 'text-gray-600']">{{ project.desc }}</p>

            <!-- Footer -->
            <div :class="['flex items-center justify-between mt-4 pt-4 border-t', isDark ? 'border-gray-800' : 'border-gray-100']">
              <span :class="['text-xs', isDark ? 'text-gray-500' : 'text-gray-400']">{{ project.year }}</span>
              <div class="flex gap-3">
                <a href="#" :class="['text-xs font-medium transition-colors', isDark ? 'text-violet-400 hover:text-violet-300' : 'text-violet-600 hover:text-violet-500']">Live Demo →</a>
                <a href="#" :class="['text-xs font-medium transition-colors', isDark ? 'text-gray-500 hover:text-gray-400' : 'text-gray-500 hover:text-gray-700']">GitHub</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Load more -->
      <div class="text-center mt-12">
        <a href="#"
          :class="['inline-flex items-center gap-2 px-8 py-3 rounded-full border-2 font-semibold transition-all hover:-translate-y-0.5', isDark ? 'border-violet-500/50 text-violet-300 hover:border-violet-400 hover:bg-violet-950/30' : 'border-violet-300 text-violet-700 hover:border-violet-500']">
          View All Projects
          <span>→</span>
        </a>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'
import SectionTitle from './SectionTitle.vue'
defineProps(['isDark'])

const activeTab = ref('All')
const tabs = ['All', 'Frontend', 'Backend', 'Full Stack']

const projects = [
  {
    title: 'E-Commerce Platform',
    desc: 'A full-featured online store with real-time inventory, payment gateway integration, and admin dashboard.',
    tags: ['Vue.js', 'Laravel', 'MySQL'],
    emoji: '🛒',
    bg: 'bg-gradient-to-br from-violet-900 to-purple-900',
    year: '2024',
    category: 'Full Stack',
  },
  {
    title: 'Real-time Chat App',
    desc: 'WebSocket-powered messaging platform with rooms, file sharing, and end-to-end encryption.',
    tags: ['Vue.js', 'Node.js', 'Socket.io'],
    emoji: '💬',
    bg: 'bg-gradient-to-br from-cyan-900 to-blue-900',
    year: '2024',
    category: 'Full Stack',
  },
  {
    title: 'Design System UI',
    desc: 'Comprehensive component library with 50+ reusable components, dark mode, and accessibility support.',
    tags: ['Vue.js', 'Tailwind', 'Storybook'],
    emoji: '🎨',
    bg: 'bg-gradient-to-br from-pink-900 to-rose-900',
    year: '2023',
    category: 'Frontend',
  },
  {
    title: 'REST API Service',
    desc: 'High-performance microservices API with OAuth2, rate limiting, caching, and auto-generated docs.',
    tags: ['Laravel', 'Redis', 'Docker'],
    emoji: '⚡',
    bg: 'bg-gradient-to-br from-amber-900 to-orange-900',
    year: '2023',
    category: 'Backend',
  },
  {
    title: 'Analytics Dashboard',
    desc: 'Interactive data visualization dashboard with real-time charts, filters, and export capabilities.',
    tags: ['Vue.js', 'Chart.js', 'Tailwind'],
    emoji: '📊',
    bg: 'bg-gradient-to-br from-emerald-900 to-teal-900',
    year: '2024',
    category: 'Frontend',
  },
  {
    title: 'Task Manager Pro',
    desc: 'Kanban-style project management tool with team collaboration, time tracking, and notifications.',
    tags: ['Vue.js', 'Laravel', 'WebSocket'],
    emoji: '📋',
    bg: 'bg-gradient-to-br from-indigo-900 to-violet-900',
    year: '2023',
    category: 'Full Stack',
  },
]

const filteredProjects = computed(() => {
  if (activeTab.value === 'All') return projects
  return projects.filter(p => p.category === activeTab.value)
})
</script>
