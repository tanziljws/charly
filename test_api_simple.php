<?php
/**
 * Simple API Test Script
 * Test basic API endpoints to verify they're working
 */

$baseUrl = 'http://127.0.0.1:8000/api';

// Test endpoints
$endpoints = [
    'Test endpoint' => '/test',
    'Kategori Berita' => '/v1/kategori-berita',
    'Berita' => '/v1/berita',
    'Gallery' => '/v1/gallery',
];

echo "=== API Endpoint Test ===\n\n";

foreach ($endpoints as $name => $endpoint) {
    $url = $baseUrl . $endpoint;
    echo "Testing: $name\n";
    echo "URL: $url\n";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "❌ CURL Error: $error\n";
    } else {
        echo "📊 HTTP Code: $httpCode\n";
        
        if ($httpCode == 200) {
            echo "✅ Success!\n";
            $data = json_decode($response, true);
            if ($data && isset($data['success'])) {
                echo "📄 Response: " . ($data['message'] ?? 'OK') . "\n";
                if (isset($data['data'])) {
                    $count = is_array($data['data']) ? count($data['data']) : 1;
                    echo "📦 Data items: $count\n";
                }
            }
        } else {
            echo "❌ Failed!\n";
            echo "Response: " . substr($response, 0, 200) . "...\n";
        }
    }
    
    echo "\n" . str_repeat("-", 50) . "\n\n";
}

echo "Test completed!\n";
?>
