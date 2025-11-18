# Railway Deployment Guide

## Setup Storage untuk Gambar

### Masalah: Error 403 pada Gambar

Jika Anda mendapatkan error 403 saat mengakses gambar, ini biasanya karena:
1. Storage link belum dibuat
2. File gambar tidak ada di Railway (karena tidak di-commit ke git)

### Solusi

#### 1. Storage Link (Otomatis)
Aplikasi sudah dikonfigurasi untuk membuat storage link otomatis saat boot. Jika masih error, jalankan:
```bash
php artisan storage:link
```

#### 2. Upload File Gambar

**Opsi A: Upload via Admin Panel (Disarankan)**
1. Login ke admin panel: `/admin`
2. Upload gambar melalui form Gallery atau Berita
3. File akan otomatis tersimpan di `storage/app/public/`

**Opsi B: Copy File ke Railway (Jika punya akses)**
```bash
# Via Railway CLI
railway run bash
# Kemudian copy file dari local atau upload via admin panel
```

**Opsi C: Import dari Database**
File gambar yang sudah ada di database perlu di-upload ulang melalui admin panel karena file fisik tidak di-commit ke git.

### File yang Perlu Di-upload

Berdasarkan database, file-file berikut perlu di-upload:
- `gallery/1763274865_WhatsAppImage2025-11-16at13.29.02.jpeg`
- `gallery/1763274609_WhatsAppImage2025-11-16at13.26.37.jpeg`
- `gallery/1763275591_WhatsAppImage2025-11-16at13.42.49.jpeg`
- `gallery/PXOzMbsxGoJQRn5IGVK36IUZOii87sabS6E8iIGz.jpg`
- `gallery/1763275563_WhatsAppImage2025-11-16at13.42.41.jpeg`
- `gallery/1763275926_WhatsAppImage2025-11-16at13.50.14.jpeg`
- `gallery/PboFslFSiRZNXUArthG3C2HSlANuYWESRYjlJWkd.jpg`
- `gallery/1763277823_WhatsAppImage2025-11-16at14.22.34.jpeg`

### Route Storage

Aplikasi sudah memiliki route khusus untuk serve file dari storage:
- Route: `/storage/{path}`
- Lokasi: `routes/web.php`
- Fungsi: Serve file dari `storage/app/public/` jika symlink tidak bekerja

### Verifikasi

Setelah deployment, verifikasi:
1. Storage link ada: `ls -la public/storage`
2. File gambar ada: `ls -la storage/app/public/gallery/`
3. Test akses: Buka URL gambar di browser

### Troubleshooting

**Error 403:**
- Pastikan storage link dibuat: `php artisan storage:link`
- Pastikan file ada di `storage/app/public/`
- Pastikan permission benar: `chmod -R 775 storage`

**Error 404:**
- File tidak ada, perlu di-upload via admin panel
- Atau copy file dari local ke Railway

**Storage link tidak bekerja:**
- Route `/storage/{path}` akan otomatis serve file
- Tidak perlu symlink jika route ini bekerja

