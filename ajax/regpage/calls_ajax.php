<?php
// сохранить звонок
if (isset($_GET['type']) && $_GET['type'] === 'save_call'){
    echo CallsDB::saveCall($_POST['data']);
    exit();
}

// получить звонок
if (isset($_GET['type']) && $_GET['type'] === 'get_call'){
  if (isset($_GET['get_to_work']) && $_GET['get_to_work'] === '1') {
    $data = json_encode((object) ['id' => $_GET['id'],'status' => 'В работе', 'operator' => MEMBER_ID, 'start_date' => date("Y-m-d H:i:s")]);
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
