<template>
  <nav :class="['fixed top-0 w-full z-50 transition-all duration-300', scrolled ? (isDark ? 'bg-gray-950/90 backdrop-blur-md shadow-lg shadow-black/20' : 'bg-white/90 backdrop-blur-md shadow-lg') : 'bg-transparent']">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
      <a href="#" class="text-xl font-bold bg-gradient-to-r from-violet-500 to-cyan-400 bg-clip-text text-transparent">
        &lt;IanDev /&gt;
      </a>

      <div class="hidden md:flex items-center gap-8">
        <a v-for="link in links" :key="link.href" :href="link.href"
          :class="['text-sm font-medium transition-colors hover:text-violet-500', isDark ? 'text-gray-300' : 'text-gray-600']">
          {{ link.label }}
        </a>
      </div>

      <div class="flex items-center gap-3">
        <!-- Language toggle -->
        <button @click="toggleLocale()"
          :class="['px-3 py-1.5 rounded-full text-xs font-bold border transition-all', isDark ? 'border-gray-700 bg-gray-800 text-gray-300 hover:border-violet-500 hover:text-violet-300' : 'border-gray-300 bg-white text-gray-600 hover:border-violet-400 hover:text-violet-600']">
          {{ locale === 'en' ? 'ID' : 'EN' }}
        </button>

        <!-- Dark mode toggle -->
        <button @click="$emit('toggleDark')"
          :class="['p-2 rounded-full transition-all', isDark ? 'bg-gray-800 hover:bg-gray-700 text-yellow-400' : 'bg-gray-200 hover:bg-gray-300 text-gray-700']">
          <span v-if="isDark">☀️</span>
          <span v-else>🌙</span>
        </button>

        <a href="#contact" class="hidden md:block px-4 py-2 rounded-full bg-gradient-to-r from-violet-600 to-cyan-500 text-white text-sm font-medium hover:opacity-90 transition-opacity">
          {{ t('nav.hireMe') }}
        </a>

        <button @click="menuOpen = !menuOpen" class="md:hidden p-2">
          <div :class="['w-5 h-0.5 transition-all mb-1', isDark ? 'bg-white' : 'bg-gray-900']"></div>
          <div :class="['w-5 h-0.5 transition-all mb-1', isDark ? 'bg-white' : 'bg-gray-900']"></div>
          <div :class="['w-5 h-0.5 transition-all', isDark ? 'bg-white' : 'bg-gray-900']"></div>
        </button>
      </div>
    </div>

    <!-- Mobile menu -->
    <div v-if="menuOpen" :class="['md:hidden px-6 pb-4', isDark ? 'bg-gray-950/95' : 'bg-white/95']">
      <a v-for="link in links" :key="link.href" :href="link.href" @click="menuOpen = false"
        :class="['block py-2 text-sm font-medium border-b transition-colors hover:text-violet-500', isDark ? 'border-gray-800 text-gray-300' : 'border-gray-200 text-gray-600']">
        {{ link.label }}
      </a>
    </div>
  </nav>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { locale, toggleLocale, t } from '../locale.js'

defineProps(['isDark'])
defineEmits(['toggleDark'])

const scrolled = ref(false)
const menuOpen = ref(false)

const links = computed(() => [
  { href: '#about',    label: t('nav.about') },
  { href: '#skills',   label: t('nav.skills') },
  { href: '#projects', label: t('nav.projects') },
  { href: '#contact',  label: t('nav.contact') },
])

const handleScroll = () => { scrolled.value = window.scrollY > 50 }
onMounted(() => window.addEventListener('scroll', handleScroll))
onUnmounted(() => window.removeEventListener('scroll', handleScroll))
</script>
