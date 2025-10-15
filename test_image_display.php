<?php

// Test image display in API
echo "=== Testing Image Display ===\n\n";

$baseUrl = 'http://127.0.0.1:8000/api';

// Test products API
echo "1. Testing products API:\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$baseUrl/products");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($response, true);
    echo "   ✅ Products API working\n";
    echo "   Products found: " . count($data['data']) . "\n";
    
    if (count($data['data']) > 0) {
        $product = $data['data'][0];
        echo "   First product: " . $product['name'] . "\n";
        echo "   Primary image: " . ($product['primary_image'] ?? 'NULL') . "\n";
        echo "   Stock quantity: " . $product['stock_quantity'] . "\n";
        echo "   In stock: " . ($product['in_stock'] ? 'Yes' : 'No') . "\n";
    }
} else {
    echo "   ❌ Products API failed (HTTP $httpCode)\n";
}

echo "\n";

// Test specific product
echo "2. Testing specific product:\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$baseUrl/products/iphone-15-pro");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($response, true);
    echo "   ✅ Product detail API working\n";
    echo "   Product: " . $data['data']['name'] . "\n";
    echo "   Images count: " . count($data['data']['images']) . "\n";
    
    if (count($data['data']['images']) > 0) {
        foreach ($data['data']['images'] as $image) {
            echo "   - " . $image['image_path'] . " (Primary: " . ($image['is_primary'] ? 'Yes' : 'No') . ")\n";
        }
    }
} else {
    echo "   ❌ Product detail API failed (HTTP $httpCode)\n";
}

echo "\n";

// Test image accessibility
echo "3. Testing image accessibility:\n";
$imageUrl = "http://127.0.0.1:8000/storage/products/IeDuJ6KRsxUxOkunV3xgxuUjDaKBdTBjP5QmApO3.jpg";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $imageUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    echo "   ✅ Image accessible at: $imageUrl\n";
} else {
    echo "   ❌ Image not accessible (HTTP $httpCode)\n";
}

echo "\n=== Test Complete ===\n";