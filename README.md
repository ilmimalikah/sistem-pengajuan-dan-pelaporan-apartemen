# Sistem Pelaporan Fasilitas Apartemen

Aplikasi web untuk mengelola pengajuan dan pelaporan permasalahan fasilitas
apartemen, meliputi kerusakan fasilitas, kelistrikan, kebersihan, dan keamanan.

## Fungsi Website

- Penghuni dapat mengajukan laporan permasalahan fasilitas.
- Penghuni dapat memantau status dan perkembangan laporannya.
- Admin dapat mengelola laporan dan memperbarui statusnya.
- Admin dapat mencatat tindak lanjut dan melihat riwayat perubahan status.
- Admin dapat melihat statistik pelaporan melalui dashboard.

## Role Pengguna

| Role | Hak Akses |
|------|-----------|
| Penghuni | Membuat laporan, melihat laporan sendiri, memantau status |
| Admin | Mengelola laporan, fasilitas, kategori, lokasi, dan melihat statistik |

## Pembagian Modul

| Anggota | Modul |
|---------|-------|
| Ilmi | Database, Autentikasi, dan Manajemen Fasilitas (Backend) |
| Thomas | Pelaporan oleh Penghuni (Frontend) |
| Dimas | Manajemen dan Penanganan Laporan oleh Admin |
| Achmed | Dashboard dan Manajemen Data Pendukung |

## Pembagian Fitur

### Ilmi
- Migration, model, relasi, dan seeder
- Login, register, logout, middleware role
- CRUD fasilitas

### Thomas
- Pembuatan laporan (fasilitas, lokasi, kategori, deskripsi)
- Daftar, detail, dan status laporan milik sendiri
- Filter dan pencarian laporan

### Dimas
- Daftar dan detail seluruh laporan
- Filter dan pencarian laporan
- Update status (Menunggu, Diproses, Selesai, Ditolak)
- Catatan tindak lanjut dan riwayat status

### Achmed
- Dashboard penghuni dan admin
- Statistik laporan per status, kategori, dan fasilitas
- CRUD kategori masalah dan lokasi
