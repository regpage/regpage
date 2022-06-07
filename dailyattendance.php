<?php
//Автоматическое добавление строк для учёта практик (practices) выполняется по заданию (cron)
// строку ниже заменить на config.php
include_once 'db.php';
include_once 'logWriter.php';
include_once 'db/classes/schedule_class.php';

function db_newDailyAttendance () {
  //  Проверяем даты семестра
  $ftt_attendance_start = getValueFttParamByName('attendance_start');
  $ftt_attendance_end = getValueFttParamByName('attendance_end');
  $ftt_attendance_start = strtotime($ftt_attendance_start);
  $ftt_attendance_end = strtotime($ftt_attendance_end);

  // Проверяем что расписание не выходит за период обучения
  if ($date_today < $ftt_attendance_start && $date_today > $ftt_attendance_end) {
    exit();
  }

  // step 1 получаем правила
  $rules = [];
  $res_rules = db_query("SELECT `member_key`, `pause_start`, `pause_stop`
    FROM  ftt_trainee
    WHERE (`pause_start` <= NOW() AND `pause_stop` >= NOW()) OR (`pause_start` <= NOW() AND `pause_stop` IS NULL)");
  while ($row = $res_rules->fetch_assoc()) $rules[$row['member_key']]=[$row['start'], $row['stop']];
  // step 2 получаем изменения в расписании
  $correction = [];
  $res_correction = db_query("SELECT * FROM ftt_session_correction WHERE (`date` > (NOW() - INTERVAL 1 DAY)) AND (`date` < (NOW() + INTERVAL 1 DAY))"); // AND `attendance` = 1
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
    $correction_stop = false;
    $canceled_session = [];
    if (!in_array($aa['member_key'], $result_2)){
      $id_member = $aa['member_key'];
      $member_semester_range = '1';
      if ($aa['semester'] === '5' || $aa['semester'] === '6') {
        $member_semester_range = '2';
      }
      echo "{$id_member}, ";
      $id_new_string = db_query("INSERT INTO ftt_attendance_sheet (`date`, `member_key`) VALUES (NOW(), '$id_member')");
      // лучшие варианты получения ID
      // $db->insert_id;
      // ИЛИ
      // mysqli_insert_id($db);
      $max_id;
      if ($id_new_string) {
        $max_id_tmp = db_query("SELECT MAX(id) AS last_id FROM ftt_attendance_sheet");
        while ($row = $max_id_tmp->fetch_assoc()) $max_id=$row['last_id'];
      }
// Строки предотменённые учитывать
// Выбрать и добавить строки из расписания семестр зона utc и аттенданд = 1 с учётом корректировок

  if (!array_key_exists($aa['member_key'], $rules)) {
    foreach ($schedule_001 as $keys => $value) {
      // УЧИТЫВАТЬ НОВЫЕ ПОЛЯ session_correction_id!!!
      if ($value['attendance'] === '1' && !empty($value[$day_today_now]) && $aa['time_zone'] === $value['time_zone'] && ($member_semester_range === $value['semester_range'] || $value['semester_range'] === '0')) {
        $session_name = $value['session_name'];
        $time_start = $value[$day_today_now];
        $time_start_tmp = explode('-',$time_start);
        if (isset($time_start_tmp[1])) {
          $time_start = $time_start_tmp[0];
        }

        if (count($correction) > 0 && !$correction_stop) {
          foreach ($correction as $key_corr => $value_corr) {
            if ($value_corr['date'] === $currentDate && $aa['time_zone'] === $value_corr['time_zone'] && ($member_semester_range === $value_corr['semester_range'] || $value_corr['semester_range'] === '0')) {
              $session_name_corr = $value_corr['session_name'];
              $time_start_corr = $value_corr['time'];
              $visit_corr = $value_corr['visit'];
              $end_time_corr = $value_corr['end_time'];
              $duration_corr = $value_corr['duration'];
              if ($value_corr['cancel_id']) {
                $canceled_session_tmp = explode(',', $value_corr['cancel_id']);
                //if (isset($canceled_session_tmp[0])) {
                  for ($ii=0; $ii < count($canceled_session_tmp); $ii++) {
                    $canceled_session[] = trim($canceled_session_tmp[$ii]);
                    if ($ii === 0) {
                      //$one_corretion = $value_corr;
                      //$one_corretion['cancel_id'] = trim($canceled_session_tmp[$ii]);
                      //$canceled_session[] = $one_corretion;
                    } else {
                      //$one_corretion = $value_corr;
                      //$one_corretion['cancel_id'] = trim($canceled_session_tmp[$ii]);
                      //$one_corretion['time'] = '';
                    }
                  }
                //}
              }
              if ($value_corr['attendance'] === '1') {
                db_query("INSERT INTO ftt_attendance (`sheet_id`, `session_name`, `session_time`, `visit`, `duration`, `end_time`) VALUES ('$max_id', '$session_name_corr', '$time_start_corr', '$visit_corr', '$duration_corr', '$end_time_corr')");
              }
            }
          }
          $correction_stop = 1;
        }
        $visit_field = $value['visit'];
        $end_time = $value['end_time'];
        $comment_extra = '';
        $duration = $value['duration'];
        if ($value['duration'] && $value['duration'] > 0) {
          $session_name = $session_name.", ".$value['duration']."&nbsp;мин.";
        }
        if ($value['visit'] == 1 && $value['comment']) {
          $session_name = $session_name . ' <i class="fa fa-sticky-note" title="'.$value['comment'].'" data-toggle="tooltip" aria-hidden="true"></i> ';
        }
        if (!in_array($value['id'], $canceled_session)) {
          db_query("INSERT INTO ftt_attendance (`sheet_id`, `session_name`, `session_time`, `visit`, `duration`, `end_time`) VALUES ('$max_id', '$session_name', '$time_start', '$visit_field', '$duration', '$end_time')");
        }
      }
    }
  }
      logFileWriter($id_member, 'ПВОМ ПОСЕЩАЕМОСТЬ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Добавлена строка учёта посещаемости для данного пользователя.', 'WARNING');
    }
  }
}

db_newDailyAttendance ();
?>
