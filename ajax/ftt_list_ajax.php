<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/classes/db_operations.php";
include_once "../db/classes/member.php";
include_once '../db/ftt/ftt_list_db.php';
// Подключаем ведение лога
//include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Добавить одно мероприятие в ручную.

if (isset($_GET['type']) && $_GET['type'] === 'get_member_data') {
  echo json_encode(["result"=>Member::get_data($_GET['id'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'get_member_data_staff') {
  echo json_encode(["result"=>Member::get_data_staff($_GET['id'])]);
  exit();
}

// save blank
if (isset($_GET['type']) && $_GET['type'] === 'save_blank') {
  echo json_encode(["result"=>save_blank($_POST['data'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'change_field') {
  // Сохранение изменений в полях бланка
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

?>
