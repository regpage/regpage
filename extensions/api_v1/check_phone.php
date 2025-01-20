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

// Ответ
if ($answer['message'] === 'success') {
  echo $answer['id'];
} else {
  if ($answer['id']) {
    $textAnswer = $answer['id'];
  } else {
    $textAnswer = 'ЗНАЧЕНИЕ В ОТВЕТЕ ОТСУТСТВУЕТ';
  }

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
