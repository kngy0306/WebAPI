# RESTful APIって？

標準的なWebAPIの設計方式。  
リソースに対するURLを1つだけ用意し、HTTPメソッドの切り替えで操作を表す。

#### 例

- 読書リストのうち、ID「0001」の本を取得する
  - （URL）https://xxxxx/readinglist/0001
  - （HTTPメソッド） GET
- 読書リストのうち、ID「1000」の本を削除する
  - （URL）https://xxxxx/readinglist/1000
  - （HTTPメソッド） DELETE

# RESTful APIはステートレスであるべき

ステートレス = WebAPIサーバはセッション変数を持つべきではない。  
サーバ間で共有ができなくなる。などの問題があるから。  
スケーラビリティの問題。（今後サーバを増やしたいときとか）

# PHPでRESTfulAPIサーバ、クライアントの作成

#### 環境

macOS BigSur 11.0.1

PHP 7.3.22

MAMP 5.7

### サーバサイドのPHPファイルを作成

```php
<?php
declare(strict_types=1);

// GET
function getMessage()
{
  $res = [
    'status' => 'success',
    'message' => 'ユーザ: ' . $_GET['userName'] . 'の好きな食べ物は、' . $_GET['food'] . 'です。',
  ];
  return $res;
}

//POST
function postMessage()
{
  $res = [
    'status' => 'success',
    'message' => 'ユーザ: ' . $_POST['userName'] . 'の好きな食べ物を、' . $_POST['food'] . 'に登録しました。',
  ];
  return $res;
}

// PUT
function putMessage()
{
  parse_str(file_get_contents('php://input'), $putRequest);
  $res = [
      'status' => 'success',
      'message' => 'ユーザ: ' . $putRequest['userName'] . 'の好きな食べ物を、 ' . $putRequest['food'] . 'に変更しました。',
  ];
  return $res;
}

// DELETE
function deleteMessage()
{
  parse_str(file_get_contents('php://input'), $deleteRequest);
  $res = [
      'status' => 'success',
      'message' => 'ユーザ: ' . $deleteRequest['userName'] . 'の好きな食べ物、' . $deleteRequest['food'] . 'を削除しました。',
  ];
  return $res;
}

switch (strtolower($_SERVER['REQUEST_METHOD'])) {
  case 'get':
    echo json_encode(getMessage());
    break;
  case 'post':
    echo json_encode(postMessage());
    break;
  case 'put':
    echo json_encode(putMessage());
    break;
  case 'delete':
    echo json_encode(deleteMessage());
    break;
}
```

### クライアントサイドのPHPファイルを作成

cUEL関数を使用。

1. ```curl_init()``` でURLを指定。cURLハンドルを取得。
2. ```curl_setopt()``` でオプションの指定。
3. ```curl_exec()``` でハンドルを渡し、リクエストを送信。レスポンスを取得。
4. ```curl_close()``` でハンドルを閉じる。

#### GET

```php
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
```



実行結果

```shell
サーバからの応答:
Array
(
    [status] => success
    [message] => ユーザ: konaの好きな食べ物は、抹茶です。
)
```



```http_build_query()```で連想配列をパラメータ文字列へ。  

```php
$params = [
        'userId' => 1001,
        'userName' => "kona",
        'food' => '抹茶',
    ];
```

↓

```
userId=1001&userName=kona&food=抹茶（Unicodeに変換される）
```

#### POST

```php
<?php
declare(strict_types=1);

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

echo "サーバからの応答:\n";
print_r($apiResponse);
```



実行結果

```shell
サーバからの応答:
Array
(
    [status] => success
    [message] => ユーザ: konaの好きな食べ物を、抹茶に登録しました。
)
```



```curl_setopt_array()```で配列で指定した設定を適応できる。

#### PUT

```php
<?php
declare(strict_types=1);

$params = [
    'userId' => 1001,
    'userName' => "kona",
    'food' => '抹茶アイス',
];

$opt = [
    CURLOPT_URL => 'http://localhost:8888/server.php',
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => http_build_query($params),
    CURLOPT_RETURNTRANSFER => true,
];

$handle = curl_init();
curl_setopt_array($handle, $opt);
$apiResponse = json_decode(curl_exec($handle), true);
curl_close($handle);

echo "サーバからの応答:\n";
print_r($apiResponse);

```



実行結果

```
サーバからの応答:
Array
(
    [status] => success
    [message] => ユーザ: konaの好きな食べ物を、 抹茶アイスに変更しました。
)
```

#### DELETE

```php
<?php
declare(strict_types=1);

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

echo "サーバからの応答: \n";
print_r($apiResponse);

```

実行結果

```
サーバからの応答: 
Array
(
    [status] => success
    [message] => ユーザ: konaの好きな食べ物、抹茶アイスを削除しました。
)
```

# 参考書籍
https://www.amazon.co.jp/PHP%E6%9C%AC%E6%A0%BC%E5%85%A5%E9%96%80-%E4%B8%8B-%E3%82%AA%E3%83%96%E3%82%B8%E3%82%A7%E3%82%AF%E3%83%88%E6%8C%87%E5%90%91%E8%A8%AD%E8%A8%88%E3%80%81%E3%82%BB%E3%82%AD%E3%83%A5%E3%83%AA%E3%83%86%E3%82%A3%E3%80%81%E7%8F%BE%E5%A0%B4%E3%81%A7%E4%BD%BF%E3%81%88%E3%82%8B%E5%AE%9F%E8%B7%B5%E3%83%8E%E3%82%A6%E3%83%8F%E3%82%A6%E3%81%BE%E3%81%A7-%E5%A4%A7%E5%AE%B6-%E6%AD%A3%E7%99%BB/dp/4297114704
