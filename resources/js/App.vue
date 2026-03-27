<template>
  <div :class="['min-h-screen transition-colors duration-500', isDark ? 'dark bg-gray-950 text-white' : 'bg-gray-50 text-gray-900']">
    <NavBar :isDark="isDark" @toggleDark="isDark = !isDark" />
    <HeroSection :isDark="isDark" />
    <AboutSection :isDark="isDark" />
    <SkillsSection :isDark="isDark" />
    <ProjectsSection :isDark="isDark" />
    <ContactSection :isDark="isDark" />
    <FooterSection :isDark="isDark" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import NavBar from './components/NavBar.vue'
import HeroSection from './components/HeroSection.vue'
import AboutSection from './components/AboutSection.vue'
import SkillsSection from './components/SkillsSection.vue'
import ProjectsSection from './components/ProjectsSection.vue'
import ContactSection from './components/ContactSection.vue'
import FooterSection from './components/FooterSection.vue'

const isDark = ref(true)
</script>
