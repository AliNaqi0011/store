<?php

// Simple checkout test
echo "=== Testing Checkout API ===\n\n";

$baseUrl = 'http://127.0.0.1:8000/api';

function makeRequest($url, $method = 'GET', $data = null, $headers = []) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $defaultHeaders = [
        'Content-Type: application/json',
        'Accept: application/json'
    ];
    
    if (!empty($headers)) {
        $defaultHeaders = array_merge($defaultHeaders, $headers);
    }
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $defaultHeaders);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ['code' => $httpCode, 'response' => $response];
}

// Test 1: Login
echo "1. Logging in...\n";
$loginData = [
    'email' => 'test@example.com',
    'password' => 'password123'
];

$result = makeRequest($baseUrl . '/login', 'POST', $loginData);
if ($result['code'] === 200) {
    $response = json_decode($result['response'], true);
    echo "   ✅ Login successful\n";
    $token = $response['token'];
} else {
    echo "   ❌ Login failed: " . $result['response'] . "\n";
    exit;
}

// Test 2: Add to cart
echo "\n2. Adding item to cart...\n";
$cartData = ['product_id' => 1, 'quantity' => 1];
$result = makeRequest($baseUrl . '/cart', 'POST', $cartData);
if ($result['code'] === 200) {
    echo "   ✅ Item added to cart\n";
} else {
    echo "   ❌ Failed to add to cart\n";
}

// Test 3: Checkout with COD
echo "\n3. Testing COD checkout...\n";
$checkoutData = [
    'billing_address' => [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'address_line_1' => '123 Main St',
        'city' => 'New York',
        'state' => 'NY',
        'postal_code' => '10001',
        'country' => 'USA'
    ],
    'shipping_address' => [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'phone' => '1234567890',
        'address_line_1' => '123 Main St',
        'city' => 'New York',
        'state' => 'NY',
        'postal_code' => '10001',
        'country' => 'USA'
    ],
    'payment_method' => 'cod'
];

$headers = ['Authorization: Bearer ' . $token];
$result = makeRequest($baseUrl . '/checkout', 'POST', $checkoutData, $headers);

echo "Response Code: " . $result['code'] . "\n";
echo "Response: " . $result['response'] . "\n";

if ($result['code'] === 200) {
    $response = json_decode($result['response'], true);
    if (isset($response['success']) && $response['success']) {
        echo "   ✅ COD Order placed successfully!\n";
        echo "   Order Number: " . $response['order']['order_number'] . "\n";
        echo "   Status: " . $response['order']['status'] . "\n";
    } else {
        echo "   ❌ Order placement failed\n";
    }
} else {
    echo "   ❌ Checkout failed\n";
}

echo "\n=== Test Complete ===\n";