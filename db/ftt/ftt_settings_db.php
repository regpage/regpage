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
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $all = $db->real_escape_string($all);
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

  $result='';

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
  global $db;
  $adminId = $db->real_escape_string($adminId);
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
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $result='';
  $result = db_query ("DELETE FROM `ftt_extra_help` WHERE `archive` = 1");

  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблицы ПВОМ ftt_extra_help частично удалены служащим с ключом {$adminId}. Результат: {$result}");
  return $result;
}

// сброс пропущеных занятий, кроме долгов
function resetSkip($adminId) {
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $result='';
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

// сброс долгов и зависимых данных для закончивших обучение
function resetGraduate($adminId) {
  global $db;
  $adminId = $db->real_escape_string($adminId);
  // получаем список обучающихся
  $trainee = get_trainees_key();
  $result = 0;
  // ---- ПРОПУЩЕНЫЕ ЗАНЯТИЯ ----- //
  // ключи обучающихся присутствующие в таблице
  $exist = [];
  $dist_attendance_id = [];
  $pathsToFiles = [];
  // id листов посещаемости связанные с проп заданиями
  $res = db_query ("SELECT DISTINCT `id_attendance_sheet` FROM `ftt_skip`");
  while ($row = $res->fetch_assoc()) $dist_attendance_id[]=$row['id_attendance_sheet'];
  // уникальные участники в листах посещаемости
  foreach ($dist_attendance_id as $value) {
    $res = db_query ("SELECT DISTINCT `member_key` FROM `ftt_attendance_sheet` WHERE `id` = '$value'");
    while ($row = $res->fetch_assoc()) {
      if (array_search($row['member_key'], $trainee) === false) {
        // записываем пути к файлам перед удалением проп заданий
        $res = db_query ("SELECT `file` FROM `ftt_skip` WHERE `id_attendance_sheet` = '{$value}'");
        while ($row = $res->fetch_assoc()) $pathsToFiles[]=$row['file'];
        // удаляем проп задание
        db_query ("DELETE FROM `ftt_skip` WHERE `id_attendance_sheet` = '{$value}'");
        $result++;
      }
    }
  }
  // удаляем картинки
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
  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблицы ПВОМ ftt_skip и файлы частично (для закончивших обучение) удалены служащим с ключом {$adminId}. Результат: {$result}");

  // ---- ДОП. ЗАДАНИЯ ----- //
  $result = 0;
  $exist = [];
  $res = db_query ("SELECT DISTINCT `member_key` FROM `ftt_extra_help`");
  while ($row = $res->fetch_assoc()) $exist[]=$row['member_key'];
  foreach ($exist as $value) {
    if (array_search($value, $trainee) === false) {
      db_query ("DELETE FROM `ftt_extra_help` WHERE `member_key` = '{$value}'");
      $result++;
    }
  }
  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблицы ПВОМ ftt_extra_help частично (для закончивших обучение) удалены служащим с ключом {$adminId}. Результат: {$result}");
  // ---- БЛАНКИ ПОСЕЩАЕМОСТИ ----- //
  $result = 0;
  $exist = [];
  $id_sheet = [];
  $res = db_query ("SELECT DISTINCT `member_key` FROM `ftt_attendance_sheet`");
  while ($row = $res->fetch_assoc()) $exist[]=$row['member_key'];
  foreach ($exist as $value) {
    if (array_search($value, $trainee) === false) {
      $res = db_query ("SELECT `id` FROM `ftt_skip` WHERE `id_attendance_sheet` = '{$value}'");
      while ($row = $res->fetch_assoc()) $id_sheet[]=$row['id'];
      db_query ("DELETE FROM `ftt_attendance_sheet` WHERE `member_key` = '{$value}'");
      $result++;
    }
  }

  foreach ($id_sheet as $value) {
    db_query ("DELETE FROM `ftt_attendance` WHERE `sheet_id` = '{$value}'");
  }

  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблицы ПВОМ ftt_attendance_sheet и ftt_attendance частично (для закончивших обучение) удалены служащим с ключом {$adminId}. Результат: {$result}");
  if ($result >= 0) {
    $result = 1;
  }
  return $result;
}

// сброс чтения Библии у тех, кто закончил обучаться
function resetBible($adminId) {
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $result='';
  // получаем список обучающихся
  $trainee = get_trainees_key();

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

function get_trainees_key()
{
  // получаем список обучающихся
  $trainee = [];
  $res = db_query ("SELECT `member_key` FROM `ftt_trainee`");
  while ($row = $res->fetch_assoc()) $trainee[]=$row['member_key'];

  return $trainee;
}
