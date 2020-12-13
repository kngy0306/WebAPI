<?php

declare(strict_types=1); ?>

    <body>
<?php
$params = [
    'userId' => 1001,
    'userName' => "kona",
    'food' => '抹茶アイス',
];

$opt = [
    CURLOPT_URL => 'http://localhost:8888/server.php',
    CURLOPT_CUSTOMREQUEST => 'DELETE',
    CURLOPT_POSTFIELDS => http_build_query($params),
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
