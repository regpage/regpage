<?php
$curl = curl_init();
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_POST,true);
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode(['request' => $data]));
curl_setopt($curl,CURLOPT_HEADER,false);

$out=curl_exec($curl);
$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
curl_close($curl);

$answer = json_decode($out, true);

if ($answer['message'] === 'success') {
  DBQuery::set('calls', 'crm_id', $answer['id'], 'id', $_GET['id']);
  echo $answer['id'];
} else {
  if ($answer['id']) {
    $textAnswer = $answer['id'];
  } else {
    $textAnswer = 'ЗНАЧЕНИЕ В ОТВЕТЕ ОТСУТСТВУЕТ';
  }

  //EMAIL TO DEVELOPER
  /*$email = 'zhichkinroman@gmail.com';
  $error = null;
  $message = 'Админ: '.MEMBER_ID.' Не удалось получить ответ от CRM при отправке заказа на имя '.$name.' с сайта reg-page.ru. Ответ с сервера: '.$textAnswer;
  $res = EMAILS::sendEmail ($email, "Новый заказ с сайта регистрации", $message);
  if($res != null){
    $error = $res;
  }
  if($error == null){
    $textmext = 'Не удалось получить ответ от CRM. Отправлено уведомление по email разработчику.';
    echo json_encode(["result"=>true]);
    exit;
  }*/
  echo 'Failed';
}
