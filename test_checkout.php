<?php

// Test checkout functionality with COD
echo "=== Testing Checkout with COD ===\n\n";

$baseUrl = 'http://127.0.0.1:8000/api';

function makeRequest($url, $method = 'GET', $data = null, $headers = []) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
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
    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    
    $headers = substr($response, 0, $headerSize);
    $body = substr($response, $headerSize);
    
    curl_close($ch);
    
    return [
        'code' => $httpCode, 
        'response' => $body,
        'headers' => $headers
    ];
}

// Step 1: Register a test user
echo "1. Registering test user:\n";
$userData = [
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => 'password123',
    'password_confirmation' => 'password123'
];

$result = makeRequest($baseUrl . '/register', 'POST', $userData);
if ($result['code'] === 201 || $result['code'] === 200) {
    $response = json_decode($result['response'], true);
    echo "   ✅ User registered successfully\n";
    $token = $response['token'] ?? null;
} else {
    echo "   ⚠️ User might already exist, trying login...\n";
    
    // Try login instead
    $loginData = [
        'email' => 'test@example.com',
        'password' => 'password123'
    ];
    
    $result = makeRequest($baseUrl . '/login', 'POST', $loginData);
    if ($result['code'] === 200) {
        $response = json_decode($result['response'], true);
        echo "   ✅ User logged in successfully\n";
        $token = $response['token'] ?? null;
    } else {
        echo "   ❌ Failed to login\n";
        exit;
    }
}

if (!$token) {
    echo "   ❌ No token received\n";
    exit;
}

echo "\n";

// Step 2: Add item to cart
echo "2. Adding item to cart:\n";
$cartData = [
    'product_id' => 1,
    'quantity' => 2
];

$result = makeRequest($baseUrl . '/cart', 'POST', $cartData);
if ($result['code'] === 200) {
    echo "   ✅ Item added to cart\n";
} else {
    echo "   ❌ Failed to add to cart: " . $result['response'] . "\n";
    exit;
}

echo "\n";

// Step 3: Test checkout with COD
echo "3. Testing checkout with COD:\n";
$checkoutData = [
    'billing_address' => [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'address_line_1' => '123 Main St',
        'address_line_2' => 'Apt 4B',
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
        'address_line_2' => 'Apt 4B',
        'city' => 'New York',
        'state' => 'NY',
        'postal_code' => '10001',
        'country' => 'USA'
    ],
    'payment_method' => 'cod',
    'notes' => 'Please call before delivery'
];

$headers = ['Authorization: Bearer ' . $token];
$result = makeRequest($baseUrl . '/checkout', 'POST', $checkoutData, $headers);

if ($result['code'] === 200) {
    $response = json_decode($result['response'], true);
    echo "   ✅ Order placed successfully with COD\n";
    echo "   Order Number: " . $response['order']['order_number'] . "\n";
    echo "   Status: " . $response['order']['status'] . "\n";
    echo "   Payment Status: " . $response['order']['payment_status'] . "\n";
    echo "   Total: $" . number_format($response['order']['total_amount'], 2) . "\n";
    
    $orderId = $response['order']['id'];
} else {
    echo "   ❌ Checkout failed (HTTP {$result['code']})\n";
    echo "   Response: " . $result['response'] . "\n";
    exit;
}

echo "\n";

// Step 4: Verify order was created
echo "4. Verifying order in database:\n";
$result = makeRequest($baseUrl . '/orders', 'GET', null, $headers);

if ($result['code'] === 200) {
    $response = json_decode($result['response'], true);
    echo "   ✅ Orders retrieved successfully\n";
    echo "   Total orders: " . count($response['data']) . "\n";
    
    if (count($response['data']) > 0) {
        $order = $response['data'][0];
        echo "   Latest order: {$order['order_number']} - {$order['status']}\n";
    }
} else {
    echo "   ❌ Failed to retrieve orders\n";
}

echo "\n=== Test Complete ===\n";