<?php

// Test image upload for products
echo "=== Testing Product Image Upload ===\n\n";

$baseUrl = 'http://127.0.0.1:8000/api';

function uploadImage($productId, $imagePath) {
    global $baseUrl;
    
    if (!file_exists($imagePath)) {
        echo "   ❌ Image file not found: $imagePath\n";
        return false;
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$baseUrl/products/$productId/upload-image");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $postData = [
        'image' => new CURLFile($imagePath, mime_content_type($imagePath), basename($imagePath))
    ];
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ['code' => $httpCode, 'response' => $response];
}

// Create a test image if it doesn't exist
$testImagePath = __DIR__ . '/test_product_image.jpg';
if (!file_exists($testImagePath)) {
    echo "Creating test image...\n";
    
    // Create a simple test image
    $image = imagecreate(400, 300);
    $bg = imagecolorallocate($image, 255, 255, 255);
    $textColor = imagecolorallocate($image, 0, 0, 0);
    
    imagestring($image, 5, 150, 140, 'Test Product', $textColor);
    imagejpeg($image, $testImagePath, 90);
    imagedestroy($image);
    
    echo "   ✅ Test image created\n\n";
}

// Test uploading image to product ID 1
echo "1. Uploading image to product ID 1:\n";
$result = uploadImage(1, $testImagePath);

if ($result['code'] === 200) {
    $response = json_decode($result['response'], true);
    if (isset($response['success']) && $response['success']) {
        echo "   ✅ Image uploaded successfully!\n";
        echo "   Image Path: " . $response['image']['image_path'] . "\n";
        echo "   Is Primary: " . ($response['image']['is_primary'] ? 'Yes' : 'No') . "\n";
    } else {
        echo "   ❌ Upload failed: " . $result['response'] . "\n";
    }
} else {
    echo "   ❌ HTTP Error {$result['code']}: " . $result['response'] . "\n";
}

echo "\n";

// Test getting product with images
echo "2. Checking product with images:\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$baseUrl/products/iphone-15-pro");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $product = json_decode($response, true);
    echo "   ✅ Product retrieved\n";
    echo "   Product: " . $product['data']['name'] . "\n";
    echo "   Images count: " . count($product['data']['images']) . "\n";
    
    if (count($product['data']['images']) > 0) {
        foreach ($product['data']['images'] as $image) {
            echo "   - " . $image['image_path'] . " (Primary: " . ($image['is_primary'] ? 'Yes' : 'No') . ")\n";
        }
    }
} else {
    echo "   ❌ Failed to get product\n";
}

// Cleanup test image
if (file_exists($testImagePath)) {
    unlink($testImagePath);
    echo "\n   🧹 Test image cleaned up\n";
}

echo "\n=== Test Complete ===\n";