<?php

// Simple API test script for NexShop
echo "=== NexShop API Test ===\n\n";

$baseUrl = 'http://127.0.0.1:8000/api';

function testEndpoint($url, $method = 'GET', $data = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ['code' => $httpCode, 'response' => $response];
}

// Test endpoints
$tests = [
    'Categories' => $baseUrl . '/categories',
    'Products' => $baseUrl . '/products',
    'Featured Products' => $baseUrl . '/products/featured',
    'Cart' => $baseUrl . '/cart',
];

foreach ($tests as $name => $url) {
    echo "Testing $name: ";
    $result = testEndpoint($url);
    
    if ($result['code'] === 200) {
        echo "✅ SUCCESS (HTTP {$result['code']})\n";
        $data = json_decode($result['response'], true);
        if (isset($data['data'])) {
            echo "   Found " . count($data['data']) . " items\n";
        }
    } else {
        echo "❌ FAILED (HTTP {$result['code']})\n";
        echo "   Response: " . substr($result['response'], 0, 100) . "...\n";
    }
    echo "\n";
}

echo "=== Test Complete ===\n";