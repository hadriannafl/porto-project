<template>
  <section id="contact" :class="['py-24 px-6', isDark ? 'bg-gray-950' : 'bg-gray-50']">
    <div class="max-w-6xl mx-auto">
      <SectionTitle :title="t('contact.title')" :subtitle="t('contact.subtitle')" :isDark="isDark" />

      <div class="grid md:grid-cols-2 gap-12 mt-16">
        <!-- Left: info -->
        <div>
          <h3 :class="['text-2xl font-bold mb-4', isDark ? 'text-white' : 'text-gray-900']">
            {{ t('contact.heading') }}
          </h3>
          <p :class="['text-lg leading-relaxed mb-8', isDark ? 'text-gray-400' : 'text-gray-600']">
            {{ t('contact.desc') }}
          </p>

          <!-- Contact items -->
          <div class="space-y-4">
            <div v-for="item in contactItems" :key="item.key"
              :class="['flex items-center gap-4 p-4 rounded-xl transition-all hover:scale-105 cursor-pointer', isDark ? 'bg-gray-900 border border-gray-800 hover:border-violet-500/40' : 'bg-white border border-gray-200 hover:border-violet-300 hover:shadow-md']">
              <div :class="['w-12 h-12 rounded-xl flex items-center justify-center text-xl', item.bg]">
                {{ item.icon }}
              </div>
              <div>
                <div :class="['text-xs font-medium', isDark ? 'text-gray-500' : 'text-gray-400']">{{ item.label }}</div>
                <div :class="['font-semibold', isDark ? 'text-white' : 'text-gray-800']">{{ item.value }}</div>
              </div>
            </div>
          </div>

          <!-- Social links -->
          <div class="flex gap-3 mt-8">
            <a v-for="social in socials" :key="social.label" :href="social.href ?? '#'" :target="social.href ? '_blank' : ''"
              :class="['px-5 py-3 rounded-xl flex items-center gap-3 transition-all hover:scale-105 hover:-translate-y-1', isDark ? 'bg-gray-900 border border-gray-800 hover:border-violet-500/50' : 'bg-white border border-gray-200 hover:border-violet-300 hover:shadow-md']">
              <span class="text-xl">{{ social.icon }}</span>
              <span :class="['text-sm font-semibold', isDark ? 'text-gray-300' : 'text-gray-700']">{{ social.label }}</span>
            </a>
          </div>
        </div>

        <!-- Right: form -->
        <div :class="['p-8 rounded-2xl border', isDark ? 'bg-gray-900 border-gray-800' : 'bg-white border-gray-200 shadow-sm']">
          <form @submit.prevent="sendMessage" class="space-y-5">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ t('contact.form.name') }}</label>
                <input v-model="form.name" type="text" :placeholder="t('contact.form.namePlaceholder')"
                  :class="['w-full px-4 py-3 rounded-xl border text-sm outline-none transition-all focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20', isDark ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500' : 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-400']">
              </div>
              <div>
                <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ t('contact.form.email') }}</label>
                <input v-model="form.email" type="email" :placeholder="t('contact.form.emailPlaceholder')"
                  :class="['w-full px-4 py-3 rounded-xl border text-sm outline-none transition-all focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20', isDark ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500' : 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-400']">
              </div>
            </div>
            <div>
              <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ t('contact.form.subject') }}</label>
              <input v-model="form.subject" type="text" :placeholder="t('contact.form.subjectPlaceholder')"
                :class="['w-full px-4 py-3 rounded-xl border text-sm outline-none transition-all focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20', isDark ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500' : 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-400']">
            </div>
            <div>
              <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ t('contact.form.message') }}</label>
              <textarea v-model="form.message" rows="5" :placeholder="t('contact.form.messagePlaceholder')"
                :class="['w-full px-4 py-3 rounded-xl border text-sm outline-none transition-all focus:border-violet-500 focus:ring-2 focus:ring-violet-500/20 resize-none', isDark ? 'bg-gray-800 border-gray-700 text-white placeholder-gray-500' : 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-400']"></textarea>
            </div>
            <!-- Error -->
            <p v-if="error" class="text-red-400 text-sm text-center px-1">{{ error }}</p>

            <button type="submit" :disabled="sending || sent"
              :class="['w-full py-4 rounded-xl font-semibold text-white transition-all flex items-center justify-center gap-2 disabled:cursor-not-allowed',
                sent ? 'bg-green-500' : 'bg-gradient-to-r from-violet-600 to-cyan-500 hover:opacity-90 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-violet-500/30 disabled:opacity-70']">
              <span v-if="sending" class="w-4 h-4 rounded-full border-2 border-white border-t-transparent animate-spin"></span>
              {{ sent ? t('contact.form.sent') : sending ? t('contact.form.sending') : t('contact.form.send') }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'
import SectionTitle from './SectionTitle.vue'
import { t } from '../locale.js'

defineProps(['isDark'])

const form    = ref({ name: '', email: '', subject: '', message: '' })
const sent    = ref(false)
const sending = ref(false)
const error   = ref('')
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? ''

const sendMessage = async () => {
  error.value = ''
  sending.value = true

  try {
    const res = await fetch('/api/contact', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      },
      body: JSON.stringify(form.value),
    })

    if (!res.ok) {
      const json = await res.json()
      error.value = Object.values(json.errors ?? {}).flat()[0] ?? t('contact.form.failedSend')
      return
    }

    sent.value = true
    form.value = { name: '', email: '', subject: '', message: '' }
    setTimeout(() => { sent.value = false }, 4000)
  } catch {
    error.value = t('contact.form.networkError')
  } finally {
    sending.value = false
  }
}

const contactItems = computed(() => [
  { key: 'email',        icon: '📧', label: t('contact.items.email'),        value: 'hadriannaufal11@gmail.com',   bg: 'bg-violet-900/50 text-violet-400' },
  { key: 'location',     icon: '📍', label: t('contact.items.location'),     value: 'Jakarta, Indonesia',           bg: 'bg-cyan-900/50 text-cyan-400' },
  { key: 'availability', icon: '💼', label: t('contact.items.availability'), value: t('contact.items.availabilityValue'), bg: 'bg-green-900/50 text-green-400' },
])

const socials = [
  { icon: '💼', label: 'LinkedIn', href: 'https://www.linkedin.com/in/hadriannaufal' },
]
</script>
