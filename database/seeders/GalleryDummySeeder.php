<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake('id_ID');
        $user = User::first();
        if (!$user) {
            $this->command->warn('No users found. Skipping GalleryDummySeeder.');
            return;
        }

        // Purge existing records and images
        $this->command->info('Purging existing Gallery and images...');
        foreach (Gallery::whereNotNull('gambar')->get() as $old) {
            if (!empty($old->gambar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($old->gambar);
            }
        }
        Gallery::query()->delete();
        \Illuminate\Support\Facades\Storage::disk('public')->deleteDirectory('gallery');
        \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('gallery');

        $kategoriOptions = ['kegiatan_sekolah', 'prestasi', 'fasilitas', 'acara_khusus', 'lainnya'];

        $titles = [
            'Upacara Bendera Hari Senin',
            'Latihan Paskibra di Lapangan',
            'Kegiatan Prakarya Kelas VII',
            'Perpustakaan Baru yang Nyaman',
            'Ruang Kelas Bersih dan Tertata',
            'Tim Basket Bertanding di Turnamen',
            'Lomba Cerdas Cermat Tingkat Sekolah',
            'Ekstrakurikuler Musik Keroncong',
            'Laboratorium Sains dalam Praktikum',
            'Kantin Sehat Sekolah',
            'Kegiatan Pramuka Latihan Pionering',
            'Kunjungan Alumni Memberi Motivasi',
            'Pojok Literasi di Koridor',
            'Pentas Seni Tari Tradisional',
            'Ruang UKS Siaga',
            'Taman Sekolah Asri dan Hijau',
            'Penghijauan di Halaman Sekolah',
            'Workshop Komputer Dasar',
            'Juara 1 Lomba Mading 3D',
            'Bazar Kewirausahaan Siswa',
            'Ekskul Fotografi Menangkap Momen',
            'Kegiatan Class Meeting',
            'Pelatihan PMR',
            'Kelas Inspirasi Bersama Alumni',
            'Pameran Karya Seni Siswa'
        ];

        for ($i = 1; $i <= 25; $i++) {
            $title = $titles[$i - 1];
            $slug = Str::slug($title . '-' . Str::random(6));

            // Download placeholder image (square-ish)
            $imageUrl = 'https://source.unsplash.com/800x800/?school,student,education&sig=' . $i;
            $imageContents = @file_get_contents($imageUrl);
            $storedPath = null;
            if ($imageContents !== false) {
                $extension = 'jpg';
                $fileName = $slug . '.' . $extension;
                $storedPath = 'gallery/' . $fileName;
                Storage::disk('public')->put($storedPath, $imageContents);
            }

            Gallery::create([
                'judul' => $title,
                'slug' => $slug,
                'deskripsi' => $faker->paragraph(2),
                'gambar' => $storedPath,
                'kategori' => $kategoriOptions[array_rand($kategoriOptions)],
                'user_id' => $user->id,
                'is_active' => (bool)rand(0, 1),
                'urutan' => $i,
                'tanggal_foto' => now()->subDays(rand(0, 365))->toDateString(),
                'tags' => ['sekolah', 'kegiatan'],
            ]);
        }

        $this->command->info('Purged and inserted 25 school-relevant Gallery records.');
    }
}


