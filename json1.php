<?php

declare(strict_types=1);

// json_encode
$novels = [
  [
    'title' => '斜陽',
    'author' => '太宰治',
  ],
  [
    'title' => 'The Catcher in the Rye',
    'author' => 'Jerome David Salinger',
  ],
];

echo json_encode($novels); // [{"title":"\u659c\u967d","author":"\u592a\u5bb0\u6cbb"},{"title":"The Catcher in the Rye","author":"Jerome David Salinger"}]
echo json_encode($novels, JSON_PRETTY_PRINT); // JSON_PRETTY_PRINT 改行とインデントを使用して見やすく表示

// json_decode
$jsonValue = <<< VALUE
  [
    {
      "title": "\u659c\u967d",
      "author": "\u592a\u5bb0\u6cbb"
    },
    {
      "タイトル": "こころ",
      "author": "夏目漱石"
    },
    {
      "title": "The Catcher in the Rye",
      "author": "Jerome David Salinger"
    }
  ]
VALUE;

$decoded = json_decode($jsonValue, true);
print_r($decoded);