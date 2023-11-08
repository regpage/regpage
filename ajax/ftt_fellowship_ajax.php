<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/ftt/ftt_fellowship_db.php";
include_once "../db/classes/db_operations.php";
require_once '../db/classes/ftt_lists.php';
include_once '../db/classes/emailing.php';
include_once '../db/classes/member.php';
include_once '../db/classes/short_name.php';
include_once '../db/classes/date_convert.php';
include_once '../db/classes/time_convert.php';

// Подключаем ведение лога
include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());
// COMMUNICATION
// get list
if (isset($_GET['type']) && $_GET['type'] === 'get_communication_list') {
  echo json_encode(["result"=>get_communication_list($_GET['serving_ones'], $_GET['sort'])]);
  exit();
}

// get records by date
if (isset($_GET['type']) && $_GET['type'] === 'get_meet_by_date') {
  echo json_encode(["result"=>get_meet_by_date($_GET['date'], $_GET['serving_ones'])]);
  exit();
}

// set record
if (isset($_GET['type']) && $_GET['type'] === 'set_communication_record') {
  echo json_encode(["result"=>set_communication_record($_GET['trainee'], $_GET['id'], $_GET['checked'], $_GET['date'], $_GET['time_from'], $_GET['time_to'], $_GET['comment'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'cancel_communication_record') {
  echo json_encode(["result"=>cancel_communication_record($_GET['id'], $_GET['comment'])]);
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
  // отправляем уведомление
  if (!empty($_GET['comment'])) {
    send_email_to_staff($_GET['id']);
  }
  exit();
}


?>
