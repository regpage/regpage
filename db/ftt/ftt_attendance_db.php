<?php
// Классы. Конвертация дат Не ПОДКЛЮЧАЕТСЯ!
if (isset($GLOBALS['global_root_path'])) {
  include_once $GLOBALS['global_root_path'].'db/classes/ftt_info.php';
} else {
  include_once __DIR__.'/../classes/ftt_info.php';
}

//echo __DIR__ . DIRECTORY_SEPARATOR;
function yyyymmdd_to_ddmm ($date)  {
  if (!$date) {
    return 'No date';
  }
  $date = explode('-', $date);
  if (isset($date[2])) {
    return $date[2].'.'.$date[1];
  } else {
    return 'Date is incorrect.';
  }
}
// ПОСЕЩАЕМОСТЬ
// получаем "своих" обучающихся
function getMyTrainee($admin_id) {
  global $db;
  $admin_id = $db->real_escape_string($admin_id);
  $result = [];
  $res = db_query("SELECT tra.member_key, m.name
    FROM ftt_trainee AS tra
    INNER JOIN member m ON m.key = tra.member_key
    WHERE tra.serving_one='$admin_id' ORDER BY m.name");
  while ($row = $res->fetch_assoc()) $result[$row['member_key']] = short_name::no_middle($row['name']);
  return $result;
}
// получаем шапки
function getFttAttendanceSheet() {
  $result = [];
  $res = db_query("SELECT `id`, `member_key`, `date`, `comment`, `status`, `date_send`, `morning_revival`, `personal_prayer`, `common_prayer`, `bible_reading`, `ministry_reading` FROM `ftt_attendance_sheet` WHERE 1");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}
// получаем строки по id_sheet
function getFttStringsByIdSheet($sheet_id) {
  global $db;
  $sheet_id = $db->real_escape_string($sheet_id);
  $result = [];

  $res = db_query("SELECT `id`, `sheet_id`, `session_name`, `session_time`, `attend_time`, `reason`, `late` FROM `ftt_attendance` WHERE `sheet_id` = '$sheet_id' ORDER BY `session_time`");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

// получаем шапки и строки
// НЕ РАБОТАЕТ В СТАФ ИЗ-ЗА ТОГО что прошло более недели от окончания обучения.
// Но архив нужно выводить в любом случае.
function getFttAttendanceSheetAndStrings($list_access, $condition, $admin_id = '') {
  //fas.id as fas_id, fas.sheet_id, fas.session_name, fas.session_time, fas.attend_time, fas.reason, fas.late
  //INNER JOIN ftt_attendance fa ON fa.sheet_id = fas.id
  // AS fas

  global $db;
  $list_access = $db->real_escape_string($list_access);
  $condition = $db->real_escape_string($condition);
  $admin_id = $db->real_escape_string($admin_id);
  $list_access_condition;
  $order_by = '';
  $last_date;
  // Проверяем что расписание не выходит за период обучения
  if (ftt_info::days_to_end() < -7 && $list_access === '_all_') {
    $last_date_res = db_query("SELECT MAX(fas.date) AS largest_date FROM ftt_attendance_sheet AS fas");
    while ($row = $last_date_res->fetch_assoc()) $last_date = $row['largest_date'];
  }

  // доступ служащий / обучающийся
  if ($list_access === '_all_') {
    $list_access_condition = '';
  } else {
    $list_access_condition = " fas.member_key='$list_access' ";
  }

  // периоды (для служащих всегда  week)
  if ($condition === 'week') {
    if ($list_access_condition) {
      // это работает только для обучающихся
      $condition = $list_access_condition.' AND DATE(fas.date) > (NOW() - INTERVAL 7 DAY) ';
    } else {
      // это работает только для сдужащих
      if ($last_date) {
        $condition = " fas.date = '$last_date' ";
      } else {
        $condition = ' DATE(fas.date) > (NOW() - INTERVAL 7 DAY) ';
      }
    }
  } elseif ($condition === 'month') {
    if ($list_access_condition) {
      $condition = $list_access_condition.' AND DATE(fas.date) > (NOW() - INTERVAL 1 MONTH) ';
    } else {
      $condition = ' DATE(fas.date) > (NOW() - INTERVAL 1 MONTH) ';
    }
  } elseif ($condition === '_all_') {
    if (!$list_access_condition) {
      $condition = 1;
    } else {
      $condition = $list_access_condition;
    }
  }
  // выборка по служащему
  if ($admin_id && $admin_id !== '_all_' && $condition === 1) {
    $condition = " tra.serving_one='$admin_id' ";
  } elseif ($admin_id === '_all_' && $condition === 1) {

  } elseif ($admin_id === '_all_' && $condition !== 1) {

  } elseif ($admin_id && $admin_id !== '_all_' && $condition !== 1) {
    $condition .= " AND tra.serving_one='$admin_id' ";
  }

  if ($admin_id) {
    $order_by = ' m.name ASC, fas.date ';
  } else {
    $order_by = ' fas.date ASC, m.name ';
  }

  $header = [];
  $strings = [];
  $res = db_query("SELECT fas.id, fas.member_key, fas.date, fas.comment, fas.status, fas.date_send, fas.bible,
     fas.morning_revival, fas.personal_prayer, fas.common_prayer, fas.bible_reading, fas.ministry_reading,
     m.name, tra.serving_one, tra.pause_start, tra.pause_stop, tra.pause_comment
    FROM ftt_attendance_sheet AS fas
    INNER JOIN member m ON m.key = fas.member_key
    INNER JOIN ftt_trainee tra ON tra.member_key = fas.member_key
    WHERE {$condition}
    ORDER BY {$order_by}");
  while ($row = $res->fetch_assoc()) $header[] = $row;

/* // получени строк отключено из соображения производительности
  for ($i=0; $i < count($header); $i++) {
    $sheet_id = $header[$i]['id'];

    $res2 = db_query("SELECT `id`, `sheet_id`, `session_name`, `session_time`, `attend_time`, `reason`, `late`
      FROM `ftt_attendance`
      WHERE `sheet_id` = '$sheet_id'");
      while ($row2 = $res2->fetch_assoc()) $header[$i]['strings'][] = $row2;
  }
*/
  return $header;
}

// Получаем строки для бланка
function get_sessions($id) {
  global $db;
  $id = $db->real_escape_string($id);
  $strings = [];
  $res = db_query("SELECT `id`, `sheet_id`, `session_name`, `session_time`, `attend_time`, `reason`, `late`, `absence`, `visit`, `end_time`, `duration`
    FROM `ftt_attendance`
    WHERE `sheet_id` = '$id' ORDER BY `session_time`");
    while ($row = $res->fetch_assoc()) $strings[] = $row;

    return $strings;
}

// обновляем строки по id ???
function setFttStringsById($data) {
  global $db;
  $id = $db->real_escape_string($data['id']);
  $session_name = $db->real_escape_string($data['session_name']);
  $session_time = $db->real_escape_string($data['session_time']);
  $attend_time = $db->real_escape_string($data['attend_time']);
  $reason = $db->real_escape_string($data['reason']);
  $late = $db->real_escape_string($data['late']);

  $res = db_query("INSERT INTO `ftt_attendance` (`session_name`, `session_time`, `attend_time`, `reason`, `late`, `changed`) VALUES ('$session_name', '$session_time','$attend_time', '$reason','$late', 1)");
  while ($row = $res->fetch_assoc()) $result[] = $row;

  return $res;
}

// Добавляем header (?) НЕИСПОЛЬЗУЕТСЯ
function setFttSheetById($data) {
  global $db;
  $id = $db->real_escape_string($data['id']);
  $comment = $db->real_escape_string($data['comment']);
  $status = $db->real_escape_string($data['status']);
  $date_send = $db->real_escape_string($data['date_send']);
  $morning_revival = $db->real_escape_string($data['morning_revival']);
  $personal_prayer = $db->real_escape_string($data['personal_prayer']);
  $common_prayer = $db->real_escape_string($data['common_prayer']);
  $bible_reading = $db->real_escape_string($data['bible_reading']);
  $ministry_reading = $db->real_escape_string($data['ministry_reading']);

  $res = db_query("INSERT INTO `ftt_attendance_sheet` (`comment`, `status`, `date_send`, `morning_revival`, `personal_prayer`, `common_prayer`, `bible_reading`, `ministry_reading`, `changed`)
    VALUES ('$comment', '$status','$date_send', '$morning_revival', '$personal_prayer', '$common_prayer', '$bible_reading', '$ministry_reading', 1) WHERE `id` = '$id'");

  return $res;
}

function set_attendance($id, $field, $value, $header) {
  global $db;
  $id = $db->real_escape_string($id);
  $field = $db->real_escape_string($field);
  $value = $db->real_escape_string($value);
  $header = $db->real_escape_string($header);
  $table = 'ftt_attendance';
  if ($header == 1) {
    $table = 'ftt_attendance_sheet';
  }
  $res = db_query("UPDATE `$table` SET `$field` = '$value', `changed` = 1  WHERE `id` = '$id'");

  if ($field === 'status') {
    db_query("UPDATE `$table` SET `date_send` = NOW(), `changed` = 1  WHERE `id` = '$id'");
  }

  return $res;
}

function set_attendance_time($id, $field, $time, $late, $absence) {
  global $db;
  $id = $db->real_escape_string($id);
  $time = $db->real_escape_string($time);
  $late = $db->real_escape_string($late);
  $absence = $db->real_escape_string($absence);
  $field = $db->real_escape_string($field);

  $res = db_query("UPDATE `ftt_attendance` SET `$field` = '$time', `late` = '$late', `absence` = '$absence', `changed` = 1  WHERE `id` = '$id'");
  return $res;
}

function set_attendance_archive ($id, $archive) {
  global $db;
  $id = $db->real_escape_string($id);
  $archive = $db->real_escape_string($archive);
  $result = '';
  $res = db_query("UPDATE `ftt_attendance_sheet` SET `status` = '$archive', `date_send` = NOW(), `changed`=1  WHERE `id` = '$id'");
  if ($res) {
    $res2 = db_query("SELECT `date_send`, `status` FROM `ftt_attendance_sheet` WHERE `id` = '$id'");
    while ($row = $res2->fetch_assoc()) $result = [$row['date_send'], $row['status']];
  } else {
    return false;
  }
  return $result;
}

function set_late_automatic($member_key, $date, $delay, $session_name, $end_time=0, $id_attendance) {
  global $db;
  $result = [];
  $member_key = $db->real_escape_string($member_key);
  $date = $db->real_escape_string($date);
  $delay = $db->real_escape_string($delay);
  $session_name = $db->real_escape_string($session_name);
  $end_time = $db->real_escape_string($end_time);

  $res = db_query("INSERT INTO `ftt_late` (`member_key`, `date`, `delay`, `session_name`, `end_time`, 'id_attendance', `changed`)
  VALUES ('$member_key', '$date', '$delay', '$session_name', '$id_attendance', '$end_time', 1)");

  $res2 = db_query("SELECT fl.id, fl.member_key, fl.date, fl.delay, fl.session_name, fl.end_time, fl.done, fl.author, fl.changed
      FROM ftt_late AS fl
      WHERE fl.member_key = '$member_key' AND fl.done = 0
      ORDER BY fl.date DESC");
    while ($row = $res2->fetch_assoc()) $result[] = $row;

    if (count($result) >= 3) {
      $count_lates_tmp = count($result);
      $count_lates = round($count_lates_tmp / 3) * 3;

      for ($i=0; $i < $count_lates; $i=$i+3) {
        if ($result[$i]['end_time'] == 1) {
          $text_msg = 'приход раньше';
        } else {
          $text_msg = 'опоздание';
        }
        if ($result[$i+1]['end_time'] == 1) {
          $text_msg_1 = 'приход раньше';
        } else {
          $text_msg_1 = 'опоздание';
        }
        if ($result[$i+2]['end_time'] == 1) {
          $text_msg_2 = 'приход раньше';
        } else {
          $text_msg_2 = 'опоздание';
        }
        $condition = "`id`='".$result[$i]['id']."' OR `id`='".$result[$i+1]['id']."' OR `id`='".$result[$i+2]['id']."'";
        $res3 = db_query("UPDATE `ftt_late` SET `done` = 1, `changed` = 1 WHERE {$condition}");
        $reason_text = yyyymmdd_to_ddmm($result[$i]['date']).' '.$result[$i]['session_name'].' — '.$text_msg.' на '.$result[$i]['delay'].' мин.\r\n';
        $reason_text .= yyyymmdd_to_ddmm($result[$i+1]['date']).' '.$result[$i+1]['session_name'].' — '.$text_msg_1.' на '.$result[$i+1]['delay'].' мин.\r\n';
        $reason_text .= yyyymmdd_to_ddmm($result[$i+2]['date']).' '.$result[$i+2]['session_name'].' — '.$text_msg_2.' на '.$result[$i+2]['delay'].' мин.\r\n';
        $res4 = db_query("INSERT INTO `ftt_extra_help` (`date`, `member_key`, `reason`, `changed`) VALUES (NOW(), '$member_key', '$reason_text', 1)");
      }
    }
  return count($result).' '.$count_lates;
}

function set_extrahelp_automatic($member_key, $date, $reason, $end_time=0) {
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $date = $db->real_escape_string($date);
  $reason = $db->real_escape_string($reason);

  $res = db_query("INSERT INTO `ftt_extra_help` (`member_key`, `date`, `reason`, `changed`)
  VALUES ('$member_key', '$date', '$reason', 1)");
  return $res;
}

// STAFF FUNCTIONS
function dlt_sessions_in_blank($sheet_id) {
  global $db;
  $sheet_id = $db->real_escape_string($sheet_id);
  $res = db_query("DELETE FROM `ftt_attendance` WHERE `sheet_id` = $sheet_id");
}

// add/delete string session in blank
function add_sessions_staff($session) {
  global $db;
  $sheet_id = $db->real_escape_string(trim($session->id_sheet));
  $session_id = $db->real_escape_string(trim($session->session_id));
  $session_name = $db->real_escape_string(trim($session->session_name));
  $session_time = $db->real_escape_string(trim($session->session_time));
  $duration = $db->real_escape_string(trim($session->duration));
  $visit = $db->real_escape_string(trim($session->visit));
  $end_time = $db->real_escape_string(trim($session->end_time));

  $res = db_query("INSERT INTO `ftt_attendance` (`sheet_id`, `session_id`, `session_name`, `session_time`, `visit`, `end_time`, `duration`, `changed`)
  VALUES ('$sheet_id', '$session_id', '$session_name','$session_time', '$visit', '$end_time', '$duration', 1)");
  return $res;
}

function add_sessions_staff_all($sessions) {
  $res="";
  $sessions = json_decode($sessions);
  for ($i=0; $i < count($sessions); $i++) {
    $res .= add_sessions_staff($sessions[$i]);
  }
  return $res;
}

function dlt_session_staff($sessions)
{
  global $db;
  $session = json_decode($sessions);
  $sheet_id = $db->real_escape_string(trim($session->id_sheet));
  $session_id = $db->real_escape_string(trim($session->session_id));
  $session_time = $db->real_escape_string(trim($session->session_time));
  if ($sheet_id) {
    $res = db_query("DELETE FROM `ftt_attendance` WHERE `sheet_id` = $sheet_id AND `session_id`='$session_id'");
  } else {
    $res = db_query("DELETE FROM `ftt_attendance` WHERE `sheet_id` = $sheet_id AND `session_time`='$session_time'");
  }

}

function add_session_staff($sessions)
{
  global $db;
  $session = json_decode($sessions);
  $sheet_id = $db->real_escape_string(trim($session->id_sheet));
  $session_id = $db->real_escape_string(trim($session->session_id));
  $session_time = $db->real_escape_string(trim($session->session_time));
  if ($sheet_id) {
    $res = db_query("SELECT `id` FROM ftt_attendance WHERE `sheet_id` = $sheet_id AND `session_id` = '$session_id'");
  } else {
    $res = db_query("SELECT `id` FROM ftt_attendance WHERE `sheet_id` = $sheet_id AND `session_time` = '$session_time'");
  }
  $row = $res->fetch_assoc();

  if (!isset($row['id'])) {
      add_sessions_staff($session);
  }
}

function getSessionStaff($value='') {
  /*
  1. Получаем семестр (и др. правила)
  2. Получаем корректировки
  3. Получаем расписание на заданое число
  4. Отправляем данные в представление
  5. При необходимости сохраняем (учитывать существующие строки). Ненужные строки удаляем.
  $res_correction = db_query("SELECT * FROM ftt_session_correction WHERE (`date` > (NOW() - INTERVAL 1 DAY)) AND (`date` < (NOW() + INTERVAL 1 DAY)) AND `attendance` = 1");
  while ($row = $res_correction->fetch_assoc()) $correction[] = $row;
  */
  return 1;
}

?>
