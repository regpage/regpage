<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/ftt/ftt_gospel_db.php";
// Подключаем ведение лога
//include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Получаем список
if(isset($_GET['type']) && $_GET['type'] === 'get_gospel_str') {
    echo json_encode(["result"=>getGospel($_GET['period'], $adminId, 'sort_date-desc', $_GET['from'], $_GET['to'], $_GET['team'])]);
    exit();
}

// Добавляем бланк
if(isset($_GET['type']) && $_GET['type'] === 'add_data_blank') {
    echo json_encode(["result"=>addDataBlank($_POST)]);
    exit();
}
// Правим бланк
if (isset($_GET['type']) && $_GET['type'] === 'update_data_blank') {
  echo json_encode(["result"=>updateDataBlank($_POST)]);
  exit();
}
// Удаляем бланк
if (isset($_GET['type']) && $_GET['type'] === 'delete_blank') {
  echo json_encode(["result"=>deleteBlank($_GET['id'])]);
  exit();
}

// set ftt_param
if (isset($_GET['type']) && $_GET['type'] === 'set_ftt_param') {
  echo json_encode(["result"=>setValueFttParamByName($_GET['name'], $_GET['value'])]);
  exit();
}

// set gospel goals
if (isset($_GET['type']) && $_GET['type'] === 'set_ftt_gospel_goals') {
  echo json_encode(["result"=>set_ftt_gospel_goals($_GET['gospel_team'], $_GET['gospel_group'], $_GET['column'], $_GET['value'])]);
  exit();
}

// get gospel groups
if (isset($_GET['type']) && $_GET['type'] === 'get_ftt_gospel_groups') {
  echo json_encode(["result"=>getGospelGroups($_GET['gospel_team'])]);
  exit();
}

// get group gospel goals
if (isset($_GET['type']) && $_GET['type'] === 'get_ftt_gospel_goals') {
  echo json_encode(["result"=>get_group_gospel_goals($_GET['gospel_team'], $_GET['gospel_group'])]);
  exit();
}

?>
