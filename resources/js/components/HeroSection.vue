<template>
  <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Animated background blobs -->
    <div class="absolute inset-0 pointer-events-none">
      <div class="absolute top-1/4 left-1/4 w-96 h-96 rounded-full bg-violet-600/20 blur-3xl animate-pulse"></div>
      <div class="absolute bottom-1/4 right-1/4 w-96 h-96 rounded-full bg-cyan-500/20 blur-3xl animate-pulse" style="animation-delay:1s"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full bg-pink-500/10 blur-3xl animate-pulse" style="animation-delay:2s"></div>
    </div>

    <!-- Grid overlay -->
    <div :class="['absolute inset-0 pointer-events-none', isDark ? 'opacity-5' : 'opacity-10']"
      style="background-image: linear-gradient(rgba(139,92,246,.3) 1px, transparent 1px), linear-gradient(90deg, rgba(139,92,246,.3) 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 text-center">
      <!-- Badge -->
      <div :class="['inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium mb-8 border', isDark ? 'bg-violet-950/50 border-violet-500/30 text-violet-300' : 'bg-violet-50 border-violet-200 text-violet-700']">
        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
        Available for freelance & full-time
      </div>

      <!-- Name -->
      <h1 class="text-5xl md:text-7xl font-black mb-4 leading-tight">
        <span :class="isDark ? 'text-white' : 'text-gray-900'">Hi, I'm </span>
        <span class="bg-gradient-to-r from-violet-500 via-pink-500 to-cyan-400 bg-clip-text text-transparent">
          {{ name }}
        </span>
      </h1>

      <!-- Animated role -->
      <div class="text-2xl md:text-4xl font-bold mb-6 h-12 flex items-center justify-center gap-3">
        <span :class="isDark ? 'text-gray-400' : 'text-gray-500'">a</span>
        <span class="bg-gradient-to-r from-violet-500 to-cyan-400 bg-clip-text text-transparent min-w-[280px] text-left">
          {{ currentRole }}
        </span>
        <span class="w-0.5 h-8 bg-violet-500 animate-pulse"></span>
      </div>

      <!-- Description -->
      <p :class="['text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed', isDark ? 'text-gray-400' : 'text-gray-600']">
        I craft beautiful, high-performance digital experiences that blend elegant design with robust engineering.
      </p>

      <!-- CTA Buttons -->
      <div class="flex flex-wrap gap-4 justify-center">
        <a href="#projects"
          class="group px-8 py-4 rounded-full bg-gradient-to-r from-violet-600 to-cyan-500 text-white font-semibold text-lg hover:shadow-2xl hover:shadow-violet-500/30 hover:-translate-y-1 transition-all duration-300">
          View My Work
          <span class="inline-block ml-2 group-hover:translate-x-1 transition-transform">→</span>
        </a>
        <a href="#contact"
          :class="['px-8 py-4 rounded-full font-semibold text-lg border-2 transition-all duration-300 hover:-translate-y-1', isDark ? 'border-violet-500/50 text-violet-300 hover:border-violet-400 hover:bg-violet-950/50' : 'border-violet-300 text-violet-700 hover:border-violet-500 hover:bg-violet-50']">
          Get In Touch
        </a>
      </div>

      <!-- Stats -->
      <div class="mt-16 grid grid-cols-3 gap-8 max-w-lg mx-auto">
        <div v-for="stat in stats" :key="stat.label" class="text-center">
          <div class="text-3xl font-black bg-gradient-to-r from-violet-500 to-cyan-400 bg-clip-text text-transparent">
            {{ stat.value }}
          </div>
          <div :class="['text-sm mt-1', isDark ? 'text-gray-500' : 'text-gray-500']">{{ stat.label }}</div>
        </div>
      </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-bounce">
      <span :class="['text-xs', isDark ? 'text-gray-500' : 'text-gray-400']">Scroll down</span>
      <div :class="['w-5 h-8 rounded-full border-2 flex items-start justify-center pt-1', isDark ? 'border-gray-600' : 'border-gray-400']">
        <div :class="['w-1 h-2 rounded-full animate-bounce', isDark ? 'bg-gray-400' : 'bg-gray-500']"></div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

defineProps(['isDark'])

const name = 'Alex Dev'
const roles = ['Full Stack Developer', 'UI/UX Enthusiast', 'Vue.js Expert', 'Laravel Developer', 'Problem Solver']
const currentRole = ref(roles[0])
let roleIndex = 0
let interval

const stats = [
  { value: '3+', label: 'Years Exp.' },
  { value: '50+', label: 'Projects' },
  { value: '30+', label: 'Clients' },
]

onMounted(() => {
  interval = setInterval(() => {
    roleIndex = (roleIndex + 1) % roles.length
    currentRole.value = roles[roleIndex]
  }, 2500)
})
onUnmounted(() => clearInterval(interval))
</script>
