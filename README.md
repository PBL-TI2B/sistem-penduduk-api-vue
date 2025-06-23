# 🌾 E-Desa - Sistem Informasi Desa Digital

**E-Desa** adalah aplikasi web terpadu untuk digitalisasi tata kelola desa. Platform ini mengintegrasikan backend Laravel API dan frontend berbasis Inertia.js + Vue 3 dengan UI modern menggunakan Tailwind CSS dan ShadCN.

Dirancang untuk meningkatkan efisiensi, transparansi, dan aksesibilitas data desa bagi perangkat desa dan masyarakat.

---

## 🧰 Teknologi yang Digunakan

| Layer       | Teknologi                        |
|-------------|----------------------------------|
| Backend     | Laravel (RESTful API)            |
| Frontend    | Inertia.js + Vue 3               |
| Styling     | Tailwind CSS                     |
| UI Components | ShadCN (Vue-compatible port)   |
| Auth        | Sanctum (API token authentication) |
| Database    | MySQL / MariaDB                  |

---

## 👥 Role & Hak Akses

Aplikasi ini menggunakan sistem multi-role:

- 🔑 **Superadmin**: Akses penuh terhadap seluruh sistem dan data desa lintas wilayah.
- 🛠️ **Admin Desa**: Mengelola konten dan data desa lokal.
- 🧍‍♂️ **RT**: Akses terbatas pada data penduduk wilayah RT masing-masing.
- 🧍‍♂️ **RW**: Akses terbatas pada data penduduk wilayah RW masing-masing.

---

## 🌐 Halaman Publik

Dapat diakses tanpa login:

- 🏠 Landing Page
- 🏘️ Profil Desa
- 📊 Infografis Desa
- 📰 Berita Terbaru
- 🖼️ Galeri Foto & Video

---

## 📦 Fitur Manajemen Data

### 👤 Manajemen Penduduk
- Tambah/Edit penduduk
- Data **kelahiran** dan **kematian**

### 👪 Manajemen Keluarga
- Hubungan keluarga
- KK (Kartu Keluarga)

### 🧑‍🌾 Manajemen Perangkat Desa
- Tambah/edit jabatan dan perangkat aktif

### 🗺️ Manajemen Data Desa
- Wilayah, dusun, RT/RW
- Statistik dasar desa

### 📰 Manajemen Konten Web
- **Berita** (artikel, thumbnail, slug unik)
- **Galeri** (gambar/video)

### 🎓 Manajemen Pendidikan & Pekerjaan
- Data pendidikan penduduk
- Kategori pekerjaan & statistik

### 🤝 Manajemen Bantuan & User
- Distribusi bantuan sosial
- Pengguna dan akses role-based

---

## 🛠 Instalasi & Setup

### 1. Clone Repository

```bash
git clone https://github.com/username/e-desa.git
cd e-desa
