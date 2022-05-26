<?php
//extensions/crm/order_status.php?lead_id=70589375
include_once '../../db.php';
include_once '../../logWriter.php';
$memberId = db_getMemberIdBySessionId (session_id());
$memberId ? '' : $memberId = false;

if (empty($_GET['lead_id'])) {
  logFileWriter($memberId, 'КОНТАКТЫ. Проверка заявки не прошла, отсутствует ID лида.', 'FATAL');
  exit;
}

$link = 'https://bibleforall.envycrm.com/crm/api/v1/lead/get/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';

//$leadid = $_GET['lead_id'] * 1;
$leadid = $_GET['lead_id'];

$curl = curl_init();

$data = ['lead_id' => $leadid];

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
  logFileWriter($memberId, 'КОНТАКТЫ. Заказ передан в CRM. Присвоен ID '.$answer['id'], 'DEBUG');
  //echo json_encode($answer);
  if (count($answer['result']['deals']) > 0) {
    # Можно выберать наибольший номер сделки, но, возможно, это бесперспективно
    $last_deal_id = end($answer['result']['deals']);
    // get deal
    $link = 'https://bibleforall.envycrm.com/crm/api/v1/deal/get/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
    $curl = curl_init();
    $data = ['deal_id' => $last_deal_id];
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_URL, $link);
    curl_setopt($curl,CURLOPT_POST,true);
    curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode(['request' => $data]));
    curl_setopt($curl,CURLOPT_HEADER,false);

    $out=curl_exec($curl);
    $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
    curl_close($curl);

    $answer2 = json_decode($out, true);
    echo $last_deal_id.' Этап сделки - "'.$answer2['result']['stage_id'].'" Этап установлен: '.$answer2['result']['stage_updated_at'].'. Последнее обновление сделки было '.$answer2['result']['updated_at'];
  } else {
    echo 'Возможно заказ ещё не обработан в BFA';
  }
} else {
  if ($answer['name']) {
    $textAnswer = $answer['name'];
  } else {
    $textAnswer = 'ЗНАЧЕНИЕ В ОТВЕТЕ ОТСУТСТВУЕТ. Полный ответ: '.$answer['message']. ' & '.$answer['status_code'];
  }
  logFileWriter($memberId, 'КОНТАКТЫ. НЕТ ОТВЕТА от сервера. Ответ: '.$textAnswer, 'ERROR');

  //EMAIL TO DEVELOPER
  $email = 'zhichkinroman@gmail.com';
  $error = null;
  $message = 'Админ: '.$memberId.' Не удалось получить ответ от CRM при запросе лида сайта reg-page.ru. Ответ с сервера: '.$textAnswer;
  $res = EMAILS::sendEmail ($email, "Проверка лида с сайта регистрации", $message);
  if($res != null){
    $error = $res;
  }
  if($error == null){
    $textmext = 'Не удалось получить ответ от CRM. Отправлено уведомление по email разработчику.';
    logFileWriter($adminId, $textmext, 'FATAL');
    //echo json_encode($answer);
    //echo json_encode(["result"=>true]);
    echo $answer['message'].' '.$_GET['lead_id'];
    exit;
  }
  echo 'Failed';
}

?>
