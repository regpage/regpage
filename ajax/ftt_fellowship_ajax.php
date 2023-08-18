<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/ftt/ftt_fellowship_db.php";
include_once "../db/classes/db_operations.php";
require_once '../db/classes/ftt_lists.php';

// Подключаем ведение лога
include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());
// COMMUNICATION
// get list
if (isset($_GET['type']) && $_GET['type'] === 'get_communication_list') {
  echo json_encode(["result"=>get_communication_list($_GET['serving_ones'], $_GET['sort'], $_GET['canceled'])]);
  exit();
}

// set record
if (isset($_GET['type']) && $_GET['type'] === 'set_communication_record') {
  echo json_encode(["result"=>set_communication_record($_GET['trainee'], $_GET['id'], $_GET['checked'], $_GET['date'], $_GET['time_from'], $_GET['time_to'])]);
  exit();
}

// set record
if (isset($_GET['type']) && $_GET['type'] === 'set_meet_staff_blank') {
  echo json_encode(["result"=>set_meet_staff_blank($_POST['data'])]);
  exit();
}
/*
if (isset($_GET['type']) && $_GET['type'] === 'set_communication_record_check') {
  // готовим данные
  $db_data = new DbData('set', 'ftt_fellowship');
  $db_data->set('field', 'trainee');
  $db_data->set('value', $_GET['trainee']);
  $db_data->set('condition_field', 'id');
  $db_data->set('condition_value', $_GET['id']);
  // выполняем
  echo json_encode(["result"=>DbOperation::operation($db_data->get())]);
  exit();
}
*/
if (isset($_GET['type']) && $_GET['type'] === 'set_communication_comment_trainee') {
  // готовим данные
  $db_data = new DbData('set', 'ftt_fellowship');
  $db_data->set('field', 'comment_train');
  $db_data->set('value', $_GET['comment']);
  $db_data->set('condition_field', 'id');
  $db_data->set('condition_value', $_GET['id']);
  // выполняем
  echo json_encode(["result"=>DbOperation::operation($db_data->get())]);
  exit();
}

// OVERNIGHT
// overnight
if (isset($_GET['type']) && $_GET['type'] === 'overnight') {
  echo json_encode(["result"=>db_overnight($_GET['member_key'], $_GET['date'])]);
  exit();
}

?>
