<?php

declare(strict_types=1);

// HTTPメソッド GET に対応する関数
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