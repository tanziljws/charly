<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake('id_ID');

        $kategoriIds = KategoriBerita::pluck('id');
        if ($kategoriIds->isEmpty()) {
            $this->command->warn('KategoriBerita is empty. Skipping BeritaDummySeeder.');
            return;
        }

        $user = User::first();
        if (!$user) {
            $this->command->warn('No users found. Skipping BeritaDummySeeder.');
            return;
        }

        // Purge existing records and images
        $this->command->info('Purging existing Berita and images...');
        foreach (Berita::whereNotNull('gambar_utama')->get() as $old) {
            if (!empty($old->gambar_utama)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($old->gambar_utama);
            }
        }
        Berita::query()->delete();
        // Reset directory for clean images
        \Illuminate\Support\Facades\Storage::disk('public')->deleteDirectory('berita');
        \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('berita');

        $schoolTopics = [
            'Pengumuman Penerimaan Siswa Baru',
            'Prestasi Olimpiade Sains Tingkat Kabupaten',
            'Kegiatan MPLS Siswa Baru',
            'Workshop Guru: Kurikulum Merdeka',
            'Lomba Futsal Antar Kelas',
            'Ekstrakurikuler Pramuka Mengadakan Perkemahan Sabtu Minggu',
            'Peresmian Laboratorium Komputer Baru',
            'Kunjungan Industri Siswa Kelas XII',
            'Pentas Seni Akhir Tahun',
            'Pelatihan Literasi Digital untuk Siswa',
            'Bakti Sosial OSIS di Panti Asuhan',
            'Pelantikan Pengurus OSIS Periode Baru',
            'Sosialisasi Anti Perundungan di Sekolah',
            'Kelas Inspirasi: Alumni Berbagi Pengalaman',
            'Pameran Karya Siswa',
            'Ujian Praktik Kejuruan Berjalan Lancar',
            'Simulasi Ujian Berbasis Komputer',
            'Penanaman Seribu Pohon di Sekitar Sekolah',
            'Juara 1 Lomba Paduan Suara',
            'Pelatihan Kewirausahaan untuk Siswa',
            'Peringatan Hari Guru Nasional',
            'Kegiatan Jumat Bersih Bersama',
            'Donor Darah di Aula Sekolah',
            'Rapat Orang Tua Murid Semester Genap',
            'Kegiatan Class Meeting Menutup Semester'
        ];

        for ($i = 1; $i <= 25; $i++) {
            $baseTitle = $schoolTopics[$i - 1];
            $title = $baseTitle;
            $slug = Str::slug($title . '-' . Str::random(6));

            // Download placeholder image
            // Use Unsplash source with school-related query
            $imageUrl = 'https://source.unsplash.com/800x450/?school,students,classroom&sig=' . $i;
            $imageContents = @file_get_contents($imageUrl);
            $storedPath = null;
            if ($imageContents !== false) {
                $extension = 'jpg';
                $fileName = $slug . '.' . $extension;
                $storedPath = 'berita/' . $fileName;
                Storage::disk('public')->put($storedPath, $imageContents);
            }

            $statusOptions = ['draft', 'published', 'archived'];
            $status = $statusOptions[array_rand($statusOptions)];
            $publishedAt = $status === 'published' ? now()->subDays(rand(0, 90)) : null;

            Berita::create([
                'judul' => $title,
                'slug' => $slug,
                'konten' => $faker->paragraphs(rand(5, 10), true),
                'excerpt' => null,
                'gambar_utama' => $storedPath,
                'kategori_berita_id' => $kategoriIds->random(),
                'user_id' => $user->id,
                'status' => $status,
                'published_at' => $publishedAt,
                'views' => rand(0, 5000),
                'is_featured' => (bool)rand(0, 1),
                'tags' => ['sekolah', 'siswa', 'kegiatan'],
                'meta_description' => $faker->text(155),
            ]);
        }

        $this->command->info('Purged and inserted 25 school-relevant Berita records.');
    }
}


