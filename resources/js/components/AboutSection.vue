<template>
  <section id="about" :class="['py-24 px-6', isDark ? 'bg-gray-900/50' : 'bg-white']">
    <div class="max-w-6xl mx-auto">
      <SectionTitle title="About Me" subtitle="Get to know me" :isDark="isDark" />

      <div class="grid md:grid-cols-2 gap-16 items-center mt-16">
        <!-- Avatar / Visual -->
        <div class="relative flex justify-center">
          <div class="relative">
            <!-- Outer ring -->
            <div class="w-72 h-72 rounded-full bg-gradient-to-br from-violet-600 to-cyan-500 p-1">
              <div :class="['w-full h-full rounded-full flex items-center justify-center text-8xl', isDark ? 'bg-gray-900' : 'bg-white']">
                👨‍💻
              </div>
            </div>
            <!-- Floating badges -->
            <div :class="['absolute -top-4 -right-4 px-4 py-2 rounded-xl text-sm font-bold shadow-xl', isDark ? 'bg-violet-900 text-violet-200 border border-violet-700' : 'bg-violet-100 text-violet-800']">
              Vue.js ⚡
            </div>
            <div :class="['absolute -bottom-4 -left-4 px-4 py-2 rounded-xl text-sm font-bold shadow-xl', isDark ? 'bg-cyan-900 text-cyan-200 border border-cyan-700' : 'bg-cyan-100 text-cyan-800']">
              Laravel 🚀
            </div>
            <!-- Decorative dots -->
            <div class="absolute -z-10 top-4 left-4 w-full h-full rounded-full border-2 border-dashed border-violet-500/30"></div>
          </div>
        </div>

        <!-- Content -->
        <div>
          <h3 :class="['text-3xl font-bold mb-4', isDark ? 'text-white' : 'text-gray-900']">
            Passionate Developer & Creative Thinker
          </h3>
          <p :class="['text-lg leading-relaxed mb-4', isDark ? 'text-gray-400' : 'text-gray-600']">
            Hi! I'm Alex, a Full Stack Developer with 3+ years of experience building modern web applications.
            I specialize in <span class="text-violet-500 font-semibold">Vue.js</span> and <span class="text-cyan-500 font-semibold">Laravel</span>,
            creating seamless user experiences backed by solid architecture.
          </p>
          <p :class="['text-lg leading-relaxed mb-8', isDark ? 'text-gray-400' : 'text-gray-600']">
            When I'm not coding, I'm exploring new technologies, contributing to open source, or mentoring junior developers.
            I believe great software is built at the intersection of technology and empathy.
          </p>

          <!-- Info grid -->
          <div class="grid grid-cols-2 gap-4 mb-8">
            <div v-for="info in infos" :key="info.label"
              :class="['flex items-center gap-3 p-3 rounded-xl', isDark ? 'bg-gray-800/50' : 'bg-gray-50']">
              <span class="text-2xl">{{ info.icon }}</span>
              <div>
                <div :class="['text-xs', isDark ? 'text-gray-500' : 'text-gray-400']">{{ info.label }}</div>
                <div :class="['font-semibold text-sm', isDark ? 'text-gray-200' : 'text-gray-700']">{{ info.value }}</div>
              </div>
            </div>
          </div>

          <a href="#"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-violet-600 to-cyan-500 text-white font-semibold hover:opacity-90 transition-opacity">
            Download Resume
            <span>↓</span>
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import SectionTitle from './SectionTitle.vue'

defineProps(['isDark'])

const infos = [
  { icon: '📍', label: 'Location', value: 'Jakarta, Indonesia' },
  { icon: '🎓', label: 'Education', value: 'Computer Science' },
  { icon: '💼', label: 'Experience', value: '3+ Years' },
  { icon: '🌐', label: 'Languages', value: 'EN, ID' },
]
</script>
