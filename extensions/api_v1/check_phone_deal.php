<?php
// ссылка запроса в СРМ
$link = 'https://bibleforall.envycrm.com/crm/api/v1/deal/search/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
// проверка на существование номера телефона в СРМ
$data = [
  'values' => [ // массив значений системных и произвольных полей
    'phone' => $_GET['phone'] // телефон
  ]
];

require 'extensions/api_v1/sender.php';

// Ответ
// если сделка найдена
print_r($answer);
if ($answer['message'] === 'success' && isset($answer['clients'][0]['deals_for_event'][0]['id'])) {
  echo "deal={$answer['clients'][0]['deals_for_event'][0]['id']}&";
} elseif ($answer['message'] === 'success' && isset($answer['clients'])) {
  echo 'deal=0&';
} else {
  echo "error A101 {$answer['message']}&";
  //EMAIL TO DEVELOPER
  /*$email = 'zhichkinroman@gmail.com';
  $message = 'Админ: '.MEMBER_ID.' Не удалось получить ответ от CRM при отправке заказа при проверке номера телефона '.$_POST['phone'].' с сайта reg-page.ru. Ответ с сервера: '.$textAnswer;
  $res = EMAILS::sendEmail ($email, "Новый заказ с сайта регистрации", $message);
  if(!$res){
    ToLogs::error('Сбой Звонки АПИ СРМ ','Сбой в отправке письма разработчику. Содержание письма: ' . $message);
  }
  */
  echo 'Failed';
}
