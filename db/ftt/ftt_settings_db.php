<?php
// данные семестра ПВОМ
// проверка наличия строк в таблицах
$tables = array('ftt_trainee', 'ftt_announcement', 'ftt_announcement_recipients', 'ftt_attendance', 	'ftt_attendance_sheet', 'ftt_extra_help', 'ftt_gospel', 'ftt_gospel_members', 'ftt_gospel_goals', 'ftt_late', 'ftt_permission', 'ftt_permission_sheet', 'ftt_session', 'ftt_session_correction', 'ftt_skip', 'ftt_fellowship', 'ftt_fellowship_tmpl', 'ftt_bible', 'ftt_service');
function checkDataSemester() {
    global $tables;
    $result = array();
    foreach ($tables as $key => $value) {
      $result[$value] = db_query ("SELECT * FROM {$value} limit 1");
    }
    //while ($row = $res->fetch_assoc()) $result[]=$row;
    return $result;
}
// проверка наличия строк в таблицах
function checkOtherDataSemester() {
    $tables = array('ftt_serving_one', 'ftt_apartment', 'ftt_service', 'ftt_param', 'ftt_study_group', 'ftt_gospel_team');
    $result = array();
    foreach ($tables as $key => $value) {
      $result[$value] = db_query ("SELECT * FROM {$value} limit 1");
    }

    return $result;
}

function resetSemester($adminId){
  global $tables;
  // ftt_skip prepare
  $pathsToFiles = [];
  $res=db_query ("SELECT `file` FROM `ftt_skip`");
  while ($row = $res->fetch_assoc()) $pathsToFiles[]=$row['file'];

  foreach ($pathsToFiles as $paths) {
    if (empty($paths)) {
      continue;
    }
    $paths = explode(';', $paths);

    foreach ($paths as $file) {
      $root = __DIR__;
      $root = explode('panelsource', $root);
      if (file_exists($root[0].$file)) {
        unlink($root[0].$file);
      }
    }
  }

  $result;

  foreach ($tables as $value) {
    $result = db_query ("DELETE FROM {$value}");
  }

  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблиц ПВОМ удалены служащим с ключом {$adminId}. Результат: {$result}");
  return $result;
}

// анкеты для поступления на ПВОМ
// наличие строк в таблице
function checkApplicationData(){
    $tables = array('ftt_request', 'ftt_request_points');
    $result = array();
    foreach ($tables as $key => $value) {
      $result[$value] = db_query ("SELECT * FROM {$value} limit 1");
    }

    return $result;
}
// удаление всех строк в таблице и файлы с диска
function resetApplications() {
// не удаляет фотографии с диска
  $tables = array('ftt_request');
  $result;

  foreach ($tables as $value) {
    $result = db_query ("DELETE FROM {$value}");
  }
  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблиц ПВОМ удалены служащим с ключом {$adminId}. Результат: {$result}");
  return $result;
}
