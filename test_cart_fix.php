<?php

// Test script to verify cart and stock fixes
echo "=== Testing Cart and Stock Fixes ===\n\n";

$baseUrl = 'http://127.0.0.1:8000/api';

function makeRequest($url, $method = 'GET', $data = null, $cookies = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    if ($cookies) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookies);
    }
    
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
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    
    $headers = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);
    
    curl_close($ch);
    
    // Extract cookies from headers
    $cookies = '';
    if (preg_match_all('/Set-Cookie:\s*([^;]+)/i', $headers, $matches)) {
        $cookies = implode('; ', $matches[1]);
    }
    
    return [
        'code' => $httpCode, 
        'response' => $body,
        'cookies' => $cookies
    ];
}

// Test 1: Get products and check stock display
echo "1. Testing product listing with stock info:\n";
$result = makeRequest($baseUrl . '/products');
if ($result['code'] === 200) {
    $data = json_decode($result['response'], true);
    if (isset($data['data']) && count($data['data']) > 0) {
        $product = $data['data'][0];
        echo "   ✅ Products loaded successfully\n";
        echo "   Product: {$product['name']}\n";
        echo "   Stock Quantity: {$product['stock_quantity']}\n";
        echo "   In Stock: " . ($product['in_stock'] ? 'Yes' : 'No') . "\n";
        echo "   Manage Stock: " . ($product['manage_stock'] ? 'Yes' : 'No') . "\n";
        $testProductId = $product['id'];
    } else {
        echo "   ❌ No products found\n";
        exit;
    }
} else {
    echo "   ❌ Failed to get products (HTTP {$result['code']})\n";
    exit;
}

echo "\n";

// Test 2: Add item to cart
echo "2. Testing add to cart:\n";
$cartData = [
    'product_id' => $testProductId,
    'quantity' => 1
];

$result = makeRequest($baseUrl . '/cart', 'POST', $cartData);
if ($result['code'] === 200) {
    echo "   ✅ Item added to cart successfully\n";
    $response = json_decode($result['response'], true);
    echo "   Response: {$response['message']}\n";
    if (isset($response['cart_count'])) {
        echo "   Cart Count: {$response['cart_count']}\n";
    }
    $sessionCookies = $result['cookies'];
} else {
    echo "   ❌ Failed to add to cart (HTTP {$result['code']})\n";
    echo "   Response: " . substr($result['response'], 0, 200) . "\n";
    $sessionCookies = $result['cookies']; // Try to get cookies anyway
}

echo "\n";

// Test 3: Get cart contents
echo "3. Testing cart retrieval:\n";
$result = makeRequest($baseUrl . '/cart', 'GET', null, $sessionCookies);
if ($result['code'] === 200) {
    $data = json_decode($result['response'], true);
    echo "   ✅ Cart retrieved successfully\n";
    echo "   Items in cart: " . count($data['items']) . "\n";
    echo "   Total items: {$data['count']}\n";
    echo "   Total amount: $" . number_format($data['total'], 2) . "\n";
    
    if (count($data['items']) > 0) {
        $item = $data['items'][0];
        echo "   First item: {$item['name']} (Qty: {$item['quantity']})\n";
    }
} else {
    echo "   ❌ Failed to get cart (HTTP {$result['code']})\n";
    echo "   Response: " . substr($result['response'], 0, 200) . "\n";
}

echo "\n=== Test Complete ===\n";