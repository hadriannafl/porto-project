<template>
  <div class="text-center">
    <p :class="['text-sm font-semibold uppercase tracking-widest mb-3 text-violet-500']">{{ subtitle }}</p>
    <h2 :class="['text-4xl md:text-5xl font-black', isDark ? 'text-white' : 'text-gray-900']">
      {{ title }}
    </h2>
    <div class="mt-4 flex items-center justify-center gap-2">
      <div class="w-12 h-1 rounded-full bg-gradient-to-r from-violet-600 to-cyan-500"></div>
      <div class="w-3 h-3 rounded-full bg-violet-500"></div>
      <div class="w-12 h-1 rounded-full bg-gradient-to-r from-cyan-500 to-violet-600"></div>
    </div>
  </div>
</template>

<script setup>
defineProps(['title', 'subtitle', 'isDark'])
</script>
