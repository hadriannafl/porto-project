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

            <!-- Orbit path ring (decorative) -->
            <div class="absolute inset-0 rounded-full border border-dashed border-violet-500/25 scale-[1.22]"></div>

            <!-- Orbiting badges: each absolutely at center, moved via keyframe -->
            <div :class="['orbit-badge-1 absolute px-3 py-1.5 rounded-xl text-xs font-bold shadow-lg whitespace-nowrap pointer-events-none select-none',
              isDark ? 'bg-violet-900 text-violet-200 border border-violet-700' : 'bg-violet-100 text-violet-800']"
              style="top: 50%; left: 50%;">
              Vue.js ⚡
            </div>

            <div :class="['orbit-badge-2 absolute px-3 py-1.5 rounded-xl text-xs font-bold shadow-lg whitespace-nowrap pointer-events-none select-none',
              isDark ? 'bg-cyan-900 text-cyan-200 border border-cyan-700' : 'bg-cyan-100 text-cyan-800']"
              style="top: 50%; left: 50%;">
              Laravel 🚀
            </div>

            <div :class="['orbit-badge-3 absolute px-3 py-1.5 rounded-xl text-xs font-bold shadow-lg whitespace-nowrap pointer-events-none select-none',
              isDark ? 'bg-purple-900 text-purple-200 border border-purple-700' : 'bg-purple-100 text-purple-800']"
              style="top: 50%; left: 50%;">
              Blazor 🔷
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
/* Shared: badge starts at center of avatar, then transform moves it to orbit position */
/* Pattern: rotate(start) translateX(radius) rotate(-start) translate(-50%, -50%) */
/* The orbit animation adds 360° to the outer rotate and -360° to the inner rotate */

.orbit-badge-1 {
  animation: orbit-1 10s linear infinite;
}
.orbit-badge-2 {
  animation: orbit-2 10s linear infinite;
}
.orbit-badge-3 {
  animation: orbit-3 10s linear infinite;
}

/* Badge 1 starts at 270° (top) */
@keyframes orbit-1 {
  from { transform: translate(-50%, -50%) rotate(270deg) translateX(155px) rotate(-270deg); }
  to   { transform: translate(-50%, -50%) rotate(630deg) translateX(155px) rotate(-630deg); }
}

/* Badge 2 starts at 270° + 120° = 390° (lower-right) */
@keyframes orbit-2 {
  from { transform: translate(-50%, -50%) rotate(390deg) translateX(155px) rotate(-390deg); }
  to   { transform: translate(-50%, -50%) rotate(750deg) translateX(155px) rotate(-750deg); }
}

/* Badge 3 starts at 270° + 240° = 510° (lower-left) */
@keyframes orbit-3 {
  from { transform: translate(-50%, -50%) rotate(510deg) translateX(155px) rotate(-510deg); }
  to   { transform: translate(-50%, -50%) rotate(870deg) translateX(155px) rotate(-870deg); }
}
</style>
