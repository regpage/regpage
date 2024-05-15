<?php
// Общение подраздел Активность Ajax
// подключаем запросы и классы
require_once "db/ftt/ftt_fellowship_db.php";
require_once "db/classes/db_operations.php";
require_once 'db/classes/ftt_lists.php';
require_once 'db/classes/emailing.php';
require_once 'db/classes/member.php';
require_once 'db/classes/short_name.php';
require_once 'db/classes/date_convert.php';
require_once 'db/classes/time_convert.php';

/*
// Описание.
if (isset($_GET['type']) && $_GET['type'] === 'get_communication_list') {
  echo json_encode(["result"=>get_communication_list($_GET['serving_ones'], $_GET['sort'])]);
  exit();
}

// Описание.
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
