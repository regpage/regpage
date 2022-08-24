<?php
// Ajax
include_once "ajax.php";
// подключаем классы
//include_once "../db/classes/db_operations.php";
//include_once "../db/classes/member.php";
//include_once '../db/classes/date_convert.php';
// Подключаем ведение лога
//include_once "../extensions/write_to_log/write_to_log.php";

// насколько оправдано это обращение, можно получить его по гет или пост если если это безопасно
$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}
/*
//
if (isset($_GET['type']) && $_GET['type'] === '') {
  echo json_encode(["result"=>functions($_GET['id'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === '') {
  // готовим данные
  $db_data = new DbData('set', $_GET['table']);
  $db_data->set('field', $_GET['field']);
  $db_data->set('value', $_GET['value']);
  $db_data->set('condition_field', $_GET['condition_field']);
  $db_data->set('condition_value', $_GET['condition']);
  if ($_GET['changed'] === "1") {
    $db_data->set('changed', 1);
  }
  // запрос
  echo json_encode(['result'=>DbOperation::operation($db_data->get())]);

  exit();
}
*/
?>
