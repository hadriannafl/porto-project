import { ref } from 'vue'

export const locale = ref('en')

export function toggleLocale() {
  locale.value = locale.value === 'en' ? 'id' : 'en'
}

const messages = {
  en: {
    nav: {
      about: 'About',
      skills: 'Skills',
      projects: 'Projects',
      contact: 'Contact',
      hireMe: 'Hire Me',
    },
    hero: {
      badge: 'Available for freelance & full-time',
      greeting: "Hi, I'm ",
      roles: ['Full Stack Developer', 'UI/UX Enthusiast', 'Vue.js Expert', 'Laravel Developer', 'Problem Solver'],
      desc: 'I craft beautiful, high-performance digital experiences that blend elegant design with robust engineering.',
      viewWork: 'View My Work',
      getInTouch: 'Get In Touch',
      stats: { yearsExp: 'Years Exp.', projects: 'Projects', clients: 'Clients' },
      scrollDown: 'Scroll down',
    },
    about: {
      title: 'About Me',
      subtitle: 'Get to know me',
      heading: 'Passionate Developer & Creative Thinker',
      p1: "Hi! I'm Ian, a Full Stack Developer with 2+ years of experience building modern web applications. I specialize in <span class=\"text-violet-500 font-semibold\">Vue.js</span> and <span class=\"text-cyan-500 font-semibold\">Laravel</span>, creating seamless user experiences backed by solid architecture.",
      p2: "When I'm not coding, I'm exploring new technologies, contributing to open source, or mentoring junior developers. I believe great software is built at the intersection of technology and empathy.",
      downloadResume: 'Download Resume',
      info: { location: 'Location', education: 'Education', experience: 'Experience', languages: 'Languages' },
    },
    skills: {
      title: 'Skills & Tools',
      subtitle: 'What I work with',
      softTitle: 'Soft Skills',
      categories: {
        Frontend: 'Frontend', Language: 'Language', Backend: 'Backend',
        Styling: 'Styling', Database: 'Database', Tools: 'Tools',
        Cloud: 'Cloud', Hosting: 'Hosting', Mobile: 'Mobile',
      },
      soft: ['Problem Solving', 'Team Collaboration', 'Code Review', 'Agile/Scrum', 'Technical Writing', 'UI/UX Thinking', 'Clean Code'],
    },
    projects: {
      title: 'Featured Projects',
      subtitle: "What I've built",
      empty: 'No projects yet in this category.',
      addFirst: 'Add First Project',
      addProject: 'Add Project',
      liveDemo: 'Live Demo →',
      clickEdit: '✏️ Click to edit',
    },
    contact: {
      title: 'Get In Touch',
      subtitle: "Let's work together",
      heading: "Let's build something amazing together",
      desc: "Whether you have a project in mind, want to collaborate, or just want to say hello — my inbox is always open. I'll get back to you within 24 hours!",
      items: {
        email: 'Email', location: 'Location',
        availability: 'Availability', availabilityValue: 'Open to opportunities',
      },
      form: {
        name: 'Name', email: 'Email', subject: 'Subject', message: 'Message',
        namePlaceholder: 'John Doe',
        emailPlaceholder: 'john@example.com',
        subjectPlaceholder: 'Project discussion...',
        messagePlaceholder: 'Tell me about your project...',
        send: 'Send Message →',
        sending: 'Sending...',
        sent: '✓ Message Sent!',
        networkError: 'Network error. Please try again.',
        failedSend: 'Failed to send. Please try again.',
      },
    },
    footer: {
      links: ['Home', 'About', 'Projects', 'Contact'],
    },
  },

  id: {
    nav: {
      about: 'Tentang',
      skills: 'Keahlian',
      projects: 'Proyek',
      contact: 'Kontak',
      hireMe: 'Rekrut Saya',
    },
    hero: {
      badge: 'Tersedia untuk freelance & penuh waktu',
      greeting: 'Hai, Saya',
      roles: ['Full Stack Developer', 'Penggemar UI/UX', 'Ahli Vue.js', 'Laravel Developer', 'Pemecah Masalah'],
      desc: 'Saya membuat pengalaman digital yang indah dan berperforma tinggi, memadukan desain elegan dengan rekayasa yang solid.',
      viewWork: 'Lihat Karya Saya',
      getInTouch: 'Hubungi Saya',
      stats: { yearsExp: 'Tahun Pengalaman', projects: 'Proyek', clients: 'Klien' },
      scrollDown: 'Gulir ke bawah',
    },
    about: {
      title: 'Tentang Saya',
      subtitle: 'Kenali lebih jauh',
      heading: 'Developer Bersemangat & Pemikir Kreatif',
      p1: 'Halo! Saya Ian, seorang Full Stack Developer dengan pengalaman 2+ tahun membangun aplikasi web modern. Saya mengkhususkan diri di <span class="text-violet-500 font-semibold">Vue.js</span> dan <span class="text-cyan-500 font-semibold">Laravel</span>, menciptakan pengalaman pengguna yang mulus dengan arsitektur yang solid.',
      p2: 'Ketika tidak sedang coding, saya menjelajahi teknologi baru, berkontribusi ke open source, atau membimbing developer junior. Saya percaya perangkat lunak yang baik dibangun di persimpangan teknologi dan empati.',
      downloadResume: 'Unduh Resume',
      info: { location: 'Lokasi', education: 'Pendidikan', experience: 'Pengalaman', languages: 'Bahasa' },
    },
    skills: {
      title: 'Keahlian & Alat',
      subtitle: 'Yang saya gunakan',
      softTitle: 'Keahlian Non-Teknis',
      categories: {
        Frontend: 'Frontend', Language: 'Bahasa', Backend: 'Backend',
        Styling: 'Desain', Database: 'Database', Tools: 'Alat',
        Cloud: 'Cloud', Hosting: 'Hosting',
      },
      soft: ['Pemecahan Masalah', 'Kerja Tim', 'Tinjauan Kode', 'Agile/Scrum', 'Mentoring', 'Penulisan Teknis', 'Pemikiran UI/UX', 'Kode Bersih'],
    },
    projects: {
      title: 'Proyek Unggulan',
      subtitle: 'Yang telah saya buat',
      empty: 'Belum ada proyek di kategori ini.',
      addFirst: 'Tambah Proyek Pertama',
      addProject: 'Tambah Proyek',
      liveDemo: 'Demo Langsung →',
      clickEdit: '✏️ Klik untuk edit',
    },
    contact: {
      title: 'Hubungi Saya',
      subtitle: 'Mari bekerja sama',
      heading: 'Mari buat sesuatu yang luar biasa bersama',
      desc: 'Apakah kamu punya proyek, ingin berkolaborasi, atau sekadar menyapa — inbox saya selalu terbuka. Saya akan membalas dalam 24 jam!',
      items: {
        email: 'Email', location: 'Lokasi',
        availability: 'Ketersediaan', availabilityValue: 'Terbuka untuk peluang',
      },
      form: {
        name: 'Nama', email: 'Email', subject: 'Subjek', message: 'Pesan',
        namePlaceholder: 'John Doe',
        emailPlaceholder: 'john@example.com',
        subjectPlaceholder: 'Diskusi proyek...',
        messagePlaceholder: 'Ceritakan proyekmu...',
        send: 'Kirim Pesan →',
        sending: 'Mengirim...',
        sent: '✓ Pesan Terkirim!',
        networkError: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
        failedSend: 'Gagal mengirim. Silakan coba lagi.',
      },
    },
    footer: {
      links: ['Beranda', 'Tentang', 'Proyek', 'Kontak'],
    },
  },
}

export function t(key) {
  const keys = key.split('.')
  let val = messages[locale.value]
  for (const k of keys) {
    if (val == null) return key
    val = val[k]
  }
  return val ?? key
}
