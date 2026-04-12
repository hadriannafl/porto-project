<template>
  <section id="skills" :class="['py-24 px-6', isDark ? 'bg-gray-950' : 'bg-gray-50']">
    <div class="max-w-6xl mx-auto">
      <SectionTitle :title="t('skills.title')" :subtitle="t('skills.subtitle')" :isDark="isDark" />

      <!-- Tech stack icons -->
      <div class="mt-16 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        <div v-for="skill in skills" :key="skill.name"
          :class="['group p-6 rounded-2xl border cursor-default transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl', isDark ? 'bg-gray-900 border-gray-800 hover:border-violet-500/50 hover:shadow-violet-500/10' : 'bg-white border-gray-200 hover:border-violet-300 hover:shadow-violet-100']">
          <div class="text-4xl mb-3">{{ skill.icon }}</div>
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

const skills = [
  { icon: '💚', name: 'Vue.js',       categoryKey: 'Frontend',  level: 92 },
  { icon: '⚡', name: 'JavaScript',   categoryKey: 'Language',  level: 90 },
  { icon: '🔴', name: 'Laravel',      categoryKey: 'Backend',   level: 88 },
  { icon: '🐘', name: 'PHP',          categoryKey: 'Language',  level: 85 },
  { icon: '🎨', name: 'Tailwind CSS', categoryKey: 'Styling',   level: 95 },
  { icon: '🐬', name: 'MySQL',        categoryKey: 'Database',  level: 95 },
  { icon: '⚛️', name: 'React',        categoryKey: 'Frontend',  level: 72 },
  { icon: '🍃', name: 'MongoDB',      categoryKey: 'Database',  level: 68 },
  { icon: '🐙', name: 'Git',          categoryKey: 'Tools',     level: 90 },
  { icon: '☁️', name: 'AWS',          categoryKey: 'Cloud',     level: 40 },
  { icon: '🖥️', name: 'cPanel',       categoryKey: 'Hosting',   level: 70 },
  { icon: '🔷', name: 'VB.NET',       categoryKey: 'Language',  level: 30 },
  { icon: '🟣', name: 'C#',           categoryKey: 'Language',  level: 20 },
  { icon: '🤖', name: 'Android',      categoryKey: 'Mobile',    level: 65 },
  { icon: '🎯', name: 'Dart',         categoryKey: 'Language',  level: 60 },
]

const softSkills = computed(() => t('skills.soft'))
</script>
