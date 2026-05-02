# OSI Layer Explorer — Simulasi Interaktif Model OSI

OSI Layer Explorer adalah platform edukasi interaktif berbasis web yang dirancang untuk membantu mahasiswa, pelajar, dan penggemar IT memahami konsep **OSI (Open Systems Interconnection) Model** dengan cara yang visual dan interaktif.

Proyek ini mendemonstrasikan secara *real-time* bagaimana data mengalir dari *Application Layer* hingga ke *Physical Layer* (enkapsulasi), dikirim melalui media transmisi, dan diterima kembali dari *Physical Layer* ke *Application Layer* (dekapsulasi).

## 🚀 Fitur Utama

- **Visualisasi Interaktif 7 Layer OSI:** Menampilkan penjelasan detail untuk setiap layer (Application, Presentation, Session, Transport, Network, Data Link, Physical).
- **Simulasi Pengiriman Data Real-Time:** 
  - Pengguna dapat memasukkan pesan kustom.
  - Memilih protokol (HTTP, FTP, SMTP, DNS).
  - Melihat proses *encapsulation* dan *decapsulation* secara bertahap.
  - Log proses yang merekam setiap aktivitas per layer.
- **Visualisasi Enkapsulasi:** Melihat bagaimana PDU (*Protocol Data Unit*) terbentuk dengan penambahan header/trailer di setiap layer.
- **Kuis Interaktif (Quiz):** Menguji pemahaman pengguna tentang Model OSI dengan pertanyaan dinamis.
- **Desain Modern & Responsif:** Antarmuka yang indah dengan efek partikel latar belakang, *glassmorphism*, dan transisi mulus, dioptimalkan untuk desktop dan seluler.

## 🛠️ Teknologi yang Digunakan

- **Frontend:**
  - HTML5 (Semantic Structure)
  - CSS3 (Custom Properties, Flexbox, Grid, Animations, Glassmorphism)
  - Vanilla JavaScript (DOM Manipulation, AJAX/Fetch API, Canvas API untuk efek partikel)
- **Backend:**
  - PHP 8.x (Menyediakan API untuk data layer, simulasi, dan kuis)
- **Lingkungan Pengembangan:** Laragon / XAMPP (Local Server)

## 📂 Struktur Direktori

```text
osi/
├── api/
│   ├── layers.php       # Endpoint API untuk mengambil detail informasi setiap layer OSI
│   ├── quiz.php         # Endpoint API untuk mengambil daftar pertanyaan kuis
│   └── simulate.php     # Endpoint API untuk memproses simulasi logik enkapsulasi
├── assets/
│   ├── css/
│   │   └── style.css    # Styling utama aplikasi (UI/UX)
│   └── js/
│       ├── app.js       # Logika utama UI (Navigasi, dynamic loading layer, quiz)
│       ├── particles.js # Logika untuk animasi canvas partikel background
│       └── simulation.js# Logika khusus untuk animasi dan interaksi simulasi pengiriman data
├── index.php            # Halaman utama (Single Page Application interface)
└── README.md            # Dokumentasi proyek (File ini)
```

## ⚙️ Cara Instalasi & Menjalankan Proyek

Karena proyek ini menggunakan PHP untuk backend (API), Anda memerlukan *web server* lokal yang mendukung PHP seperti **Laragon**, **XAMPP**, atau **MAMP**.

1. **Clone atau Unduh Repository:**
   Letakkan folder `osi` ke dalam *document root* server lokal Anda.
   - Laragon: `C:\laragon\www\osi`
   - XAMPP: `C:\xampp\htdocs\osi`

2. **Jalankan Web Server:**
   Pastikan service **Apache** atau **Nginx** sudah berjalan. Anda tidak perlu mengkonfigurasi database (MySQL/MariaDB) karena aplikasi ini menggunakan array statis dalam PHP untuk sementara, atau dapat dikembangkan dengan database di masa depan.

3. **Akses Melalui Browser:**
   Buka browser Anda dan akses URL berikut:
   `http://localhost/osi/` atau `http://osi.test/` (jika menggunakan auto-virtual host Laragon).

## 🎮 Cara Menggunakan

1. **Mempelajari Teori:** Scroll ke bagian **7 Layers** dan klik masing-masing blok layer di sebelah kiri untuk membaca definisi, PDU, protokol, dan perangkat yang relevan di sebelah kanan.
2. **Melakukan Simulasi:**
   - Scroll ke bagian **Simulasi Pengiriman Data**.
   - Ketikkan pesan (misal: "Halo Dunia").
   - Pilih Protokol (misal: HTTP).
   - Atur kecepatan simulasi.
   - Klik **"Mulai Simulasi"** dan perhatikan animasi di panel Pengirim, Media Transmisi, dan Penerima.
   - Cek **Log Proses** dan **Visualisasi Enkapsulasi Data** untuk memahami PDU (*Segment, Packet, Frame, Bits*).
3. **Mengambil Kuis:** Buka bagian **Quiz**, klik "Mulai Quiz" dan jawab pertanyaan-pertanyaan yang disediakan untuk mengetes pemahaman Anda.

## 🤝 Kontribusi

Jika Anda ingin mengembangkan atau menambahkan fitur baru, silakan lakukan fork pada repository ini dan buat *Pull Request*. Saran perbaikan UI/UX atau optimasi *mobile responsive* sangat diterima.

## 📝 Lisensi

Proyek ini dibuat untuk tujuan edukasi dan pembelajaran. Jangan ragu untuk memodifikasi dan menggunakannya.
