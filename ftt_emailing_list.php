<?php
// Ежедневная рассылка статистики для служащих.

header('Content-Type: text/html; charset=utf-8');
session_start ();

// config
require_once 'config.php';
require_once 'db/classes/ftt_info.php';

if (ftt_info::pause()) {
  // отметка о выполнении
  $faleName = $_SERVER['PHP_SELF'];
  db_query("INSERT INTO `cron` (`date`,`script`, `status`, `comment`) VALUES (CURRENT_DATE(),'{$faleName}', '1', 'Вне периода')");
  echo "Вне периода проведения обучения";
  exit();
}
// logs
include_once 'extensions/write_to_log/write_to_log.php';

// classes
include_once 'db/classes/DatesCompare.php';
require_once 'db/classes/statistics.php';
require_once 'db/classes/emailing.php';
require_once 'db/classes/ftt_lists.php';
require_once 'db/classes/member.php';
require_once 'db/classes/short_name.php';
require_once 'db/classes/date_convert.php';
require_once 'db/classes/date_plus.php';
include_once 'db/classes/ftt_attendance/fellowship.php';
include_once 'db/classes/ftt_attendance/prophecy.php';

function getServiceOnesWithTrainees ()
{
  //global $db;
  //$member_key = $db->real_escape_string($member_key);
  $result = [];
  $res = db_query("SELECT DISTINCT `serving_one` FROM ftt_trainee");
  while ($row = $res->fetch_assoc()) $result[] = $row['serving_one'];
  //print_r($result);
  foreach ($result as $key => $value) {
    if (empty($value)) {
      $name_miss = '';
      $res = db_query("SELECT m.name
        FROM ftt_trainee AS ft
        LEFT JOIN member m ON m.key = ft.member_key
        WHERE ft.serving_one = ''
        ORDER BY m.name");
        while ($row = $res->fetch_assoc()) $name_miss .= $row['name']."<br>";
        // 000005716
      Emailing::send_by_key('000002634', 'Уведомление с сайта ПВОМ', "Некоторым обучающимся на сайте регистрации в разделе ПВОМ не назначен ответственный.<br>{$name_miss}");
      continue;
    }
    //echo $value."<br>";
    $traine_list = ftt_lists::get_trainees_by_staff($value);
    // тема
    $topic = 'Сводные данные на '.date('d.m');

    // тело письма
    // объявления
    $announcements = '';
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
        if ($value_4) {
          $extraHelp .= "<span>" . short_name::no_middle(Member::get_name($key_4)) . " — " . $value_4 . "</span><br>";
        }
      }
      $extraHelp .= "<a href='https://reg-page.ru/ftt_extrahelp.php?my=1'>Перейти в раздел «Доп. задания»</a><br>";
    }

    // пропущенные занятия
    $missingClass = '';
    $missingClassData = statistics::missed_class_count_name($traine_list);
    if (count($extraHelpData) > 0) {
      if (empty($announcements) && empty($absence) && empty($attendance) && empty($extraHelp)) {
        $missingClass = '<b>Пропущенные занятия:</b><br>';
      } else {
        $missingClass = '<br><b>Пропущенные занятия:</b><br>';
      }
      foreach ($missingClassData as $key_5 => $value_5) {
        if ($value_5) {
          $missingClass .= "<span>" . short_name::no_middle(Member::get_name($key_5)) . " — " . $value_5 . "</span><br>";
        }
      }
      $missingClass .= "<a href='https://reg-page.ru/ftt_attendance.php?mc'>Перейти в раздел «Пропущенные занятия»</a><br>";
    }

    // общения на сегодня
    $fellowship_today = Fellowship::now_serving_one($value);
    $fellowship_text = '';
    $fellowship_text_name = '';
    if (count($fellowship_today) > 0) {
      if (empty($announcements) && empty($absence) && empty($attendance) && empty($extraHelp) && empty($missingClass)) {
        $fellowship_text = '<b>Общение сегодня: </b>';
      } else {
        $fellowship_text = '<br><b>Общение сегодня: </b>';
      }

      foreach ($fellowship_today as $key_5 => $value_5) {
        if ($value_5) {
          $name_f = short_name::no_middle($value_5['name']);
          if (empty($fellowship_text_name)) {
            $fellowship_text_name .= $name_f;
          } else {
            $fellowship_text_name .= ', ' . $name_f;
          }
        }
      }
      if (count($fellowship_today) > 0) {
        $fellowship_text .= "<span> {$fellowship_text_name} </span><br>";
      }
    }

    $fellowship_cancel_today = Fellowship::canceled_serving_one($value);
    $fellowship_cancel_text_name = '';
    if (count($fellowship_cancel_today) > 0) {
      if (empty($announcements) && empty($absence) && empty($attendance) && empty($extraHelp) && empty($missingClass) && empty($fellowship_text)) {
        $fellowship_text = '<b>Отменено общение сегодня:</b>';
      } else {
        $fellowship_text .= '<br><b>Отменено общение сегодня:</b>';
      }
      foreach ($fellowship_cancel_today as $key_6 => $value_6) {
        $name_c = short_name::no_middle($value_6['name']);
        if (empty($fellowship_cancel_text_name)) {
          $fellowship_cancel_text_name .= $name_c;
        } else {
          $fellowship_cancel_text_name .= ', ' . $name_c;
        }
      }
      if (count($fellowship_cancel_today) > 0) {
        $fellowship_text .= "<span> {$fellowship_cancel_text_name} </span><br>";
      }
    }

    if (!empty($fellowship_text)) {
      $fellowship_text .= "<a href='https://reg-page.ru/ftt_fellowship.php'>Перейти в раздел «Общение»</a><br>";
    }

    // ==== Пророчествование отчёт
    $prophecy_text = '';
    if (date('w') != 0) {
      if (empty($announcements) && empty($absence) && empty($attendance) && empty($extraHelp) && empty($missingClass) && empty($fellowship_text) && empty($fellowship_cancel_text_name)) {
        $prophecy_text = '<b>Пророчествование в прошедшее воскресенье:<br></b>';
      } else {
        $prophecy_text = '<br><b>Пророчествование в прошедшее воскресенье:<br></b>';
      }

      $lTMeeting_date = date_plus::sub_d(date('Y-m-d'), date('w'));
      $prophecy_data = Prophecy::by_serving_one($traine_list, $lTMeeting_date);
      $lTMeeting_date_format = date_convert::yyyymmdd_to_ddmm($lTMeeting_date);
      foreach ($prophecy_data as $keyProph => $valueProph) {
        $prophecy_text .= "{$valueProph['name']} — ";
        if ($valueProph['status'] === "0" || $valueProph['status'] === "2") {
          $prophecy_text .= $lTMeeting_date_format . " лист не отправлен <br>";
        } elseif ($valueProph['prophecy'] === "0") {
          $prophecy_text .= $lTMeeting_date_format . " пророчествовал(а)<br>";
        } elseif ($valueProph['prophecy'] === "1") {
          $prophecy_text .= $lTMeeting_date_format . " не пророчествовал(а)<br>";
        } else {
          $prophecy_text .= $lTMeeting_date_format . " данные отсутствуют тк установлен перерыв или собрание трапезы не было указано в расписании<br>";
        }
      }
      $prophecy_text .= "<a href='https://reg-page.ru/ftt_attendance.php'>Перейти в раздел «Листы посещаемости»</a><br>";
    }

    /***  ОТПРАВКА ПИСЬМА  **/
    //Emailing::send_by_key()
    //Emailing::send
    //a.rudanok@gmail.com
    //info@zhichkinroman.ru '000005716'
    //
    if ($announcements || $absence || $attendance || $extraHelp || $missingClass || $fellowship_text || $prophecy_text) {
      $body = $announcements . $absence . $attendance . $extraHelp . $missingClass . $fellowship_text . $prophecy_text;
      if (!empty($value)) {
        Emailing::send_by_key($value, $topic, $body);
        //Emailing::send_by_key('000005716', $topic, $body);
      } else {
        echo "Не получен емайл служащего, возможно не указан служащий для какого то обучающегося \r\n";
      }
    } else {
      // add str to log file
    }
  }
  // отметка о выполнении
  $faleName = $_SERVER['PHP_SELF'];
  db_query("INSERT INTO `cron` (`date`,`script`, `status`, `comment`) VALUES (CURRENT_DATE(),'{$faleName}', '1', '')");
  echo "success";
  return 1;
}

getServiceOnesWithTrainees ();
