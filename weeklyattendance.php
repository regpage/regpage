<?php
//Автоматическое добавление строк для учёта практик (practices) выполняется по заданию (cron)
// строку ниже заменить на config.php
include_once 'db.php';
include_once 'logWriter.php';
include_once 'db/classes/date_convert.php';

function db_checkweeklyAttendance () {
  $result=[];
  $res = db_query("SELECT fas.id, fas.member_key, fas.date, fas.status, fas.date_send, fas.changed, ft.serving_one
    FROM  ftt_attendance_sheet AS fas
    INNER JOIN ftt_trainee ft ON ft.member_key = fas.member_key
    WHERE (fas.date = DATE_FORMAT((NOW() - INTERVAL 7 DAY), '%Y-%m-%d')) AND fas.status=0");
  while ($row = $res->fetch_assoc()) $result[]=$row;

  foreach ($result as $key => $value){
    $id = $value['id'];
    $check = false;
    $res_2 = db_query("SELECT `id` FROM ftt_attendance WHERE `sheet_id`='$id' LIMIT 1");
    while ($row = $res_2->fetch_assoc()) $check=true;

    if ($check) {
      $member_key = $value['member_key'];
      $date_for_msg = date_convert::yyyymmdd_to_ddmm($value['date']);
      $reason = "Не отправлен вовремя лист посещаемости от {$date_for_msg}";
      $serving_one = $value['serving_one'];
      db_query("INSERT INTO ftt_extra_help (`date`, `member_key`, `reason`, `serving_one`, `changed`)
      VALUES (NOW(), '$member_key', '$reason', '$serving_one', 1)");
      echo "{$member_key}, ";
    }
  }



  /*
  // step 1 получаем правила
  $rules = [];
  $res_rules = db_query("SELECT `member_key`, `pause_start`, `pause_stop`
    FROM  ftt_trainee
    WHERE (`pause_start` <= NOW() AND `pause_stop` >= NOW()) OR (`pause_start` <= NOW() AND `pause_stop` IS NULL)");
  while ($row = $res_rules->fetch_assoc()) $rules[$row['member_key']]=[$row['start'], $row['stop']];
  // step 2 получаем изменения в расписании
  $correction = [];
  $res_correction = db_query("SELECT * FROM ftt_session_correction WHERE (`date` > (NOW() - INTERVAL 1 DAY)) AND (`date` < (NOW() + INTERVAL 1 DAY)) AND `attendance` = 1");
  while ($row = $res_correction->fetch_assoc()) $correction[] = $row;
  // step 3
  //получаем расписание
  $schedule_001 = schedule_class::get('all','all');
  //$schedule_002 = schedule_class::get('2','02');

  //logFileWriter(false, 'ПВОМ ПОСЕЩАЕМОСТЬ. Автоматическое добавление строк учёта посещаемости.', 'WARNING');
  $number_day_now = date('N');
  $day_today_now = 'day'.$number_day_now;
  $currentDate = date("Y-m-d");
  $result = array();
  $res=db_query("SELECT `member_key`, `semester`, `time_zone`, `pause_start`, `pause_stop` FROM ftt_trainee");
  while ($row = $res->fetch_assoc()) $result[]=$row;

  $result_2 = array();
  foreach ($result as $key){
    // Можно добавить на все зоны и все семестры сразу а потом отфильтровывать что бы каждый раз не запрашивать, или приготовить расписание для каждой группы
    $mem_id = $key['member_key'];
    $res_2=db_query ("SELECT `member_key` FROM ftt_attendance_sheet WHERE `member_key` = '$mem_id' AND `date` = '$currentDate'");
    while ($rows = $res_2->fetch_assoc()) $result_2[]=$rows['member_key'];
  }

  foreach ($result as $aa){
    if (!in_array($aa['member_key'], $result_2)){
      $id_member = $aa['member_key'];
      $member_semester_range = '1';
      if ($aa['semester'] === '5' || $aa['semester'] === '6') {
        $member_semester_range = '2';
      }

      echo "{$id_member}, ";
      $id_new_string = db_query("INSERT INTO ftt_attendance_sheet (`date`, `member_key`) VALUES (NOW(), '$id_member')");

      $max_id;
      if ($id_new_string) {
        $max_id_tmp = db_query("SELECT MAX(id) AS last_id FROM ftt_attendance_sheet");
        while ($row = $max_id_tmp->fetch_assoc()) $max_id=$row['last_id'];
      }
// Строки предотменённые учитывать
// Выбрать и добавить строки из расписания семестр зона utc и аттенданд = 1 с учётом корректировок
  $correction_stop = false;
  if (!array_key_exists($aa['member_key'], $rules)) {
    $canceled_session = [];
    foreach ($schedule_001 as $keys => $value) {
      // УЧИТЫВАТЬ НОВЫЕ ПОЛЯ session_correction_id!!!
      if ($value['attendance'] === '1' && !empty($value[$day_today_now]) && $aa['time_zone'] === $value['time_zone'] && ($member_semester_range === $value['semester_range'] || $value['semester_range'] === '0')) {
        $session_name = $value['session_name'];
        $time_start = $value[$day_today_now];
        $time_start_tmp = explode('-',$time_start);
        if (isset($time_start_tmp[1])) {
          $time_start = $time_start_tmp[0];
        }
// Исправить корректировку расписания
        if (count($correction) > 0 && !$correction_stop) {
          foreach ($correction as $key_corr => $value_corr) {
            if ($value_corr['date'] === $currentDate && $aa['time_zone'] === $value_corr['time_zone'] && ($member_semester_range === $value_corr['semester_range'] || $value_corr['semester_range'] === '0')) {
              $session_name = $value_corr['session_name'];
              $time_start = $value[$day_today_now];
              db_query("INSERT INTO ftt_attendance (`sheet_id`, `session_name`, `session_time`) VALUES ('$max_id', '$session_name', '$time_start')");
              if ($value_corr['cancel_id']) {
                $canceled_session_tmp = explode(',', $value_corr['cancel_id']);
                if (isset($canceled_session_tmp[0])) {
                  for ($ii=0; $ii < count($canceled_session_tmp); $ii++) {
                    $canceled_session[] = $canceled_session_tmp[$ii];
                  }
                }
              }
            }
          }
          $correction_stop = true;
        }
        $visit_field = $value['visit'];
        $end_time = $value['end_time'];
        $comment_extra = '';
        if ($value['duration'] && $value['duration'] > 0) {
          $session_name = $session_name.", ".$value['duration']."&nbsp;мин.";
        }
        if ($value['visit'] == 1) {
          $session_name = $session_name . ' <i class="fa fa-sticky-note" title="'.$value['comment'].'" data-toggle="tooltip" aria-hidden="true"></i> ';
        }
        if (!in_array($value['id'], $canceled_session)) {
          db_query("INSERT INTO ftt_attendance (`sheet_id`, `session_name`, `session_time`, `visit`, `end_time`) VALUES ('$max_id', '$session_name', '$time_start', '$visit_field', '$end_time')");
        }
      }
    }
  }
      logFileWriter($id_member, 'ПВОМ ПОСЕЩАЕМОСТЬ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Добавлена строка учёта посещаемости для данного пользователя.', 'WARNING');
    }
  }

  */
}

db_checkweeklyAttendance ();
?>
