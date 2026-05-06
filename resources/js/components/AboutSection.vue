<template>
  <section id="about" :class="['py-24 px-6', isDark ? 'bg-gray-900/50' : 'bg-white']">
    <div class="max-w-6xl mx-auto">
      <SectionTitle :title="t('about.title')" :subtitle="t('about.subtitle')" :isDark="isDark" />

      <div class="grid md:grid-cols-2 gap-16 items-center mt-16">
        <!-- Avatar / Visual -->
        <div class="relative flex justify-center">
          <!-- Orbit pivot — centered over the avatar -->
          <div class="relative w-72 h-72">
            <!-- Avatar ring -->
            <div class="w-72 h-72 rounded-full bg-gradient-to-br from-violet-600 to-cyan-500 p-1">
              <div class="w-full h-full rounded-full overflow-hidden">
                <img :src="'/image/ianprofile.jpeg'" alt="Ian Dev" class="w-full h-full object-cover">
              </div>
            </div>

          </div>
        </div>

        <!-- Content -->
        <div>
          <h3 :class="['text-3xl font-bold mb-4', isDark ? 'text-white' : 'text-gray-900']">
            {{ t('about.heading') }}
          </h3>
          <p :class="['text-lg leading-relaxed mb-4', isDark ? 'text-gray-400' : 'text-gray-600']"
            v-html="t('about.p1')">
          </p>
          <p :class="['text-lg leading-relaxed mb-8', isDark ? 'text-gray-400' : 'text-gray-600']">
            {{ t('about.p2') }}
          </p>

          <!-- Info grid -->
          <div class="grid grid-cols-2 gap-4 mb-8">
            <div v-for="info in infos" :key="info.key"
              :class="['flex items-center gap-3 p-3 rounded-xl', isDark ? 'bg-gray-800/50' : 'bg-gray-50']">
              <span class="text-2xl">{{ info.icon }}</span>
              <div>
                <div :class="['text-xs', isDark ? 'text-gray-500' : 'text-gray-400']">{{ info.label }}</div>
                <div :class="['font-semibold text-sm', isDark ? 'text-gray-200' : 'text-gray-700']">{{ info.value }}</div>
              </div>
            </div>
          </div>

          <a :href="'/document/Hadrian Naufal Jatmika-resume.pdf'" download
            class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-violet-600 to-cyan-500 text-white font-semibold hover:opacity-90 transition-opacity">
            {{ t('about.downloadResume') }}
            <span>↓</span>
          </a>
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

const infos = computed(() => [
  { key: 'location',   icon: '📍', label: t('about.info.location'),   value: 'Jakarta, Indonesia' },
  { key: 'education',  icon: '🎓', label: t('about.info.education'),  value: 'Information System' },
  { key: 'experience', icon: '💼', label: t('about.info.experience'), value: '2+ Years' },
  { key: 'languages',  icon: '🌐', label: t('about.info.languages'),  value: 'EN, ID' },
])
</script>

<style scoped>
</style>
