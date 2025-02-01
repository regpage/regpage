<?php
// ссылка запроса в СРМ
$link = 'https://bibleforall.envycrm.com/crm/api/v1/lead/search/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
// проверка на существование номера телефона в СРМ
$data = [
  'phone' => $_GET['phone'] // телефон
];

require 'extensions/api_v1/sender.php';

// Ответ
// если заявка найдена
if ($answer['message'] === 'success' && $answer['lead'] === 'null') {
  echo 'lead=0&';
} elseif ($answer['message'] === 'success') {
  echo "lead={$answer['lead']['id']}&";
} else {
  echo "error A101 {$answer['message']}";
  //EMAIL TO DEVELOPER
  /*$email = 'zhichkinroman@gmail.com';
  $message = 'Админ: '.MEMBER_ID.' Не удалось получить ответ от CRM при отправке заказа при проверке номера телефона '.$_POST['phone'].' с сайта reg-page.ru. Ответ с сервера: '.$textAnswer;
  $res = EMAILS::sendEmail ($email, "Новый заказ с сайта регистрации", $message);
  if(!$res){
    ToLogs::error('Сбой Звонки АПИ СРМ ','Сбой в отправке письма разработчику. Содержание письма: ' . $message);
  }
  */
}
