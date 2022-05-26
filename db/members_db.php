<?php
// Файл не подключен, копия функции в БД2. ПОДКЛЮЧАТЬ только в мембер для formTab.php
// получаем данные для комбобоксов
function getFttCombo ($table_name) {
  global $db;
  $table_name = $db->real_escape_string($table_name);
  $result;
  $res = db_query ("SELECT * FROM {$table_name}");
  while ($row = $res->fetch_assoc()) $result[$row['id']]=$row['name'];
  return $result;
}

// получаем группы благовестия
function getFttGospelTeam () {
  return getFttCombo('ftt_gospel_team');
}

// получаем группы изучения
function getFttStudyGroup () {
  return getFttCombo ('ftt_study_group');
}

// получаем группы изучения
function getFttApartments () {
  return getFttCombo ('ftt_apartment');
}

function db_getTraineeData($id) {
  global $db;
  $id = $db->real_escape_string($id);
  $result = [];
  $res = db_query("SELECT * FROM ftt_trainee WHERE `member_key`= '$id'");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

?>
