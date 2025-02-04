<?php
require_once 'db/classes/date_convert.php';
// ссылка запроса в СРМ
$link = 'https://bibleforall.envycrm.com/crm/api/v1/deal/search/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';

// проверка на существование номера телефона в СРМ
$data = ['phone' => $_GET['phone']]; // телефон
// подключаем curl
require 'extensions/api_v1/sender.php';
// Ответ
if ($answer['message'] === 'success' && isset($answer['clients'][0]['deals_for_event'][0]['id'])) {
  echo date_convert::yyyymmdd_to_ddmmyyyy(explode(" ", $answer['clients'][0]['deals_for_event'][0]['created_at'])[0]);
} elseif ($answer['message'] === 'success') {
  echo '';
} else {
  // deal=errorA101&
  echo 'error';
}
