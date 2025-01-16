<?php
// ссылка запроса в СРМ
$link = 'https://bibleforall.envycrm.com/crm/api/v1/deal/search/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
// проверка на существование номера телефона в СРМ
$data = [
  'values' => [ // массив значений системных и произвольных полей
    'phone' => $_POST['phone'], // телефон
  ]
];

require_once 'extensions/api_v1/sender.php';
