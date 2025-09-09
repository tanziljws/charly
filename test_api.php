<?php
/**
 * Simple API Testing Script
 * Test all API endpoints for Gallery Sekolah
 */

// Base URL - adjust according to your local setup
$baseUrl = 'http://localhost/web_gallery/laravel/public/api/v1';

// Test results storage
$results = [];

/**
 * Make HTTP request
 */
function makeRequest($url, $method = 'GET', $data = null) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json'
            ]);
            
        }
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    return [
        'status_code' => $httpCode,
        'response' => $response,
        'error' => $error
    ];
}

/**
 * Test endpoint
 */
function testEndpoint($name, $url, $method = 'GET', $data = null, $expectedCode = 200) {
    global $results;
    
    echo "Testing: $name\n";
    echo "URL: $url\n";
    
    $result = makeRequest($url, $method, $data);
    
    $success = ($result['status_code'] == $expectedCode && empty($result['error']));
    
    $results[] = [
        'name' => $name,
        'url' => $url,
        'method' => $method,
        'expected_code' => $expectedCode,
        'actual_code' => $result['status_code'],
        'success' => $success,
        'error' => $result['error'],
        'response_preview' => substr($result['response'], 0, 200)
    ];
    
    echo "Status: " . ($success ? "✅ PASS" : "❌ FAIL") . "\n";
    echo "HTTP Code: {$result['status_code']} (Expected: $expectedCode)\n";
    
    if (!empty($result['error'])) {
        echo "Error: {$result['error']}\n";
    }
    
    if ($result['response']) {
        $decoded = json_decode($result['response'], true);
        if ($decoded) {
            echo "Response Preview: " . json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
        }
    }
    
    echo str_repeat("-", 80) . "\n\n";
    
    return $success;
}

echo "=== API TESTING FOR GALLERY SEKOLAH ===\n\n";

// Test Kategori Berita Endpoints
echo "📂 TESTING KATEGORI BERITA ENDPOINTS\n\n";

testEndpoint(
    'Get All Kategori Berita', 
    "$baseUrl/kategori-berita"
);

testEndpoint(
    'Get Public Kategori Berita', 
    "$baseUrl/public/kategori-berita"
);

// Test Berita Endpoints
echo "📰 TESTING BERITA ENDPOINTS\n\n";

testEndpoint(
    'Get All Berita', 
    "$baseUrl/berita"
);

testEndpoint(
    'Get Public Berita', 
    "$baseUrl/public/berita"
);

// Test Gallery Endpoints
echo "🖼️ TESTING GALLERY ENDPOINTS\n\n";

testEndpoint(
    'Get All Gallery', 
    "$baseUrl/gallery"
);

testEndpoint(
    'Get Public Gallery', 
    "$baseUrl/public/gallery"
);

testEndpoint(
    'Get Gallery Kategori', 
    "$baseUrl/gallery-kategori"
);

testEndpoint(
    'Get Public Gallery Kategori', 
    "$baseUrl/public/gallery-kategori"
);

// Summary
echo "=== TEST SUMMARY ===\n\n";

$totalTests = count($results);
$passedTests = array_filter($results, function($r) { return $r['success']; });
$failedTests = array_filter($results, function($r) { return !$r['success']; });

echo "Total Tests: $totalTests\n";
echo "Passed: " . count($passedTests) . " ✅\n";
echo "Failed: " . count($failedTests) . " ❌\n";
echo "Success Rate: " . round((count($passedTests) / $totalTests) * 100, 2) . "%\n\n";

if (!empty($failedTests)) {
    echo "FAILED TESTS:\n";
    foreach ($failedTests as $test) {
        echo "- {$test['name']} (HTTP {$test['actual_code']})\n";
        if ($test['error']) {
            echo "  Error: {$test['error']}\n";
        }
    }
}

echo "\n=== END OF TESTING ===\n";
