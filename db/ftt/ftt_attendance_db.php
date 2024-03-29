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
// получаем шапки
function getFttAttendanceSheet() {
  $result = [];
  $res = db_query("SELECT `id`, `member_key`, `date`, `comment`, `status`, `date_send`, `morning_revival`, `personal_prayer`, `common_prayer`, `prophecy`, `bible_reading`, `ministry_reading` FROM `ftt_attendance_sheet` WHERE 1");
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
     fas.morning_revival, fas.personal_prayer, fas.common_prayer, fas.prophecy, fas.bible_reading, fas.ministry_reading, fas.mark,
     fas.bible_book, fas.bible_chapter,
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
  $res = db_query("SELECT `id`, `sheet_id`, `session_name`, `session_time`, `attend_time`, `reason`, `permission_sheet_id`, `late`, `absence`, `visit`, `end_time`, `duration`
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

  return $res;
}

// Добавляем header (?) НЕИСПОЛЬЗУЕТСЯ
/*function setFttSheetById($data) {
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
}*/

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
  $member_key = $db->real_escape_string($member_key);
  $date = $db->real_escape_string($date);
  $delay = $db->real_escape_string($delay);
  $session_name = $db->real_escape_string($session_name);
  $end_time = $db->real_escape_string($end_time);
  $id_attendance = $db->real_escape_string($id_attendance);
  $result = [];
  $count_lates=0;

  $res = db_query("INSERT INTO `ftt_late` (`member_key`, `date`, `delay`, `session_name`, `end_time`, `id_attendance`, `changed`)
  VALUES ('$member_key', '$date', '$delay', '$session_name', '$end_time', '$id_attendance', 1)");

  $res2 = db_query("SELECT fl.id, fl.member_key, fl.date, fl.delay, fl.session_name, fl.end_time, fl.done, fl.author, fl.id_attendance, fl.changed
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
         $attendance_and_late = $result[$i]['id_attendance'].':'.$result[$i]['id'].',';
         $attendance_and_late .= $result[$i+1]['id_attendance'].':'.$result[$i+1]['id'].',';
         $attendance_and_late .= $result[$i+2]['id_attendance'].':'.$result[$i+2]['id'];
        $res4 = db_query("INSERT INTO `ftt_extra_help` (`date`, `member_key`, `reason`, `attendance_and_late`, `changed`) VALUES (NOW(), '$member_key', '$reason_text', '$attendance_and_late', 1)");
      }
    }
  return count($result).' '.$count_lates;
}

function set_extrahelp_automatic($member_key, $date, $reason, $attendance_id, $end_time=0) {
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $date = $db->real_escape_string($date);
  $reason = $db->real_escape_string($reason);
  $attendance_id = $db->real_escape_string($attendance_id);

  $res = db_query("INSERT INTO `ftt_extra_help` (`member_key`, `date`, `reason`, `attendance_and_late`, `changed`)
  VALUES ('$member_key', '$date', '$reason', '$attendance_id', 1)");
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
  if ($session_id) {
    $res = db_query("DELETE FROM `ftt_attendance` WHERE `sheet_id` = '$sheet_id' AND `session_id`='$session_id'");
  } else {
    $res = db_query("DELETE FROM `ftt_attendance` WHERE `sheet_id` = '$sheet_id' AND `session_time`='$session_time'");
  }
}

function add_session_staff($sessions)
{
  global $db;
  $session = json_decode($sessions);
  $sheet_id = $db->real_escape_string(trim($session->id_sheet));
  $session_id = $db->real_escape_string(trim($session->session_id));
  $session_time = $db->real_escape_string(trim($session->session_time));
  if ($session_id) {
    $res = db_query("SELECT `id` FROM ftt_attendance WHERE `sheet_id` = '$sheet_id' AND `session_id` = '$session_id'");
  } else {
    $res = db_query("SELECT `id` FROM ftt_attendance WHERE `sheet_id` = '$sheet_id' AND `session_time` = '$session_time'");
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

function undo_extrahelp_lates($id)
{
  global $db;
  $id = $db->real_escape_string($id);
  $id_search = $id.':';
  $result=[];
  $res = db_query("SELECT `id`, `attendance_and_late` FROM ftt_extra_help WHERE `attendance_and_late` LIKE '%$id_search%'");
  while ($row = $res->fetch_assoc()) $result[$row['id']] = $row['attendance_and_late'];

  foreach ($result as $key => $value) {
    $step_1=explode($value, ',');
    for ($i=0; $i < count($step_1); $i++) {
      $step_2=explode($step_1[$i], ':');
      if ($step_2[0] !== $id) {
        $condition = $step_2[1];
        db_query("UPDATE `ftt_late` SET `done` = 0, `changed` = 1 WHERE `id`='$condition'");
      }
    }
    db_query("DELETE FROM `ftt_extra_help` WHERE `id` = '$key'");
  }

  return $result;
}

// Ночёвка у святых
function db_overnight($member_key, $date)
{
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $date = $db->real_escape_string($date);
  if (!empty($date)) {
    $date = explode('-', $date);
    if (isset($date[1]) && !empty($date)) {
      $date = intval($date[1]);
    }
  }

  $result = '';
  $res = db_query("SELECT fa.reason, fas.date, fas.member_key
    FROM ftt_attendance_sheet AS fas
    LEFT JOIN ftt_attendance fa ON fa.sheet_id = fas.id
    WHERE MONTH(fas.date) = '$date' AND fas.member_key = '$member_key' AND fa.reason = 'П'");
  while ($row = $res->fetch_assoc()) $result = $row['date'];

  return $result;
}

// получаем бланк недельной давности
function getPrevWeekBlank($member_key, $date_blank) {
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $date_blank = $db->real_escape_string($date_blank);
  $prophecy = '';
  $id = '';
  $has_sessions = '';
  $status = '';

  $res = db_query ("SELECT `id`, `prophecy`, `status` FROM `ftt_attendance_sheet` WHERE `member_key`='{$member_key}' AND `date` = '{$date_blank}'");
  while ($row = $res->fetch_assoc()) {
    $prophecy = $row['prophecy'];
    $id = $row['id'];
    $status = $row['status'];
  }

  $res2 = db_query ("SELECT DISTINCT `id` FROM `ftt_attendance` WHERE `sheet_id`='{$id}'");
  while ($row2 = $res2->fetch_assoc()) $has_sessions = $row2['id'];

  if (empty($has_sessions)) {
    return $has_sessions;
  } elseif ($status == 2) {
    return 2;
  } else {
    return $prophecy;
  }

}

// PERMISSIONS
function set_permission($sessions, $adminId)
{
  global $db;
  $sessions = json_decode($sessions);
  $sheet_id = $db->real_escape_string($sessions->sheet->id);
  $member_key = $db->real_escape_string($sessions->sheet->member_key);
  $absence_date = $db->real_escape_string($sessions->sheet->absence_date);
  $date = $db->real_escape_string($sessions->sheet->date);
  $status = $db->real_escape_string($sessions->sheet->status);
  // непонятный баг если передаёт данные из пустого атрибута то свойство как бы отсутствует
  if (isset($sessions->sheet->date_send)) {
    $date_send = $db->real_escape_string(isset($sessions->sheet->date_send));
  } else {
    $date_send = '';
  }

  $comment = $db->real_escape_string($sessions->sheet->comment);
  $serving_one = $db->real_escape_string($sessions->sheet->serving_one);
  $archive_sessions = $db->real_escape_string($sessions->sheet->archive_sessions);
  $comment_extra = $db->real_escape_string($sessions->sheet->comment_extra);
  $is_trainee = $db->real_escape_string($sessions->sheet->trainee);
  $notice = 0;
  $comment_extra_condition = '';
  $comment_extra_field = '';
  $comment_extra_value = '';
  if (!$is_trainee) {
    $comment_extra_condition = " `comment_extra` = '$comment_extra', ";
    $comment_extra_field = "`comment_extra`,";
    $comment_extra_value = "'$comment_extra',";
  }

  if ($status === '2' || $status === '3') {
    $notice = 1;
  }

  $log_serving_one = '';
  $date_decision = '';
  $date_decision_update = '';
  $serving_one ? $log_serving_one = "Ответственный: {$serving_one}": '';
  $operation_name = "создан";
  $sheet_id ? $operation_name = 'обновлён': '';
  $log_text = "Для пользователя {$member_key} {$operation_name} бланк разрешения. {$log_serving_one}";
  $date_send_update = '';
  //write_to_log::debug($adminId, $log_text);
  // condition
  $archive_sessions_field = "`archive_sessions`, ";
  $archive_sessions_value = "'$archive_sessions', ";
  $archive_sessions_update = " `archive_sessions` = '$archive_sessions', ";
  $is_send_blank = false;
  if ($status === '1') {
    $date_send = 'NOW()';
    $date_send_update = ' `date_send`= NOW(), ';
    $date_decision = "''";
    $is_send_blank = true;
  } elseif ($status === '2' || $status === '3') {
    $date_decision_update = ' `decision_date`= NOW(), ';
    $date_decision = 'NOW()';
  } else if ($status === '0' || empty($status)) {
    $date_send = "''";
    $date_decision = "''";
  }

  if (empty($sessions->sheet->id)) {
    db_query("LOCK TABLES ftt_permission_sheet WRITE");
    $res = db_query("INSERT INTO `ftt_permission_sheet` (`member_key`, `absence_date`, `date`, `comment`, `status`, `date_send`, `serving_one`, {$comment_extra_field} `decision_date`, `notice`, `changed`)
    VALUES ('$member_key', '$absence_date', NOW(),'$comment', '$status', $date_send, '$serving_one', {$comment_extra_value} '$date_decision', '$notice', 1)");
    $sheet_id = $db->insert_id;
    db_query("UNLOCK TABLES;");
  } else { //
    $res = db_query("UPDATE `ftt_permission_sheet` SET
      `member_key` = '$member_key', `absence_date` = '$absence_date', {$date_send_update}
      `comment` = '$comment', `status` = '$status', {$date_decision_update} `serving_one` = '$serving_one',
      {$comment_extra_condition} `notice`='$notice', {$archive_sessions_update} `changed` = 1
      WHERE `id` = '$sheet_id'");
    db_query("DELETE FROM `ftt_permission` WHERE `sheet_id` = '$sheet_id'");
  }

  // EMAILING
  if ($is_send_blank) {
    $email_text = short_name::no_middle(Member::get_name($member_key)) . ' создал(а) лист отсутствия на ' . date_convert::yyyymmdd_to_ddmmyyyy($absence_date) . "<br><br>" . "https://reg-page.ru/ftt_attendance.php?pb=" . $sheet_id . '<br><br>Лист отсутствия создан ' . date("d.m.y, H:i");
    emailing::send_by_key(trainee_data::get_serving_one($member_key), 'Лист отсутствия '.short_name::no_middle(Member::get_name($member_key)), $email_text);
  }


  // получаем attendance sheet id для бланков одобренных "Сегодня"
  $today = false;
  $result_attendance_sheet = '';
  $curent_date = date("Y-m-d");
  $past_date = !DatesCompare::isMoreThanCurrent($absence_date);
  if ($absence_date === $curent_date && ($status === '2' || $status === '3')) {
    $today = true;
  }

  if ($today || $past_date) {
    $attendance_sheet = db_query("SELECT `id`
      FROM `ftt_attendance_sheet`
      WHERE `date` = '$absence_date' AND `member_key`='$member_key'");
    while ($row = $attendance_sheet->fetch_assoc()) $result_attendance_sheet = $row['id'];
  }
  foreach ($sessions as $key => $value) {
    if ($key !== 'sheet') {
      if (empty($value->sheet_id)) {
        $sheet_id_sub = $sheet_id;
      } else {
        $sheet_id_sub = $value->sheet_id;
      }
      $session_id = $value->session_id;
      $session_correction_id = $value->session_correction_id;
      $session_name = $value->session_name;
      $session_time = $value->session_time;
      $duration = $value->duration;
      $checked = $value->checked;

      $res2 = db_query("INSERT INTO `ftt_permission` (`sheet_id`, `session_id`, `session_correction_id`, `session_name`, `session_time`, `duration`, `checked`, `changed`)
      VALUES ('$sheet_id_sub', '$session_id', '$session_correction_id', '$session_name', '$session_time', '$duration', '$checked', 1)");

      // Если бланк передан сегодня
      if (($today || $past_date) && $status === '2') {
        // обновляем соответствующие строки attendance задавая в permission_sheet_id    id $sheet_id_sub
        if ($value->checked) {
          $res = db_query("UPDATE `ftt_attendance` SET
            `permission_sheet_id` = '$sheet_id_sub', `reason` = 'Р', `changed` = 1
            WHERE `sheet_id`='$result_attendance_sheet' AND (`session_id` = '$session_id' OR `session_time` = '$session_time')");
        }
      } elseif (($today || $past_date) && $status === '3') {
        // обновляем соответствующие строки attendance удаля из permission_sheet_id    id $sheet_id_sub
        if ($value->checked) {
          $res = db_query("UPDATE `ftt_attendance` SET
            `permission_sheet_id` = '', `reason` = '', `changed` = 1
            WHERE `sheet_id`='$result_attendance_sheet' AND (`session_id` = '$session_id' OR `session_time` = '$session_time')");
        }
      }
    }
  }
  return $res;
}

function get_permission($sheet_id)
{
  global $db;
  $sheet_id = json_decode($sheet_id);
  $result = [];
  $res = db_query("SELECT * FROM `ftt_permission` WHERE `sheet_id` = '$sheet_id'");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

function get_permission_archive($sheet_id)
{
  global $db;
  $sheet_id = $db->real_escape_string($sheet_id);
  $result = "";
  $res = db_query("SELECT `archive_sessions` FROM `ftt_permission_sheet` WHERE `id` = '$sheet_id'");
  while ($row = $res->fetch_assoc()) $result = $row['archive_sessions'];
  return $result;
}

// bible reading //
/*
function get_bible_data($member_key, $date)
{
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $date = $db->real_escape_string($date);
  $result = [];
  $result2 = [];
  $result3 = [];
  $start_date = "";
  $start_today = 0;

  // START
  $res = db_query("SELECT DISTINCT * FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `start` = 1 ORDER BY `date` ASC");
  while ($row = $res->fetch_assoc()) $start_date = $row['date'];
  if ($start_date === $date) {
    $start_today = 1;
  }
  $res = db_query("SELECT DISTINCT * FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '{$date}' AND `start` != 1");
  while ($row = $res->fetch_assoc()) $result = $row;
  // если сегодня поля заполненны
  if ((isset($result['chapter_ot']) && $result['chapter_ot'] > 0) && (isset($result['chapter_nt']) && $result['chapter_nt'] > 0)) {
    $result += ['today_ot' => 1];
    $result += ['today_nt' => 1];
  } else {
    if (isset($result['chapter_ot']) && $result['chapter_ot'] > 0) {
      $result += ['today_ot' => 1];
    } elseif (isset($result['chapter_nt']) && $result['chapter_nt'] > 0) {
      $result += ['today_nt' => 1];
    }
  }

  // Проверяем старт
  if (!isset($result['today_ot']) || (isset($result['chapter_ot']) && $result['chapter_ot'] === 0)) {

    // ВЗ // AND `start` = 1
    $res_ot = db_query("SELECT DISTINCT *
      FROM `ftt_bible`
      WHERE `member_key` = '{$member_key}' AND `chapter_ot` <> 0 AND `date` <= '{$date}' AND `date` >= '{$start_date}'
      ORDER BY `date` ASC, `id` ASC");
    while ($row = $res_ot->fetch_assoc()) $result2 = $row;

    if (isset($result2['book_ot']) && isset($result['book_nt'])) {
      $result['book_ot'] = $result2['book_ot'];
      $result['chapter_ot'] = $result2['chapter_ot'];
    } elseif(isset($result2['book_ot']) && !isset($result['book_nt'])) {
      //$result = $result2;
    }
  }

  if (!isset($result['today_nt']) || (isset($result['chapter_nt']) && $result['chapter_nt'] === 0)) {

    $res_nt = db_query("SELECT DISTINCT *
      FROM `ftt_bible`
      WHERE `member_key` = '$member_key' AND `chapter_nt` <> 0 AND `date` <= '{$date}' AND `date` >= '{$start_date}'
       ORDER BY `date` ASC, `id` ASC");
    while ($row = $res_nt->fetch_assoc()) $result3 = $row;

    if (isset($result3['book_nt']) && isset($result['book_ot'])) {
      $result['book_nt'] = $result3['book_nt'];
      $result['chapter_nt'] = $result3['chapter_nt'];
    } elseif(isset($result3['book_nt']) && !isset($result['book_ot']) && !isset($result2['book_nt'])) {
      $result = $result3;
    }

  }

if (count($result2) > 0 && !isset($result['chapter_ot'])) {
  $result = $result2;
  if (count($result3) > 0) {
    $result['book_nt'] = $result3['book_nt'];
    $result['chapter_nt'] = $result3['chapter_nt'];
  }
}

  if (count($result) === 0) {
    $result = 0;
  } else {
    $result += ['start_today' => $start_today];
  }

  return $result;
}
*/
