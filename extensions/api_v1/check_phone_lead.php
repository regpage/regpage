<?php
$link = 'https://bibleforall.envycrm.com/crm/api/v1/lead/search/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
// данные для запроса в срм
$data = ['phone' => $_GET['phone']]; // телефон
// подключаем curl
require 'extensions/api_v1/sender.php';
// разбираем ответ
if ($answer['message'] === 'success' && isset($answer['leads'][0]['id'])) {
  echo "{$answer['leads'][0]['id']}&";
} elseif ($answer['message'] === 'success') {
  echo '&';
} else {
  // lead=errorA101&
  echo 'error&';
}
