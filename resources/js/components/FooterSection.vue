<template>
  <footer :class="['py-10 px-6 border-t', isDark ? 'bg-gray-950 border-gray-800' : 'bg-white border-gray-200']">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
      <div class="text-xl font-bold bg-gradient-to-r from-violet-500 to-cyan-400 bg-clip-text text-transparent">
        &lt;IanDev /&gt;
      </div>
      <p :class="['text-sm', isDark ? 'text-gray-500' : 'text-gray-400']">
        © {{ new Date().getFullYear() }} Ian Dev. Crafted with 💜 using Vue.js & Laravel.
      </p>
      <div class="flex gap-6">
        <a v-for="link in links" :key="link" href="#"
          :class="['text-sm transition-colors hover:text-violet-500', isDark ? 'text-gray-500' : 'text-gray-400']">
          {{ link }}
        </a>
      </div>
    </div>
  </footer>
</template>

<script setup>
defineProps(['isDark'])
const links = ['Home', 'About', 'Projects', 'Contact']
</script>
