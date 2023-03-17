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
  global $db;

  $result = [];
  $res = db_query("SELECT DISTINCT `serving_one` FROM ftt_trainee");
  while ($row = $res->fetch_assoc()) $result[] = $row['serving_one'];
  print_r($result);
  foreach ($result as $key => $value) {
    $value = $db->real_escape_string($value);
    echo $value."<br>";
    $traine_list = ftt_lists::get_trainees_by_staff($value);
    // тема
    $topic = 'Статистика благовестия на '.date('d.m');

    // тело письма
    // объявления
    /*$announcements = '';
    $announcements_data = statistics::announcement_unread_data($value);
    if (count($announcements_data) > 0) {
      $announcements = '<b>Непрочитанные объявления:</b><br>';
      foreach ($announcements_data as $key_1 => $value_1) {
        $announcements .= '<span>' . $value_1['header'] . '</span><br>';
      }
      $announcements .= "<a href='https://reg-page.ru/ftt_announcement.php'>Перейти в раздел  «Объявления».</a><br>";
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
        $absence .= "<a href='https://reg-page.ru/ftt_attendance.php?pb={$value_2['id']}'>".short_name::no_middle(Member::get_name($value_2['member_key'])) . "  — на " . date_convert::yyyymmdd_to_ddmm($value_2['absence_date'])."</a><br>";
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
        $attendance .= "<span>" . short_name::no_middle(Member::get_name($key_3)) . " — с " . date_convert::yyyymmdd_to_ddmm($value_3) . "</span><br>";
      }
      $attendance .= "<a href='https://reg-page.ru/ftt_attendance.php?my=1'>Перейти в раздел «Посещаемость»</a><br>";
    }
*/
    // доп. задания
    $gospelText = '';
    $gospelTextData = statistics::gospelPersonalSeven($traine_list);
    if (count($extraHelpData) > 0) {
      if (empty($announcements) && empty($absence) && empty($attendance)) {
        $extraHelp = '<b>Обучающиеся — выходов, новых контактов, повторных.</b><br>';
      } else {
        $extraHelp = '<br><b>Обучающиеся — выходов, новых контактов, повторных.</b><br>';
      }
      foreach ($gospelTextData as $key_1 => $value_1) {
        if ($value_1) {
          $gospel_text .= "<span>" . short_name::no_middle(Member::get_name($value_1['member_key'])) . " — " . $value_1['number'] . ', '. $value_1['first_contacts']. ', '. $value_1['further_contacts'] . "</span><br>";
        }
      }
      //$gospel_text .= "<a href='https://reg-page.ru/ftt_extrahelp.php?my=1'>Перейти в раздел «Доп. задания»</a><br>";
    }

    //Emailing::send_by_key
    //Emailing::send
    //a.rudanok@gmail.com
    //info@new-constellation.ru
    if ($gospel_text) {
      Emailing::send('info@new-constellation.ru', $topic, $gospelText);
    } else {
      // add str to log file
    }
  }
  echo "success";
  return 1;
}

getServiceOnesWithTrainees ();

?>
