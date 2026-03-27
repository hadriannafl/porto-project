<x-mail::message>
# Pesan Baru dari Portfolio 👋

Halo **Ian**, kamu mendapat pesan baru dari portfolio kamu!

---

| | |
|---|---|
| **Dari** | {{ $senderName }} |
| **Email** | {{ $senderEmail }} |
| **Subjek** | {{ $mailSubject }} |

---

**Pesan:**

{{ $messageBody }}

---

<x-mail::button :url="'mailto:' . $senderEmail">
Balas {{ $senderName }}
</x-mail::button>

Salam,
**IanDev**
</x-mail::message>
