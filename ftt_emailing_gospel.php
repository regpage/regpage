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
    // доп. задания
    $gospelText = '';
    $gospelTeamReportData = statistics::gospelTeamReport($value);

    if (count($gospelTeamReportData) > 0) {
      $team = $gospelTeamReportData[0]['gospel_team'];
      $res = db_query("SELECT `name` FROM `ftt_gospel_team` WHERE `id`='$team'");
      while ($row = $res->fetch_assoc()) $team = $row['name'];
      $gospelText = "<b>Команда {$team}.</b><br><br>";
      $statistic = [];
      foreach ($gospelTeamReportData as $key_1 => $value_1) {
        if (!isset($statistic[$value_1['gospel_group']])) {
          $statistic[$value_1['gospel_group']] = array($value_1['ftt_gospel'], $value_1['flyers'], $value_1['people'], $value_1['prayers'], $value_1['baptism'], $value_1['meets_last'], $value_1['meets_current'], $value_1['meetings_last'], $value_1['meetings_current'], $value_1['homes']);
        }

        $statistic[$value_1['gospel_group']][0] += $value_1['flyers'];
        $statistic[$value_1['gospel_group']][1] += $value_1['people'];
        $statistic[$value_1['gospel_group']][2] += $value_1['prayers'];
        $statistic[$value_1['gospel_group']][3] += $value_1['baptism'];
        $statistic[$value_1['gospel_group']][4] += $value_1['meets_last'];
        $statistic[$value_1['gospel_group']][5] += $value_1['meets_current'];
        $statistic[$value_1['gospel_group']][6] += $value_1['meetings_last'];
        $statistic[$value_1['gospel_group']][7] += $value_1['meetings_current'];
        $statistic[$value_1['gospel_group']][8] += $value_1['homes'];

        // preparing

      }

      foreach ($statistic as $key_1 => $value_1) {
        $gospelText .= '<span>Группа </span>';
         $gospelText .= '<span>'.$key_1 . ' Лист. — ' . $value_1[0] . ', Людей — ' . $value_1[1] . ', Мол. — ' . '</span>';
         $gospelText .= $value_1[2] . ', Крес. — ' .$value_1[3] . ', Встр. — ' . $value_1[4] . ', Всрт. Тек. — ';
         $gospelText .= $value_1[5] . ', Собр. — ' . $value_1[6] . ', Собр. Тек. — ' . $value_1[7] . ', Дом.  — ' . $value_1[8] . '</span><br>';
      }

      if (false) {
        $gospelText .= "<span>" . short_name::no_middle(Member::get_name($value_1['member_key'])) . " — " . $value_1['number'] . ', '. $value_1['first_contacts']. ', '. $value_1['further_contacts'] . "</span><br>";
      }
      $gospelText .= '<br><br>';
    }

    $gospelTextData = statistics::gospelPersonalSeven($traine_list);
    if (count($gospelTextData) > 0) {
      $gospelText .= '<b>Выходы на благовестие и звонки</b><br><br>Обучающиеся — выходов, новых контактов, повторных.<br>';
      foreach ($gospelTextData as $key_1 => $value_1) {
        if ($value_1['member_key']) {
          $gospelText .= "<span>" . short_name::no_middle(Member::get_name($value_1['member_key'])) . " — " . $value_1['number'] . ', '. $value_1['first_contacts']. ', '. $value_1['further_contacts'] . "</span><br>";
        }
      }
      //$gospelText .= "<a href='https://reg-page.ru/ftt_extrahelp.php?my=1'>Перейти в раздел «Доп. задания»</a><br>";
    }
    //Emailing::send_by_key
    //Emailing::send
    //a.rudanok@gmail.com
    //info@new-constellation.ru
    if ($gospelText) {
      Emailing::send('info@new-constellation.ru', $topic, $gospelText);
    } else {
      // add str to log file
    }
  }
  $count = count($gospelTeamReportData);
  echo "success<br>";
  return 1;
}

getServiceOnesWithTrainees ();

?>
