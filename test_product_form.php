<?php

// Test product creation with form data
echo "=== Testing Product Form Creation ===\n\n";

$baseUrl = 'http://127.0.0.1:8000/api';

function createProduct() {
    global $baseUrl;
    
    // Create test image
    $testImagePath = __DIR__ . '/test_product.jpg';
    $image = imagecreate(300, 200);
    $bg = imagecolorallocate($image, 255, 255, 255);
    $textColor = imagecolorallocate($image, 0, 0, 0);
    imagestring($image, 5, 100, 90, 'Test Product', $textColor);
    imagejpeg($image, $testImagePath, 90);
    imagedestroy($image);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$baseUrl/products/create");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $postData = [
        'name' => 'Test Product ' . date('H:i:s'),
        'description' => 'This is a test product created via form',
        'short_description' => 'Test product for form validation',
        'sku' => 'TEST-' . time(),
        'price' => '99.99',
        'compare_price' => '129.99',
        'stock_quantity' => '50',
        'category_id' => '1',
        'brand_id' => '1',
        'is_active' => '1',
        'is_featured' => '1',
        'images[]' => new CURLFile($testImagePath, 'image/jpeg', 'test_product.jpg')
    ];
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Cleanup test image
    if (file_exists($testImagePath)) {
        unlink($testImagePath);
    }
    
    return ['code' => $httpCode, 'response' => $response];
}

// Test product creation
echo "1. Creating product with form data:\n";
$result = createProduct();

echo "Response Code: " . $result['code'] . "\n";
echo "Response: " . $result['response'] . "\n\n";

if ($result['code'] === 201) {
    $response = json_decode($result['response'], true);
    if (isset($response['success']) && $response['success']) {
        echo "   ✅ Product created successfully!\n";
        echo "   Product ID: " . $response['data']['id'] . "\n";
        echo "   Product Name: " . $response['data']['name'] . "\n";
        echo "   SKU: " . $response['data']['sku'] . "\n";
        echo "   Price: $" . $response['data']['price'] . "\n";
        echo "   Category: " . ($response['data']['category']['name'] ?? 'N/A') . "\n";
        echo "   Brand: " . ($response['data']['brand']['name'] ?? 'N/A') . "\n";
        echo "   Images: " . count($response['data']['images']) . "\n";
        
        if (count($response['data']['images']) > 0) {
            echo "   Primary Image: " . $response['data']['images'][0]['image_path'] . "\n";
        }
    } else {
        echo "   ❌ Product creation failed\n";
    }
} else {
    echo "   ❌ HTTP Error: " . $result['code'] . "\n";
}

echo "\n=== Test Complete ===\n";