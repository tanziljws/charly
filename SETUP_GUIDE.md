# 🎓 Website Gallery Sekolah - Setup Guide

## 📋 Prerequisites
- PHP 8.1 atau lebih tinggi
- Composer
- MySQL/MariaDB atau SQLite
- Web server (Apache/Nginx) atau gunakan built-in PHP server

## 🚀 Quick Setup

### 1. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 2. Database Configuration
Edit file `.env` dan sesuaikan konfigurasi database:

**Untuk MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gallery_sekolah
DB_USERNAME=root
DB_PASSWORD=
```

**Untuk SQLite (default):**
```env
DB_CONNECTION=sqlite
```

### 3. Database Migration
```bash
# Jalankan migration
php artisan migrate

# (Opsional) Seed data dummy
php artisan db:seed
```

### 4. Storage Setup
```bash
# Link storage untuk upload gambar
php artisan storage:link
```

### 5. Run Application
```bash
# Development server
php artisan serve

# Akses aplikasi di: http://localhost:8000
```

## 📁 Struktur Aplikasi

### Admin Panel
- **URL**: `/admin`
- **Dashboard**: `/admin/dashboard`
- **Kategori Berita**: `/admin/kategori-berita`
- **Berita**: `/admin/berita`
- **Gallery**: `/admin/gallery`

### API Endpoints
- **Base URL**: `/api/v1`
- **Public API**: `/api/v1/public`

#### Berita API
```
GET    /api/v1/berita              # List semua berita
POST   /api/v1/berita              # Tambah berita baru
GET    /api/v1/berita/{id}         # Detail berita
PUT    /api/v1/berita/{id}         # Update berita
DELETE /api/v1/berita/{id}         # Hapus berita

# Public endpoints
GET    /api/v1/public/berita       # List berita public
GET    /api/v1/public/berita/{slug} # Detail berita public
```

#### Gallery API
```
GET    /api/v1/gallery             # List semua gallery
POST   /api/v1/gallery             # Tambah gallery baru
GET    /api/v1/gallery/{id}        # Detail gallery
PUT    /api/v1/gallery/{id}        # Update gallery
DELETE /api/v1/gallery/{id}        # Hapus gallery

# Public endpoints
GET    /api/v1/public/gallery      # List gallery public
GET    /api/v1/public/gallery/{slug} # Detail gallery public
```

#### Kategori Berita API
```
GET    /api/v1/kategori-berita     # List kategori
POST   /api/v1/kategori-berita     # Tambah kategori
GET    /api/v1/kategori-berita/{id} # Detail kategori
PUT    /api/v1/kategori-berita/{id} # Update kategori
DELETE /api/v1/kategori-berita/{id} # Hapus kategori
```

## 🎨 Fitur Utama

### Admin Panel Features
- ✅ Dashboard dengan statistik
- ✅ Manajemen kategori berita (CRUD)
- ✅ Manajemen berita (CRUD) dengan status dan featured
- ✅ Manajemen gallery (CRUD) dengan kategori
- ✅ Upload gambar dengan preview
- ✅ Auto-generate slug
- ✅ Tags system
- ✅ Views counter
- ✅ Filter dan pencarian

### API Features
- ✅ RESTful API untuk semua resource
- ✅ Public API untuk frontend
- ✅ JSON responses
- ✅ Error handling
- ✅ Validation

### Gallery Categories
- `kegiatan_sekolah` - Kegiatan Sekolah
- `prestasi` - Prestasi
- `fasilitas` - Fasilitas
- `acara_khusus` - Acara Khusus
- `lainnya` - Lainnya

### Berita Status
- `draft` - Draft (belum dipublikasi)
- `published` - Published (dipublikasi)
- `archived` - Archived (diarsipkan)

## 🔧 Testing

### Manual Testing
```bash
# Test file structure
php test_simple.php

# Test API endpoints
php test_api.php
```

### Browser Testing
1. Akses admin panel: `http://localhost:8000/admin`
2. Test CRUD operations untuk setiap module
3. Test upload gambar
4. Test API endpoints dengan Postman/curl

## 📝 File Upload

### Supported Formats
- **Berita**: JPG, PNG, GIF (max 2MB)
- **Gallery**: JPG, PNG, GIF (max 5MB)

### Storage Path
- Uploaded files: `storage/app/public/`
- Public access: `public/storage/`

## 🛠️ Troubleshooting

### Common Issues

**1. Storage link error**
```bash
php artisan storage:link
```

**2. Permission errors**
```bash
chmod -R 755 storage bootstrap/cache
```

**3. Database connection error**
- Check `.env` database configuration
- Ensure database exists
- Check database credentials

**4. Key not set error**
```bash
php artisan key:generate
```

## 📚 Development Notes

### Models & Relationships
- `KategoriBerita` hasMany `Berita`
- `Berita` belongsTo `KategoriBerita`
- `Gallery` standalone model
- All models use soft deletes where appropriate

### Validation Rules
- Judul: required, max 255 characters
- Slug: unique, auto-generated if empty
- Gambar: image file, size limits apply
- Status: enum values only

### Security Features
- CSRF protection
- File upload validation
- SQL injection protection via Eloquent
- XSS protection via Blade templating

## 🎯 Next Steps

1. **Frontend Development**: Build public website using API
2. **Authentication**: Add user login/registration
3. **Permissions**: Role-based access control
4. **SEO**: Meta tags and sitemap
5. **Performance**: Caching and optimization

---

**Created by**: Cascade AI Assistant  
**Version**: 1.0  
**Date**: 2025-09-08
