<template>
  <div class="relative" ref="pickerRef">
    <!-- Trigger button -->
    <button type="button" @click="toggle"
      :class="['w-full flex items-center gap-3 px-4 py-2.5 rounded-xl border text-sm transition-all focus:outline-none focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20',
        isDark
          ? 'bg-gray-800 border-gray-700 text-white hover:border-gray-600'
          : 'bg-gray-50 border-gray-300 text-gray-900 hover:border-gray-400']">
      <!-- Preview icon -->
      <span class="w-7 h-7 flex items-center justify-center flex-shrink-0">
        <img v-if="modelValue" :src="iconUrl(modelValue)" class="w-6 h-6" alt="">
        <span v-else :class="['text-lg', isDark ? 'text-gray-600' : 'text-gray-400']">?</span>
      </span>
      <span :class="['flex-1 text-left truncate', !modelValue && (isDark ? 'text-gray-500' : 'text-gray-400')]">
        {{ modelValue || 'Pick an icon...' }}
      </span>
      <span :class="['text-xs transition-transform', open ? 'rotate-180' : '', isDark ? 'text-gray-500' : 'text-gray-400']">▼</span>
    </button>

    <!-- Dropdown panel -->
    <div v-if="open"
      :class="['absolute left-0 right-0 mt-2 rounded-2xl border shadow-2xl z-50 overflow-hidden', isDark ? 'bg-gray-900 border-gray-700 shadow-black/50' : 'bg-white border-gray-200 shadow-gray-200']">

      <!-- Search bar -->
      <div :class="['p-3 border-b', isDark ? 'border-gray-800' : 'border-gray-100']">
        <div class="relative">
          <input
            v-model="query"
            @input="onSearch"
            ref="searchInput"
            type="text"
            placeholder="Search icons... (e.g. rocket, code, star)"
            :class="['w-full pl-9 pr-3 py-2 rounded-xl border text-sm outline-none transition-all focus:border-violet-500',
              isDark ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500' : 'bg-gray-50 border-gray-200 text-gray-900 placeholder-gray-400']">
          <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
          <button v-if="query" @click="clearSearch" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-300 text-xs">✕</button>
        </div>
      </div>

      <!-- Category tabs -->
      <div :class="['flex gap-1 px-3 pt-2 pb-1 overflow-x-auto scrollbar-none', isDark ? 'border-gray-800' : '']">
        <button v-for="cat in categories" :key="cat.prefix"
          @click="selectCategory(cat.prefix)"
          :class="['flex-shrink-0 px-3 py-1 rounded-full text-xs font-medium transition-all whitespace-nowrap',
            activeCategory === cat.prefix
              ? 'bg-violet-600 text-white'
              : isDark ? 'bg-gray-800 text-gray-400 hover:bg-gray-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200']">
          {{ cat.label }}
        </button>
      </div>

      <!-- Icon grid -->
      <div class="p-3">
        <!-- Loading -->
        <div v-if="loading" class="flex items-center justify-center py-8 gap-2">
          <div class="w-5 h-5 rounded-full border-2 border-violet-500 border-t-transparent animate-spin"></div>
          <span :class="['text-sm', isDark ? 'text-gray-400' : 'text-gray-500']">Searching...</span>
        </div>

        <!-- Empty -->
        <div v-else-if="icons.length === 0" class="text-center py-8">
          <span class="text-3xl">🔍</span>
          <p :class="['text-sm mt-2', isDark ? 'text-gray-500' : 'text-gray-400']">No icons found for "{{ query }}"</p>
        </div>

        <!-- Grid -->
        <div v-else class="grid grid-cols-8 gap-1">
          <button
            v-for="icon in icons"
            :key="icon"
            type="button"
            @click="selectIcon(icon)"
            :title="icon"
            :class="['relative group p-1.5 rounded-lg transition-all flex items-center justify-center',
              modelValue === icon
                ? 'bg-violet-600 ring-2 ring-violet-400'
                : isDark ? 'hover:bg-gray-800' : 'hover:bg-gray-100']">
            <img :src="iconUrl(icon)" class="w-6 h-6" :alt="icon"
              :class="modelValue === icon ? 'brightness-0 invert' : (isDark ? 'invert opacity-80' : 'opacity-70')">
            <!-- Tooltip -->
            <div :class="['absolute bottom-full left-1/2 -translate-x-1/2 mb-1 px-2 py-0.5 rounded text-xs whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10',
              isDark ? 'bg-gray-700 text-gray-200' : 'bg-gray-800 text-white']">
              {{ icon.split(':')[1] }}
            </div>
          </button>
        </div>

        <!-- Load more -->
        <div v-if="icons.length > 0 && hasMore" class="mt-2 text-center">
          <button @click="loadMore" :class="['text-xs font-medium transition-colors', isDark ? 'text-violet-400 hover:text-violet-300' : 'text-violet-600 hover:text-violet-500']">
            Load more icons →
          </button>
        </div>
      </div>

      <!-- Selected preview -->
      <div v-if="modelValue" :class="['px-3 py-2.5 border-t flex items-center gap-2', isDark ? 'border-gray-800 bg-gray-950/50' : 'border-gray-100 bg-gray-50']">
        <img :src="iconUrl(modelValue)" class="w-5 h-5" :class="isDark ? 'invert opacity-80' : 'opacity-60'" alt="">
        <span :class="['text-xs font-mono', isDark ? 'text-gray-400' : 'text-gray-500']">{{ modelValue }}</span>
        <button @click="$emit('update:modelValue', ''); open = false" :class="['ml-auto text-xs transition-colors', isDark ? 'text-gray-600 hover:text-red-400' : 'text-gray-400 hover:text-red-500']">Clear</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted, nextTick } from 'vue'

const props = defineProps({
  modelValue: { type: String, default: '' },
  isDark: { type: Boolean, default: true },
})
const emit = defineEmits(['update:modelValue'])

const open = ref(false)
const query = ref('')
const icons = ref([])
const loading = ref(false)
const hasMore = ref(false)
const activeCategory = ref('mdi')
const pickerRef = ref(null)
const searchInput = ref(null)
let debounceTimer = null
let currentPage = 0
const PAGE_SIZE = 40

const categories = [
  { label: 'Material', prefix: 'mdi' },
  { label: 'Heroicons', prefix: 'heroicons' },
  { label: 'Tabler', prefix: 'tabler' },
  { label: 'Lucide', prefix: 'lucide' },
  { label: 'Carbon', prefix: 'carbon' },
  { label: 'Phosphor', prefix: 'ph' },
  { label: 'Font Awesome', prefix: 'fa6-solid' },
  { label: 'Fluent', prefix: 'fluent' },
]

function iconUrl(iconName) {
  const [prefix, name] = iconName.includes(':') ? iconName.split(':') : ['mdi', iconName]
  return `https://api.iconify.design/${prefix}/${name}.svg`
}

async function fetchIcons(reset = true) {
  if (reset) {
    currentPage = 0
    icons.value = []
  }
  loading.value = true

  try {
    const q = query.value.trim() || 'star'
    const prefixFilter = query.value.trim() ? '' : `&prefixes=${activeCategory.value}`
    const start = currentPage * PAGE_SIZE
    const url = `https://api.iconify.design/search?query=${encodeURIComponent(q)}${prefixFilter}&limit=${PAGE_SIZE}&start=${start}`
    const res = await fetch(url)
    const data = await res.json()
    const fetched = data.icons || []
    if (reset) {
      icons.value = fetched
    } else {
      icons.value.push(...fetched)
    }
    hasMore.value = fetched.length === PAGE_SIZE
  } catch {
    icons.value = []
  } finally {
    loading.value = false
  }
}

function onSearch() {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => fetchIcons(true), 350)
}

function clearSearch() {
  query.value = ''
  fetchIcons(true)
}

function selectCategory(prefix) {
  activeCategory.value = prefix
  query.value = ''
  fetchIcons(true)
}

function loadMore() {
  currentPage++
  fetchIcons(false)
}

function selectIcon(icon) {
  emit('update:modelValue', icon)
  open.value = false
}

function toggle() {
  open.value = !open.value
  if (open.value) {
    fetchIcons(true)
    nextTick(() => searchInput.value?.focus())
  }
}

function handleClickOutside(e) {
  if (pickerRef.value && !pickerRef.value.contains(e.target)) {
    open.value = false
  }
}

onMounted(() => document.addEventListener('mousedown', handleClickOutside))
onUnmounted(() => document.removeEventListener('mousedown', handleClickOutside))
</script>
