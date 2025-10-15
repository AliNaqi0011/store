<?php

// Test checkout with proper session handling
echo "=== Testing Checkout with Session ===\n\n";

$baseUrl = 'http://127.0.0.1:8000/api';
$cookieJar = tempnam(sys_get_temp_dir(), 'cookies');

function makeRequest($url, $method = 'GET', $data = null, $headers = [], $cookieJar = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    if ($cookieJar) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
    }
    
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

$result = makeRequest($baseUrl . '/login', 'POST', $loginData, [], $cookieJar);
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
$result = makeRequest($baseUrl . '/cart', 'POST', $cartData, [], $cookieJar);
if ($result['code'] === 200) {
    echo "   ✅ Item added to cart\n";
} else {
    echo "   ❌ Failed to add to cart: " . $result['response'] . "\n";
}

// Test 3: Check cart
echo "\n3. Checking cart contents...\n";
$result = makeRequest($baseUrl . '/cart', 'GET', null, [], $cookieJar);
if ($result['code'] === 200) {
    $cartResponse = json_decode($result['response'], true);
    echo "   ✅ Cart retrieved\n";
    echo "   Items in cart: " . $cartResponse['count'] . "\n";
} else {
    echo "   ❌ Failed to get cart\n";
}

// Test 4: Checkout with COD
echo "\n4. Testing COD checkout...\n";
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
$result = makeRequest($baseUrl . '/checkout', 'POST', $checkoutData, $headers, $cookieJar);

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

// Cleanup
unlink($cookieJar);

echo "\n=== Test Complete ===\n";