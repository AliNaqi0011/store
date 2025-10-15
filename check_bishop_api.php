<?php

// Check Bishop product in API
echo "=== Checking Bishop Product API ===\n\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/api/products/featured");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($response, true);
    echo "API Response structure: " . print_r(array_keys($data), true) . "\n";
    
    $products = $data['data'] ?? $data;
    
    foreach ($products as $product) {
        if (isset($product['name']) && $product['name'] === 'Bishop') {
            echo "Bishop product found:\n";
            echo "ID: " . $product['id'] . "\n";
            echo "Name: " . $product['name'] . "\n";
            echo "Primary Image: " . ($product['primary_image'] ?? 'NULL') . "\n";
            echo "Images count: " . (isset($product['images']) ? count($product['images']) : 0) . "\n";
            
            if (isset($product['images']) && count($product['images']) > 0) {
                echo "All images:\n";
                foreach ($product['images'] as $img) {
                    echo "  - " . $img['image_path'] . " (Primary: " . ($img['is_primary'] ? 'Yes' : 'No') . ")\n";
                }
            }
            break;
        }
    }
} else {
    echo "API Error: HTTP $httpCode\n";
}

echo "\n=== End ===\n";