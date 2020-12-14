<?php

declare(strict_types=1);

$params = [
    'userId' => 1001,
    'userName' => "kona",
    'food' => '抹茶',
];

$url = "http://localhost:8888/server.php?" . http_build_query($params);

$handle = curl_init($url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
$apiResponse = json_decode(curl_exec($handle), true);
curl_close($handle);

echo "サーバからの応答:\n";
print_r($apiResponse);
