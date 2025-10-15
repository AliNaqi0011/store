<?php

// Test frontend image URLs
echo "=== Testing Frontend Images ===\n\n";

$baseUrl = 'http://127.0.0.1:8000/api';

// Test featured products API
echo "1. Testing featured products API:\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$baseUrl/products/featured");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($response, true);
    echo "   ✅ Featured products API working\n";
    echo "   Featured products found: " . count($data['data']) . "\n";
    
    foreach ($data['data'] as $product) {
        echo "   - " . $product['name'] . "\n";
        echo "     Image: " . ($product['primary_image'] ?? 'NULL') . "\n";
        
        // Test if image URL is accessible
        if ($product['primary_image']) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $product['primary_image']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            
            $response = curl_exec($ch);
            $imageHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($imageHttpCode === 200) {
                echo "     Status: ✅ Image accessible\n";
            } else {
                echo "     Status: ❌ Image not accessible (HTTP $imageHttpCode)\n";
            }
        }
        echo "\n";
    }
} else {
    echo "   ❌ Featured products API failed (HTTP $httpCode)\n";
}

echo "\n=== Test Complete ===\n";