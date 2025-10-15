<?php

$url = 'http://127.0.0.1:8000/api/products';
$response = file_get_contents($url);

if ($response === false) {
    echo "Failed to fetch products API\n";
    exit;
}

$data = json_decode($response, true);
echo "API Response:\n";
echo json_encode($data, JSON_PRETTY_PRINT);