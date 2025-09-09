<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = \App\Models\KategoriBerita::pluck('id');
        $userId = \App\Models\User::first()->id;

        $berita = [
            [
                'judul' => 'Prestasi Gemilang Tim Robotik di Kompetisi Nasional',
                'slug' => 'prestasi-tim-robotik-nasional',
                'konten' => 'Tim robotik sekolah kita berhasil meraih juara pertama dalam kompetisi robotik tingkat nasional yang diselenggarakan di Jakarta. Mereka mengalahkan puluhan tim dari seluruh Indonesia.',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now(),
                'tags' => 'robotik, prestasi, nasional',
                'meta_description' => 'Kemenangan besar tim robotik sekolah di ajang nasional.',
            ],
            [
                'judul' => 'Penerimaan Siswa Baru Tahun Ajaran 2025/2026 Telah Dibuka',
                'slug' => 'penerimaan-siswa-baru-2025-2026',
                'konten' => 'Pendaftaran untuk siswa baru tahun ajaran 2025/2026 resmi dibuka mulai hari ini. Kunjungi halaman pendaftaran untuk informasi lebih lanjut mengenai jadwal, syarat, dan prosedur.',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDay(),
                'tags' => 'psb, pendaftaran, siswa baru',
                'meta_description' => 'Informasi lengkap mengenai penerimaan siswa baru (PSB) tahun ajaran 2025/2026.',
            ],
            [
                'judul' => 'Workshop Fotografi untuk Siswa Kelas XI',
                'slug' => 'workshop-fotografi-kelas-xi',
                'konten' => 'Akan diadakan workshop fotografi yang akan dibimbing oleh fotografer profesional. Workshop ini bertujuan untuk meningkatkan kreativitas siswa di bidang seni visual.',
                'status' => 'draft',
                'is_featured' => false,
                'published_at' => null,
                'tags' => 'workshop, fotografi, ekstrakurikuler',
                'meta_description' => 'Pengumuman workshop fotografi eksklusif untuk siswa kelas XI.',
            ],
            [
                'judul' => 'Kegiatan Jumat Bersih untuk Lingkungan Sekolah',
                'slug' => 'kegiatan-jumat-bersih',
                'konten' => 'Seluruh siswa dan guru berpartisipasi dalam kegiatan Jumat Bersih untuk menjaga kebersihan dan keindahan lingkungan sekolah. Kegiatan ini rutin diadakan setiap bulan.',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(5),
                'tags' => 'lingkungan, kegiatan, jumat bersih',
                'meta_description' => 'Laporan kegiatan rutin Jumat Bersih di lingkungan sekolah.',
            ],
            [
                'judul' => 'Studi Tur ke Museum Nasional: Belajar Sejarah Langsung',
                'slug' => 'studi-tur-museum-nasional',
                'konten' => 'Siswa kelas X melakukan studi tur edukatif ke Museum Nasional. Mereka belajar banyak tentang sejarah dan warisan budaya Indonesia secara langsung dari artefak yang ada.',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subWeek(),
                'tags' => 'studi tur, museum, sejarah',
                'meta_description' => 'Pengalaman belajar sejarah yang menyenangkan melalui studi tur ke Museum Nasional.',
            ],
            [
                'judul' => 'Renovasi Perpustakaan Sekolah (Diarsipkan)',
                'slug' => 'renovasi-perpustakaan-sekolah-diarsipkan',
                'konten' => 'Informasi mengenai renovasi perpustakaan yang telah selesai pada tahun lalu. Kini perpustakaan hadir dengan wajah baru yang lebih modern dan koleksi buku yang lebih lengkap.',
                'status' => 'archived',
                'is_featured' => false,
                'published_at' => now()->subYear(),
                'tags' => 'perpustakaan, renovasi, fasilitas',
                'meta_description' => 'Arsip berita mengenai renovasi perpustakaan sekolah.',
            ],
        ];

        foreach ($berita as $item) {
            \App\Models\Berita::create(array_merge($item, [
                'kategori_berita_id' => $kategoris->random(),
                'user_id' => $userId,
            ]));
        }
    }
}
