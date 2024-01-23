<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
//include_once "../db/classes/db_operations.php";

include_once '../db/ftt/ftt_settings_db.php';
// Подключаем ведение лога
include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Добавить одно мероприятие в ручную.
if (isset($_GET['type']) && $_GET['type'] === 'reset_semester') {
  if (empty($_GET['all'])) {
    resetExtraHelp($adminId);
    resetSkip($adminId);    
  }

  echo resetSemester($adminId, $_GET['all']);
  exit();
}

// Удалить заявления
if (isset($_GET['type']) && $_GET['type'] === 'reset_applications') {
  echo resetApplications($adminId);
  exit();
}

// Удалить доп. помощи без долгов
if (isset($_GET['type']) && $_GET['type'] === 'partial_reset_extra_help') {
  echo resetExtraHelp($adminId);
  exit();
}

// Удалить пропущенные занятия без долгов
if (isset($_GET['type']) && $_GET['type'] === 'partial_reset_skip') {
  echo resetSkip($adminId);
  exit();
}

// Удалить чтение библии для закончивших обучение
if (isset($_GET['type']) && $_GET['type'] === 'partial_reset_bible') {
  echo resetBible($adminId);
  exit();
}
