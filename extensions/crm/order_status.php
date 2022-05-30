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

/**
 *
 */
class Getfromcrm {

  //private $aFuncName = 'aMemberFunc';
  public $datavata;
  //function __construct($field, $condition, $link) {
   public function getdata($field, $condition, $link) {
    $curl = curl_init();

    $data = [$field => $condition];

    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_URL, $link);
    curl_setopt($curl,CURLOPT_POST,true);
    curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode(['request' => $data]));
    curl_setopt($curl,CURLOPT_HEADER,false);

    $out=curl_exec($curl);
    $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
    curl_close($curl);

    return json_decode($out, true);
  }
}


function queryfromcrm($field, $condition, $link){
// Сделать проверку на число и единый класс
  $curl = curl_init();

  $data = [$field => $condition];

  curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($curl,CURLOPT_URL, $link);
  curl_setopt($curl,CURLOPT_POST,true);
  curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode(['request' => $data]));
  curl_setopt($curl,CURLOPT_HEADER,false);

  $out=curl_exec($curl);
  $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
  curl_close($curl);

  return json_decode($out, true);
}

$link = 'https://bibleforall.envycrm.com/crm/api/v1/lead/get/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';

//$condition = $_GET['lead_id'] * 1;

//$answer = queryfromcrm('lead_id', $_GET['lead_id'], $link);
$datanevata = new Getfromcrm;
$answer = $datanevata->getdata('lead_id', $_GET['lead_id'], $link);
if ($answer['message'] === 'success') {
  logFileWriter($memberId, 'КОНТАКТЫ. Заказ передан в CRM. Присвоен ID '.$answer['id'], 'DEBUG');
  //echo json_encode($answer);
  if (count($answer['result']['deals']) > 0) {
    # Можно выберать наибольший номер сделки, но, возможно, это бесперспективно
    // get deal
    $somedeal = end($answer['result']['deals']);
    $link = 'https://bibleforall.envycrm.com/crm/api/v1/deal/get/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
    $answer2 = queryfromcrm('deal_id', $somedeal, $link);
    if ($answer2['result']['client_id']) {
      $link = 'https://bibleforall.envycrm.com/crm/api/v1/client/get/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
      $answer3 = queryfromcrm('client_id', $answer2['result']['client_id'], $link);
      if (end($answer3['result']['deals'])) {
        $link = 'https://bibleforall.envycrm.com/crm/api/v1/deal/get/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
        $last_deal = end($answer3['result']['deals']);
        $answer4 = queryfromcrm('deal_id', $last_deal['id'], $link);
        if ($answer4['result']['stage_id'] == 366501) {
          echo substr($answer4["result"]["stage_updated_at"],0,10)."-o-o->".$answer4["result"]["stage_name"]."-o-o->".$answer4["result"]["values"]["custom"]["crm_132909"]["value"];
        } else {
          echo "NONE-o-o->".$answer4["result"]["stage_name"]."-o-o->".$answer4["result"]["values"]["custom"]["crm_132909"]["value"];
        }
      } else {
        //error
        //$answer4['message'];
      }
    } else {
      //error
      //$answer3['message'];
    }
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
  $message = 'Админ: '.$memberId.' Не удалось получить ответ от CRM при запросе лида с сайта reg-page.ru. Ответ с сервера: '.$textAnswer;
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
