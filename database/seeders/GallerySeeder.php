<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = \App\Models\User::first()->id;
        $kategoriOptions = ['kegiatan_sekolah', 'prestasi', 'fasilitas', 'acara_khusus', 'lainnya'];

        $galleries = [
            [
                'judul' => 'Upacara Bendera Hari Kemerdekaan',
                'slug' => 'upacara-bendera-hari-kemerdekaan',
                'deskripsi' => 'Momen khidmat saat upacara bendera memperingati Hari Kemerdekaan RI ke-80.',
                'kategori' => 'acara_khusus',
                'tanggal_foto' => '2025-08-17',
            ],
            [
                'judul' => 'Juara 1 Lomba Cerdas Cermat',
                'slug' => 'juara-1-lomba-cerdas-cermat',
                'deskripsi' => 'Tim cerdas cermat sekolah membawa pulang piala kemenangan.',
                'kategori' => 'prestasi',
                'tanggal_foto' => now()->subDays(10),
            ],
            [
                'judul' => 'Laboratorium Komputer Baru',
                'slug' => 'laboratorium-komputer-baru',
                'deskripsi' => 'Fasilitas laboratorium komputer terbaru dengan perangkat modern untuk menunjang pembelajaran.',
                'kategori' => 'fasilitas',
                'tanggal_foto' => now()->subDays(20),
            ],
            [
                'judul' => 'Pentas Seni Akhir Tahun',
                'slug' => 'pentas-seni-akhir-tahun',
                'deskripsi' => 'Berbagai penampilan bakat siswa dalam acara pentas seni tahunan.',
                'kategori' => 'kegiatan_sekolah',
                'tanggal_foto' => now()->subMonth(),
            ],
            [
                'judul' => 'Class Meeting: Lomba Tarik Tambang',
                'slug' => 'class-meeting-lomba-tarik-tambang',
                'deskripsi' => 'Keseruan siswa saat mengikuti lomba tarik tambang dalam acara class meeting.',
                'kategori' => 'kegiatan_sekolah',
                'tanggal_foto' => now()->subWeeks(2),
            ],
            [
                'judul' => 'Kunjungan Industri ke Pabrik Otomotif',
                'slug' => 'kunjungan-industri-pabrik-otomotif',
                'deskripsi' => 'Siswa jurusan teknik mendapatkan wawasan baru saat kunjungan industri.',
                'kategori' => 'lainnya',
                'tanggal_foto' => now()->subMonths(2),
            ],
        ];

        foreach ($galleries as $item) {
            \App\Models\Gallery::create(array_merge($item, [
                'user_id' => $userId,
                'is_active' => true,
            ]));
        }
    }
}
