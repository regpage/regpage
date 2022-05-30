<?php


if (empty($_GET['lead_id'])) {
  logFileWriter($memberId, 'КОНТАКТЫ. Проверка заявки не прошла, отсутствует ID лида.', 'FATAL');
  exit;
}

$link = 'https://bibleforall.envycrm.com/crm/api/v1/lead/get/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';

$curl = curl_init();

$data = [
  'request' => [
    'lead_id' => $leadid
  ]
];

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
  echo $answer['result']['deals'];
} else {
  if ($answer['name']) {
    $textAnswer = $answer['name'];
  } else {
    $textAnswer = 'ЗНАЧЕНИЕ В ОТВЕТЕ ОТСУТСТВУЕТ. Полный ответ: '.$answer['message']. ' & '.$answer['status_code'];
  }


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
