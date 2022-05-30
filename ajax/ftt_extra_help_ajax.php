<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/ftt/ftt_extra_help_db.php";
// Подключаем ведение лога
//include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Добавляем строку
if(isset($_GET['type']) && $_GET['type'] === 'add_extra_help') {
    echo json_encode(["result"=>setAddExtraHelp($_POST)]);
    exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'update_extra_help') {
  echo json_encode(["result"=>updateAddExtraHelp($_POST)]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'delete_extra_help') {
  echo json_encode(["result"=>deleteExtraHelpString($_GET['id'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'set_extra_help_done') {
  echo json_encode(["result"=>setExtraHelpDone($_GET['id'], $_GET['archive'], $adminId)]);
  exit();
}

// ==== LATE ====
// set a late to done
if (isset($_GET['type']) && $_GET['type'] === 'set_late_done') {
  echo json_encode(["result"=>setLateDone($_GET['id'], $_GET['done'])]);
  exit();
}

// Добавляем строку
if(isset($_GET['type']) && $_GET['type'] === 'add_late'){
    echo json_encode(["result"=>setAddLate($_POST)]);
    exit();
}

// Обновляем строку
if (isset($_GET['type']) && $_GET['type'] === 'update_late') {
  echo json_encode(["result"=>updateAddLate($_POST)]);
  exit();
}

// удаляем строку
if (isset($_GET['type']) && $_GET['type'] === 'delete_late') {
  echo json_encode(["result"=>deleteLateString($_GET['id'])]);
  exit();
}

?>
