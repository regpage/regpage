<?php
require_once 'db/classes/member.php';
require_once 'db/classes/short_name.php';
require_once 'db/classes/date_convert.php';

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
    $date = date('m-d-Y H:i');
    $name = short_name::no_middle(Member::get_name(MEMBER_ID));
    $dataHistory = CallsDB::getCall($_GET['id']);
    $dataHistory = $dataHistory[0]['history'] . "Заявка взята в работу {$date} ({$name}) <br>";
    $data = (object) ['id' => $_GET['id'],'status' => 'В работе', 'operator' => MEMBER_ID, 'start_date' => date('Y-m-d H:i:s'), 'history' => $dataHistory];
    CallsDB::saveCall($data);
    echo json_encode(["result"=>CallsDB::getCall($_GET['id'])]);
  } else {
    echo json_encode(["result"=>CallsDB::getCall($_GET['id'])]);
  }
    exit();
}

// получить звонок
if (isset($_GET['type']) && $_GET['type'] === 'dlt_call'){
    echo CallsDB::dltcall($_GET['id']);
    exit();
}
