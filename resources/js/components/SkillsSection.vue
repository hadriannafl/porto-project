<template>
  <section id="skills" :class="['py-24 px-6', isDark ? 'bg-gray-950' : 'bg-gray-50']">
    <div class="max-w-6xl mx-auto">
      <SectionTitle :title="t('skills.title')" :subtitle="t('skills.subtitle')" :isDark="isDark" />

      <!-- Tech stack icons -->
      <div class="mt-16 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        <div v-for="skill in skills" :key="skill.name"
          :class="['group p-6 rounded-2xl border cursor-default transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl', isDark ? 'bg-gray-900 border-gray-800 hover:border-violet-500/50 hover:shadow-violet-500/10' : 'bg-white border-gray-200 hover:border-violet-300 hover:shadow-violet-100']">
          <div class="mb-3 w-10 h-10">
            <img :src="skill.logo" :alt="skill.name" class="w-10 h-10 object-contain" />
          </div>
          <div :class="['font-bold', isDark ? 'text-white' : 'text-gray-800']">{{ skill.name }}</div>
          <div :class="['text-xs mt-1 mb-3', isDark ? 'text-gray-500' : 'text-gray-400']">{{ t('skills.categories.' + skill.categoryKey) }}</div>
          <!-- Progress bar -->
          <div :class="['h-1 rounded-full overflow-hidden', isDark ? 'bg-gray-800' : 'bg-gray-100']">
            <div class="h-full rounded-full bg-gradient-to-r from-violet-600 to-cyan-500 transition-all duration-1000"
              :style="{ width: skill.level + '%' }"></div>
          </div>
          <div :class="['text-xs mt-1 text-right', isDark ? 'text-gray-600' : 'text-gray-400']">{{ skill.level }}%</div>
        </div>
      </div>

      <!-- Soft skills -->
      <div class="mt-16">
        <h3 :class="['text-xl font-bold mb-6 text-center', isDark ? 'text-gray-300' : 'text-gray-700']">{{ t('skills.softTitle') }}</h3>
        <div class="flex flex-wrap justify-center gap-3">
          <span v-for="soft in softSkills" :key="soft"
            :class="['px-5 py-2.5 rounded-full text-sm font-medium border transition-all hover:scale-105', isDark ? 'bg-gray-900 border-gray-700 text-gray-300 hover:border-violet-500' : 'bg-white border-gray-200 text-gray-700 hover:border-violet-400']">
            {{ soft }}
          </span>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import SectionTitle from './SectionTitle.vue'
import { t } from '../locale.js'

defineProps(['isDark'])

const CDN = 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons'

const skills = [
  { logo: `${CDN}/vuejs/vuejs-original.svg`,                                       name: 'Vue.js',       categoryKey: 'Frontend',  level: 92 },
  { logo: `${CDN}/javascript/javascript-original.svg`,                             name: 'JavaScript',   categoryKey: 'Language',  level: 90 },
  { logo: `${CDN}/laravel/laravel-original.svg`,                                   name: 'Laravel',      categoryKey: 'Backend',   level: 88 },
  { logo: `${CDN}/php/php-original.svg`,                                           name: 'PHP',          categoryKey: 'Language',  level: 85 },
  { logo: `${CDN}/tailwindcss/tailwindcss-original.svg`,                           name: 'Tailwind CSS', categoryKey: 'Styling',   level: 95 },
  { logo: `${CDN}/mysql/mysql-original.svg`,                                       name: 'MySQL',        categoryKey: 'Database',  level: 95 },
  { logo: `${CDN}/react/react-original.svg`,                                       name: 'React',        categoryKey: 'Frontend',  level: 72 },
  { logo: `${CDN}/mongodb/mongodb-original.svg`,                                   name: 'MongoDB',      categoryKey: 'Database',  level: 68 },
  { logo: `${CDN}/git/git-original.svg`,                                           name: 'Git',          categoryKey: 'Tools',     level: 90 },
  { logo: `${CDN}/amazonwebservices/amazonwebservices-plain-wordmark.svg`,         name: 'AWS',          categoryKey: 'Cloud',     level: 40 },
  { logo: `${CDN}/cpanel/cpanel-original.svg`,                                     name: 'cPanel',       categoryKey: 'Hosting',   level: 70 },
  { logo: `${CDN}/visualbasic/visualbasic-plain.svg`,                              name: 'VB.NET',       categoryKey: 'Language',  level: 30 },
  { logo: `${CDN}/csharp/csharp-original.svg`,                                     name: 'C#',           categoryKey: 'Language',  level: 20 },
  { logo: `${CDN}/android/android-plain.svg`,                                      name: 'Android',      categoryKey: 'Mobile',    level: 65 },
  { logo: `${CDN}/dart/dart-original.svg`,                                         name: 'Dart',         categoryKey: 'Language',  level: 60 },
]

const softSkills = computed(() => t('skills.soft'))
</script>
