<?php
// данные семестра ПВОМ
// список таблиц
$tables = array('ftt_trainee', 'ftt_session', 'ftt_session_correction', 'ftt_announcement', 'ftt_announcement_recipients', 'ftt_attendance', 	'ftt_attendance_sheet', 'ftt_permission', 'ftt_permission_sheet', 'ftt_skip', 'ftt_fellowship', 'ftt_fellowship_tmpl', 'ftt_service', 'ftt_gospel', 'ftt_gospel_members', 'ftt_gospel_goals', 'ftt_extra_help', 'ftt_late', 'ftt_bible');

// проверка наличия строк в таблицах
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
    $tables = array('ftt_serving_one', 'ftt_apartment', 'ftt_param', 'ftt_study_group', 'ftt_gospel_team', 'ftt_bbd');
    $result = array();
    foreach ($tables as $key => $value) {
      $result[$value] = db_query ("SELECT * FROM {$value} limit 1");
    }

    return $result;
}

function resetSemester($adminId, $all){
  $exception = 'ftt_bible';
  global $tables;
  if ($all) {
    $tablesArr = $tables;
    // ftt_skip prepare
    $pathsToFiles = [];
    $res = db_query ("SELECT `file` FROM `ftt_skip`");
    while ($row = $res->fetch_assoc()) $pathsToFiles[]=$row['file'];

    foreach ($pathsToFiles as $paths) {
      if (empty($paths)) {
        continue;
      }
      $paths = explode(';', $paths);

      foreach ($paths as $file) {
        $root = __DIR__;
        $root = explode('ajax', $root);
        if (file_exists($root[0].$file)) {
          unlink($root[0].$file);
        }
      }
    }
  } else {
    $tablesArr = array('ftt_announcement', 'ftt_announcement_recipients', 'ftt_gospel', 'ftt_gospel_members', 'ftt_gospel_goals', 'ftt_late', 'ftt_permission', 'ftt_permission_sheet', 'ftt_session_correction', 'ftt_fellowship', 'ftt_fellowship_tmpl', 'ftt_service');
  }

  $result;

  foreach ($tablesArr as $value) {
    if ($value === $exception) {
      continue;
    }
    $result = db_query ("DELETE FROM {$value}");
  }

  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблиц ПВОМ удалены служащим с ключом {$adminId}. Результат: {$result}");
  return $result;
}

// анкеты для поступления на ПВОМ
// наличие строк в таблице
function checkApplicationData() {
    $tables = array('ftt_request', 'ftt_request_points');
    $result = array();
    foreach ($tables as $key => $value) {
      $result[$value] = db_query ("SELECT * FROM {$value} limit 1");
    }

    return $result;
}
// удаление всех строк в таблице
// не удаляет фотографии с диска
function resetApplications($adminId) {
  $tables = array('ftt_request');
  $result;

  foreach ($tables as $value) {
    $result = db_query ("DELETE FROM {$value}");
  }
  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблицы ftt_request ПВОМ удалены служащим с ключом {$adminId}. Результат: {$result}");
  return $result;
}

// сброс доб. заданий, кроме долгов
function resetExtraHelp($adminId) {
  $result;
  $result = db_query ("DELETE FROM `ftt_extra_help` WHERE `archive` = 1");

  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблицы ПВОМ ftt_extra_help частично удалены служащим с ключом {$adminId}. Результат: {$result}");
  return $result;
}

// сброс пропущеных занятий, кроме долгов
function resetSkip($adminId) {
  $result;
  // ftt_skip prepare
  $pathsToFiles = [];
  $res = db_query ("SELECT `file` FROM `ftt_skip` WHERE `status` = 2");
  while ($row = $res->fetch_assoc()) $pathsToFiles[]=$row['file'];

  foreach ($pathsToFiles as $paths) {
    if (empty($paths)) {
      continue;
    }
    $paths = explode(';', $paths);

    foreach ($paths as $file) {
      $root = __DIR__;
      $root = explode('ajax', $root);
      if (file_exists($root[0].$file)) {
        unlink($root[0].$file);
      }
    }
  }

  $result = db_query ("DELETE FROM `ftt_skip` WHERE `status` = 2");
  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблицы ПВОМ ftt_skip и файлы частично удалены служащим с ключом {$adminId}. Результат: {$result}");
  return $result;
}

// сброс чтения Библии у тех, кто закончил обучаться
function resetBible($adminId) {
  $result;
  // ftt_skip prepare
  $trainee = [];
  $res = db_query ("SELECT `member_key` FROM `ftt_trainee`");
  while ($row = $res->fetch_assoc()) $trainee[]=$row['member_key'];

  $exist = [];
  $res = db_query ("SELECT DISTINCT `member_key` FROM `ftt_bible`");
  while ($row = $res->fetch_assoc()) $exist[]=$row['member_key'];

  foreach ($exist as $value) {
    if (array_search($value, $trainee) === false) {
        $result = db_query ("DELETE FROM `ftt_bible` WHERE `member_key` = '{$value}'");
    }
  }

  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблицы ПВОМ ftt_bible и файлы частично удалены служащим с ключом {$adminId}. Результат: {$result}");
  return $result;
}
