<?php
/**
 * Simple Test untuk Website Gallery Sekolah
 */

echo "=== TEST WEBSITE GALLERY SEKOLAH ===\n\n";

// Test 1: Cek struktur file penting
echo "1. Checking File Structure...\n";

$requiredFiles = [
    'app/Models/Berita.php',
    'app/Models/Gallery.php', 
    'app/Models/KategoriBerita.php',
    'app/Http/Controllers/Admin/BeritaController.php',
    'app/Http/Controllers/Admin/GalleryController.php',
    'app/Http/Controllers/Admin/KategoriBeritaController.php',
    'app/Http/Controllers/Api/BeritaController.php',
    'app/Http/Controllers/Api/GalleryController.php',
    'app/Http/Controllers/Api/KategoriBeritaController.php',
    'resources/views/layouts/admin.blade.php',
    'resources/views/admin/dashboard.blade.php',
    'routes/web.php',
    'routes/api.php'
];

$missingFiles = [];
foreach ($requiredFiles as $file) {
    if (file_exists($file)) {
        echo "✅ $file\n";
    } else {
        echo "❌ $file\n";
        $missingFiles[] = $file;
    }
}

// Test 2: Cek Views Admin
echo "\n2. Checking Admin Views...\n";

$adminViews = [
    'resources/views/admin/berita/index.blade.php',
    'resources/views/admin/berita/create.blade.php', 
    'resources/views/admin/berita/edit.blade.php',
    'resources/views/admin/berita/show.blade.php',
    'resources/views/admin/gallery/index.blade.php',
    'resources/views/admin/gallery/create.blade.php',
    'resources/views/admin/gallery/edit.blade.php',
    'resources/views/admin/gallery/show.blade.php',
    'resources/views/admin/kategori-berita/index.blade.php',
    'resources/views/admin/kategori-berita/create.blade.php',
    'resources/views/admin/kategori-berita/edit.blade.php',
    'resources/views/admin/kategori-berita/show.blade.php'
];

$missingViews = [];
foreach ($adminViews as $view) {
    if (file_exists($view)) {
        echo "✅ $view\n";
    } else {
        echo "❌ $view\n";
        $missingViews[] = $view;
    }
}

// Test 3: Cek Migration Files
echo "\n3. Checking Migration Files...\n";

$migrationDir = 'database/migrations';
if (is_dir($migrationDir)) {
    $migrations = glob($migrationDir . '/*.php');
    foreach ($migrations as $migration) {
        $filename = basename($migration);
        if (strpos($filename, 'kategori_beritas') !== false ||
            strpos($filename, 'beritas') !== false ||
            strpos($filename, 'galleries') !== false) {
            echo "✅ $filename\n";
        }
    }
} else {
    echo "❌ Migration directory not found\n";
}

// Summary
echo "\n=== SUMMARY ===\n";
echo "Missing Files: " . count($missingFiles) . "\n";
echo "Missing Views: " . count($missingViews) . "\n";

if (empty($missingFiles) && empty($missingViews)) {
    echo "🎉 ALL FILES COMPLETE!\n";
} else {
    echo "⚠️  Some files are missing\n";
}

echo "\n=== NEXT STEPS ===\n";
echo "1. Copy .env.example to .env\n";
echo "2. Run: php artisan key:generate\n";
echo "3. Configure database in .env\n";
echo "4. Run: php artisan migrate\n";
echo "5. Run: php artisan serve\n";
echo "6. Access: http://localhost:8000/admin\n";

echo "\n=== END TEST ===\n";
