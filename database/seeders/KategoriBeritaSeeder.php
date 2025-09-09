<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Akademik', 'deskripsi' => 'Berita seputar kegiatan belajar mengajar dan kurikulum.'],
            ['nama_kategori' => 'Prestasi', 'deskripsi' => 'Informasi mengenai pencapaian dan prestasi siswa/sekolah.'],
            ['nama_kategori' => 'Ekstrakurikuler', 'deskripsi' => 'Kegiatan di luar jam pelajaran seperti olahraga, seni, dll.'],
            ['nama_kategori' => 'Pengumuman', 'deskripsi' => 'Informasi dan pengumuman penting dari sekolah.'],
            ['nama_kategori' => 'Acara Sekolah', 'deskripsi' => 'Liputan acara dan kegiatan yang diselenggarakan sekolah.'],
        ];

        foreach ($kategoris as $kategori) {
            \App\Models\KategoriBerita::create($kategori);
        }
    }
}
