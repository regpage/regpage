<?php
// Ежедневная рассылка статистики для служащих.

header('Content-Type: text/html; charset=utf-8');
session_start ();

// config
require_once 'config.php';

// logs
include_once 'extensions/write_to_log/write_to_log.php';

// classes
require_once 'db/classes/statistics.php';
require_once 'db/classes/emailing.php';
require_once 'db/classes/ftt_lists.php';
require_once 'db/classes/member.php';
require_once 'db/classes/short_name.php';
require_once 'db/classes/date_convert.php';

function getServiceOnesWithTrainees ()
{
  $result = [];
  $res = db_query("SELECT DISTINCT `serving_one` FROM ftt_trainee");
  while ($row = $res->fetch_assoc()) $result[] = $row['serving_one'];
  print_r($result);
  foreach ($result as $key => $value) {
    echo $value."<br>";
    $traine_list = ftt_lists::get_trainees_by_staff($value);
    // тема
    $topic = 'Статистика на '.date('d.m.y');

    // тело письма
    // объявления
    $announcements = '';
    $announcements_data = statistics::announcement_unread_data($value);
    if (count($announcements_data) > 0) {
      $announcements = '<b>Непрочитанные объявления:</b><br>';
      foreach ($announcements_data as $key_1 => $value_1) {
        $announcements .= "<a href='https://reg-page.ru/ftt_announcement.php?id={$value_1['id_announcement']}'>{$value_1['header']}</a><br>";
      }
    }

    // листы отсутствия
    $absence = '';
    $absence_data = statistics::permissions_data($traine_list);
    if (count($absence_data) > 0) {
      if (empty($announcements)) {
        $absence = '<b>Листы отсутствия:</b><br>';
      } else {
        $absence = '<br><b>Листы отсутствия:</b><br>';
      }
      foreach ($absence_data as $key_2 => $value_2) {
        $absence .= "<a href='https://reg-page.ru/ftt_attendance.php?pb={$value_2['id']}'>".short_name::no_middle(Member::get_name($value_2['member_key'])) . " " . date_convert::yyyymmdd_to_ddmmyyyy($value_2['absence_date'])."</a><br>";
      }
    }

    // листы посещаемости
    $attendance = '';
    $attendance_data = statistics::attendanceFour($traine_list);

    if (count($attendance_data) > 0) {
      if (empty($announcements) && empty($absence)) {
        $attendance .= '<b>Нет листов посещаемости за четыре дня:</b><br>';
      } else {
        $attendance .= '<br><b>Нет листов посещаемости за четыре дня:</b><br>';
      }
      foreach ($attendance_data as $key_3 => $value_3) {
        $attendance .= "<a href='https://reg-page.ru/ftt_attendance.php?id={$value_3['id']}'>".short_name::no_middle(Member::get_name($value_3['member_key'])) . " " . date_convert::yyyymmdd_to_ddmmyyyy($value_3['date'])."</a><br>";
      }

    }

    // доп. задания
    $extraHelp = '';
    $extraHelpData = statistics::extra_help_data($traine_list);
    if (count($extraHelpData) > 0) {
      if (empty($announcements) && empty($absence) && empty($attendance)) {
        $extraHelp = '<b>Дополнительные задания:</b><br>';
      } else {
        $extraHelp = '<br><b>Дополнительные задания:</b><br>';
      }
      foreach ($extraHelpData as $key_4 => $value_4) {
        $extraHelp .= "<a href='https://reg-page.ru/ftt_extrahelp.php?id={$value_4['id']}'>".short_name::no_middle(Member::get_name($value_4['member_key'])) . " " . date_convert::yyyymmdd_to_ddmmyyyy($value_4['date'])."</a><br>";
      }
    }

    //Emailing::send_by_key()
    //A.rudanok@gmail.com
    if ($announcements || $absence || $attendance || $extraHelp) {
      Emailing::send('info@new-constellation.ru', $topic, $announcements . $absence . $attendance . $extraHelp);
    } else {
      // add str to log file
    }
  }

  return 1;
}
getServiceOnesWithTrainees ();
//global $db;
//$member_key = $db->real_escape_string($member_key);

?>
