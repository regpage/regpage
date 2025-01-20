<?php
require_once 'db/classes/member.php';
require_once 'db/classes/short_name.php';
require_once 'db/classes/date_convert.php';
require_once 'extensions/to_logs/to_logs.php';

// сохранить звонок
if (isset($_GET['type']) && $_GET['type'] === 'save_call'){
    echo CallsDB::saveCall(json_decode($_POST['data']));
    exit();
}

// отменить звонок
if (isset($_GET['type']) && $_GET['type'] === 'cancel_call'){
    echo CallsDB::cancelCall($_GET['id']);
    exit();
}

// получить звонок
if (isset($_GET['type']) && $_GET['type'] === 'get_call'){
  if (isset($_GET['get_to_work']) && $_GET['get_to_work'] === '1') {
    $name = short_name::no_middle(Member::get_name(MEMBER_ID));
    $dataHistory = CallsDB::getCall($_GET['id']);
    $dataHistory = $dataHistory[0]['history'] . date('d-m-Y H:i') . " Заявка взята в работу ({$name}) <br>";
    $data = (object) ['id' => $_GET['id'],'status' => 'В работе', 'operator' => MEMBER_ID, 'start_date' => date('Y-m-d H:i:s'), 'history' => $dataHistory];
    CallsDB::saveCall($data);
    echo json_encode(["result"=>CallsDB::getCall($_GET['id'])]);
  } else {
    echo json_encode(["result"=>CallsDB::getCall($_GET['id'])]);
  }
    exit();
}

// удалить звонок
if (isset($_GET['type']) && $_GET['type'] === 'dlt_call'){
    echo CallsDB::dltcall($_GET['id']);
    exit();
}

// отправка в CRM
if (isset($_GET['type']) && $_GET['type'] === 'crm_send'){
  $name = short_name::no_middle(Member::get_name(MEMBER_ID));
  $dataCall = CallsDB::getCall($_GET['id'])[0];
  $dataHistory = $dataCall['history'] . "Заявка отправлена в СРМ " . date('d-m-Y H:i') . " ({$name}) <br>";
  $data = (object) ['id' => $_GET['id'], 'status' => 'Заказ', 'done' => 1, 'end_date' => date('Y-m-d H:i:s'), 'history' => $dataHistory];
  CallsDB::saveCall($data);
  if (isset($_GET['out'])) {
    $_POST['info'] = 'Звонил(а) ' . short_name::no_middle(Member::get_name($dataCall['operator']));
    require_once 'api_v1.php';
  }
  exit();
}

// проверка существования номера телефона в CRM
if (isset($_GET['type']) && $_GET['type'] === 'crm_check_phone'){
  $name = short_name::no_middle(Member::get_name(MEMBER_ID));
  $dataCall = CallsDB::getCall($_GET['id'])[0];
  $dataHistory = $dataCall['history'] . "Заявка отправлена в СРМ " . date('d-m-Y H:i') . " ({$name}) <br>";
  $data = (object) ['id' => $_GET['id'], 'status' => 'Заказ', 'done' => 1, 'end_date' => date('Y-m-d H:i:s'), 'history' => $dataHistory];
  CallsDB::saveCall($data);
  if (isset($_GET['out'])) {
    $_POST['info'] = 'Звонил(а) ' . short_name::no_middle(Member::get_name($dataCall['operator']));
    require_once 'api_v1.php';
  }
  exit();
}
