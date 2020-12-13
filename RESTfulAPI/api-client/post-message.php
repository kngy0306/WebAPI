<?php

declare(strict_types=1); ?>

    <body>
<?php
$params = [
    'userId' => 1001,
    'userName' => "kona",
    'food' => '抹茶',
];

$opt = [
    CURLOPT_URL => 'http://localhost:8888/server.php',
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $params,
    CURLOPT_RETURNTRANSFER => true,
];

$handle = curl_init();
curl_setopt_array($handle, $opt);
$apiResponse = json_decode(curl_exec($handle), true);
curl_close($handle);
?>
    <p>サーバからの応答: </p>
    <pre><?php print_r($apiResponse) ?></pre>
    </body><?php
