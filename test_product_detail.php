<?php

// Test product detail API
echo "=== Testing Product Detail API ===\n\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/api/products/bishop");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($response, true);
    
    if (isset($data['data'])) {
        $product = $data['data'];
        echo "Product Detail API Response:\n";
        echo "Name: " . $product['name'] . "\n";
        echo "Primary Image: " . ($product['primary_image'] ?? 'NULL') . "\n";
        echo "Stock Quantity: " . $product['stock_quantity'] . "\n";
        echo "In Stock: " . ($product['in_stock'] ? 'Yes' : 'No') . "\n";
        echo "Price: $" . $product['price'] . "\n";
        echo "Description: " . substr($product['description'], 0, 100) . "...\n";
        echo "Images count: " . count($product['images']) . "\n";
        
        if (count($product['images']) > 0) {
            echo "Images:\n";
            foreach ($product['images'] as $img) {
                echo "  - " . $img['image_path'] . " (Primary: " . ($img['is_primary'] ? 'Yes' : 'No') . ")\n";
            }
        }
    } else {
        echo "Unexpected response structure\n";
        echo $response . "\n";
    }
} else {
    echo "API Error: HTTP $httpCode\n";
    echo "Response: " . $response . "\n";
}

echo "\n=== End ===\n";