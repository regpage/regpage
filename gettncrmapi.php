<?php
include_once 'db.php';
include_once 'logWriter.php';
$memberId = db_getMemberIdBySessionId (session_id());
$memberId ? '' : $memberId = false;

## BEGIN data POST sends directly VERSION 2
//$link = 'https://bibleforall.envycrm.com/crm/api/v1/lead/get/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
//$link = 'https://bibleforall.envycrm.com/crm/api/v1/lead/search/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
//$link = 'https://bibleforall.envycrm.com/crm/api/v1/lead/list/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
// ?? $link = 'https://bibleforall.envycrm.com/crm/api/v1/lead/log/list/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
/*
function someFunctionName($value='', $iteration=0){
  $result;
  $tracknumbers;
  if ($result) {
    someFunctionName($value='', $iteration+50);
  }
  return $tracknumbers;
}

for ($i=0; $i < ; $i++) {

}
*/
$link = 'https://bibleforall.envycrm.com/crm/api/v1/deal/list/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
$curl = curl_init();

$data = [
  'stage_id' => 419655,
  'limit' => 50,
  'offset' => 0 //ПОМЕСТИТЬ В ЦИКЛ И ПОЛУЧАТЬ ПО 50 ЗАПИСЕЙ ПОКА НЕ ВЕРНЁТСЯ ПУСТОЙ ОТВЕТ И ТОГДА ЗАВЕРШИТЬ НАПОЛНЕНИЕ МАССИВА ИЛИ ЗАПРОСЫ К ПОЧТОВИКАМ, КАК ПОЛУЧИТСЯ
  //419655
//'lead_id' => 63522827
//'email' => 'kondratenkoalekz@gmail.com'
/*
"keyword" => "",
"limit" => 0,
"offset" => 0,
"date_start" => "2021-06-10",
"date_end" => "2021-06-20",
"date_type" => "created"
*/
// ?? 'lead_id' => ''
/*
  'values' => [ // массив значений системных и произвольных полей
    'name' => '', // имя
    'email' => $email, // email
    'custom' => [ // массив дополнительных полей
    // в каждой строке массив идентификатора поля и его значения
      ['input_id' => 131211, 'value' => $value1], // количество
      ['input_id' => 131340, 'value' => $value2], // комментарий
    ]
  ]*/
];

//curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_POST,true);
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode(['request' => $data]));
curl_setopt($curl,CURLOPT_HEADER,false);

$out=curl_exec($curl);
$code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
curl_close($curl);

$answer = json_decode($out, true);
echo $answer['result']. ' & '.$answer['result'];
//echo $answer['message']. ' & '.$answer['result'][0]['values']['custom']['crm_132909']['value'];

## END


/*
$link = 'https://bibleforall.envycrm.com/crm/api/v1/lead/get/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$info = $_POST['info'];
$value1 = $_POST['value1'];
$value2 = $_POST['value2'];
$value3 = $_POST['value3'];
$value4 = $_POST['value4'];
$value5 = $_POST['value5'];
$value6 = $_POST['value6'];
$value7 = $_POST['value7'];
$value8 = $_POST['value8'];

logFileWriter($memberId, 'КОНТАКТЫ. Данные заказа для отправки в CRM. Переданы данные: '.$name.'; '.$phone.'; '.$email.'; '.$info.'; '.$value1.'; '.$value2.'; '.$value3.'; '.$value4.'; '.$value5.'; '.$value6.'; '.$value7.'; '.$value8, 'DEBUG');

if (!$name || !$phone || !$value8 || !$value6) {
  logFileWriter($memberId, 'КОНТАКТЫ. Заказ НЕ передан в CRM. Обязательные данные не заполнены. Возможно файл был запущен без аргументов.', 'ERROR');
  return 'error: the fields has been empty';
}

$curl = curl_init();

$data = [
'method' => 'create', // метод, 'create' - для создания, 'update' - для обновления, в данном случае использовать нет необходимости

'pipeline_id' => 81639, // id воронки "Заказы (не обязательное поле, если не указано используется воронка по-умолчанию)

'stage_id' => 366498, // id этапа (не обязательное поле, если не указано используется этап воронки по-умолчанию; 366498 - проверка заказа)

//'employee_id' => 0, // id ответственного сотрудника (не обязательное поле, если не указано, то ответственный не указывается, лид доступен всем, если значение 0, то "Администратор", если указан id сотрудника, то будет назначен сотрудник, чей id передан; 0 Алексей Р.; 418629 Женя Р.)

'inbox_type_id' => 458658, // id типа входящего обращения: 374553 - сайт, 458658 - обзвон

//'visit_id' => $_COOKIE['WhiteCallback_visit'], // идентификатор визита сервиса, будет присутствовать, если установлен js код наших виджетов, поле не обязательное, автоматически добавит информацию о посетителе, получается из Cookie

'values' => [ // массив значений системных и произвольных полей
'name' => $name ? $name : 'Заявка с сайта ' . ($phone ? $phone : $email), // имя
'phone' => $phone, // телефон
'email' => $email, // email
'comment' => $info, // примечание

//'utm_source' => $utm_source, // utm-метка utm_source
//'utm_medium' => $utm_medium, // utm-метка utm_medium
//'utm_campaign' => $utm_campaign, // utm-метка utm_campaign
//'utm_content' => $utm_content, // utm-метка utm_content
//'utm_term' => $utm_term, // utm-метка utm_utm_term

'custom' => [ // массив дополнительных полей
// в каждой строке массив идентификатора поля и его значения
['input_id' => 131211, 'value' => $value1], // количество
['input_id' => 131340, 'value' => $value2], // комментарий
['input_id' => 131586, 'value' => $value3], // страна
['input_id' => 131589, 'value' => $value4], // область
['input_id' => 131592, 'value' => $value5], // район
['input_id' => 131595, 'value' => $value6], // местность
['input_id' => 131598, 'value' => $value7], // адрес
['input_id' => 131601, 'value' => $value8]  // индекс
]
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
  logFileWriter($memberId, 'КОНТАКТЫ. Заказ передан в CRM. Присвоен ID '.$answer['id'], 'DEBUG');
  echo $answer['id'];
  //header("Location: https://www.bibleforall.ru/");
} else {
  if ($answer['id']) {
    $textAnswer = $answer['id'];
  } else {
    $textAnswer = 'ЗНАЧЕНИЕ В ОТВЕТЕ ОТСУТСТВУЕТ';
  }
  logFileWriter($memberId, 'КОНТАКТЫ. Возможно заказ '.$name.' НЕ ПЕРЕДАН в CRM. НЕТ ОТВЕТА С ID от сервера. Ответ: '.$textAnswer, 'ERROR');

  //EMAIL TO DEVELOPER
  $email = 'zhichkinroman@gmail.com';
  $error = null;
  $message = 'Админ: '.$memberId.' Не удалось получить ответ от CRM при отправке заказа на имя '.$name.' с сайта reg-page.ru. Ответ с сервера: '.$textAnswer;
  $res = EMAILS::sendEmail ($email, "Новый заказ с сайта регистрации", $message);
  if($res != null){
    $error = $res;
  }
  if($error == null){
    $textmext = 'Не удалось получить ответ от CRM. Отправлено уведомление по email разработчику.';
    logFileWriter($adminId, $textmext, 'FATAL');
    echo json_encode(["result"=>true]);
    exit;
  }
  echo 'Failed';
  //header("Location: https://www.reg-page.ru/");
}
*/
?>
