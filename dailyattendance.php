<?php
//Автоматическое добавление строк для учёта практик (practices) выполняется по заданию (cron)
// строку ниже заменить на config.php
// Вывод ошибок на экран
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include_once 'config.php';
//include_once 'logWriter.php'; не включать!
include_once 'db/classes/schedule_class.php';
include_once 'db/classes/date_convert.php';
include_once 'db/classes/ftt_info.php';
include_once 'db/classes/ftt_permissions.php';
include_once 'db/classes/ftt_reading/bible.php';

function db_newDailyAttendance () {
  global $db;
  // Проверяем даты семестра
  // Проверяем что расписание не выходит за период обучения
  if (ftt_info::pause()) {
    echo "Вне периода проведения обучения";
    exit();
  }

  // получаем разрешения на сегодня (permissions)
  $todayDate = date("Y-m-d");
  $permissions = FttPermissions::get_by_date($todayDate);
  $bibleBooks = new Bible;


  // получаем правила
  $rules = [];
  $res_rules = db_query("SELECT `member_key`, `pause_start`, `pause_stop`
    FROM  ftt_trainee
    WHERE (`pause_start` <= NOW() AND `pause_stop` >= NOW()) OR (`pause_start` <= NOW() AND `pause_stop` IS NULL)");
  while ($row = $res_rules->fetch_assoc()) $rules[$row['member_key']]=[$row['start'], $row['stop']];

  // получаем изменения в расписании
  $correction = [];
  $res_correction = db_query("SELECT * FROM ftt_session_correction WHERE (`date` > (NOW() - INTERVAL 1 DAY)) AND (`date` < (NOW() + INTERVAL 1 DAY))"); // AND `attendance` = 1
  while ($row = $res_correction->fetch_assoc()) $correction[] = $row;

  //получаем расписание
  $schedule_001 = schedule_class::get('all','all');
  //$schedule_002 = schedule_class::get('2','02');

  // формируем расписание на сегодня
  //logFileWriter(false, 'ПВОМ ПОСЕЩАЕМОСТЬ. Автоматическое добавление строк учёта посещаемости.', 'WARNING');
  $number_day_now = date('N');
  $day_today_now = 'day'.$number_day_now;
  $currentDate = date("Y-m-d");
  $result = array();
  $res=db_query("SELECT `member_key`, `semester`, `time_zone`, `pause_start`, `pause_stop` FROM ftt_trainee");
  while ($row = $res->fetch_assoc()) $result[]=$row;

  // проверяем, возможно бланки на сегодня для кого то уже созданы
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
      $max_id = '';

      // **__** ADD NEW SHEET
      // добавляем новый лист посещаемости
      $id_new_string_block = db_query("LOCK TABLES ftt_attendance_sheet WRITE");
      $id_new_string = db_query("INSERT INTO ftt_attendance_sheet (`date`, `member_key`) VALUES (NOW(), '$id_member')");
      // лучшие варианты получения ID
      if ($id_new_string) {
        $max_id = $db->insert_id;
        // ИЛИ
        // mysqli_insert_id($db);
        /*if ($id_new_string) {
          $max_id_tmp = db_query("SELECT MAX(id) AS last_id FROM ftt_attendance_sheet");
          while ($row = $max_id_tmp->fetch_assoc()) $max_id=$row['last_id'];
        }*/
      }
      $id_new_string_block = db_query("UNLOCK TABLES;");      

      // **__** PERMISSIONS
      // Проверяем наличие разрешений для пользователя (permissions)
      $has_permissions = false;
      $permissions_val = [];
      if (count($permissions) > 0) {
        if (!empty($permissions[$aa['member_key']])) {
          $has_permissions = true;
          $permissions_val = $permissions[$aa['member_key']]['sessions'];
        }
      }

  // Выбрать и добавить строки из расписания семестр зона utc и аттенданд = 1 с учётом корректировок
  if (!array_key_exists($aa['member_key'], $rules)) {
    foreach ($schedule_001 as $keys => $value) {

      $reason ='';
      $permission_sheet_id = '';
      // Проставляем Р в строки с разрешением (permissions)
      if (count($permissions) > 0 && $has_permissions) {
        for ($iii=0; $iii < count($permissions_val); $iii++) {
          // ЕСЛИ КОЛ-ВО МЕРОПРИЯТИЙ РАВНО КОЛВО РАЗРЕШЕНИЙ в бланке то можно ставить статус 1!
          if ($permissions_val[$iii]['session_id'] === $value['id']) {
            $reason = 'Р';
            $permission_sheet_id = $permissions_val[$iii]['sheet_id'];
          }
        }
      }
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
              $class_corr = $value_corr['class'];

              // разрешения для корректируемых строк
              $reason ='';
              $permission_sheet_id ='';
              if (count($permissions) > 0 && $has_permissions) {
                for ($iiii=0; $iiii < count($permissions_val); $iiii++) {
                  // ЕСЛИ КОЛ-ВО МЕРОПРИЯТИЙ РАВНО КОЛВО РАЗРЕШЕНИЙ в бланке то можно ставить статус 1!
                  if ($permissions_val[$iiii]['session_correction_id'] === $time_start_corr) {
                    $reason = 'Р';
                    $permission_sheet_id = $permissions_val[$iii]['sheet_id'];
                  }
                }
              }

              // ДОБАВИТЬ permisson проверку по времени в корректировках и записывать "Р"
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
                  db_query("INSERT INTO ftt_attendance (`sheet_id`, `session_name`, `session_time`, `reason`, `permission_sheet_id`, `visit`, `duration`, `end_time`, `class`)
                  VALUES ('$max_id', '$session_name_corr', '$time_start_corr', '$reason', '$permission_sheet_id', '$visit_corr', '$duration_corr', '$end_time_corr', '$class_corr')");
                }
             }
          }
          $correction_stop = 1;
        }

        $visit_field = $value['visit'];
        $end_time = $value['end_time'];
        $comment_extra = '';
        $duration = $value['duration'];
        $session_id = $value['id'];
        $class = $value['class'];
        if ($value['duration'] && $value['duration'] > 0) {
          $session_name = $session_name.", ".$value['duration']."&nbsp;мин.";
        }
        if ($value['visit'] == 1 && $value['comment']) {
          $session_name = $session_name . ' <i class="fa fa-sticky-note" title="'.$value['comment'].'" data-toggle="tooltip" aria-hidden="true"></i> ';
        }
        if (!in_array($value['id'], $canceled_session)) {
          db_query("INSERT INTO ftt_attendance
            (`session_id`,`sheet_id`, `session_name`, `session_time`, `reason`, `permission_sheet_id`, `visit`, `duration`, `end_time`, `class`)
            VALUES ('$session_id','$max_id', '$session_name', '$time_start', '$reason', '$permission_sheet_id', '$visit_field', '$duration', '$end_time', '$class')");
        }
      }
    }
  }
  //logFileWriter($id_member, 'ПВОМ ПОСЕЩАЕМОСТЬ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Добавлена строка учёта посещаемости для данного пользователя.', 'WARNING');
    }
  }
}

db_newDailyAttendance ();
?>
