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
//require_once 'db/classes/short_name.php';
require_once 'db/classes/date_convert.php';
require_once 'db/classes/statistic/gospel_stat.php';

function getServiceOnesWithTrainees ()
{
  global $db;
  $result = [];
  $success = '';
  // служащие с обучающимися.
  $res = db_query("SELECT `member_key` FROM `ftt_serving_one`");
  while ($row = $res->fetch_assoc()) $result[] = $row['member_key'];
  foreach ($result as $key => $value) {
    $value = $db->real_escape_string($value);
    // команды служащего
    $sOteam = '';
    $sOteamPreparing = db_query("SELECT `gospel_team` FROM `ftt_serving_one` WHERE `member_key` = '$value'");
    while ($row = $sOteamPreparing->fetch_assoc()) $sOteam = $row['gospel_team'];
    $team = '';
    $sOteamPreparing = db_query("SELECT `name` FROM `ftt_gospel_team` WHERE `id` = '$sOteam'");
    while ($row = $sOteamPreparing->fetch_assoc()) $team = $row['name'];
    // группы служащего
    $sOGroups = [];
    $groupPreparing = db_query("SELECT DISTINCT `gospel_group` FROM `ftt_trainee` WHERE `gospel_team` = '$sOteam' ORDER BY `gospel_group`");
    while ($row = $groupPreparing->fetch_assoc()) $sOGroups[$row['gospel_group']] = $row['gospel_group'];
    // обучающиеся служащего
    $sOTrainees = [];
    $sOTraineesPreparing = db_query("SELECT `member_key`, `gospel_group` FROM `ftt_trainee` WHERE `gospel_team` = '$sOteam'");
    while ($row = $sOTraineesPreparing->fetch_assoc()) $sOTrainees[$row['member_key']] = $row['gospel_group'];
    // тема
    $topic = 'Статистика благовестия на '.date("d.m", mktime(0, 0, 0, date("m"), date("d")-1));
    // НУЛЕВЫЕ (по которым нет отчёта в выбраном периоде) ГРУППЫ И ОБУЧАЮЩИХСЯ
    // тело письма
    $gospelText = '';
    $gospelTeamReportData = statistics::gospelTeamReport($value);

    // ГРУППЫ Найти по ключу и если нет добавить
    if (count($gospelTeamReportData) > 0 || !empty($sOteam)) {
      $gospelText = 'Статистика благовестия за неделю с ' . date("d.m", mktime(0, 0, 0, date("m"), date("d")-7)) . ' по ' . date("d.m", mktime(0, 0, 0, date("m"), date("d")-1)) .' (со среды по вторник):<br><br>';
      if (count($gospelTeamReportData) == 0) {
        foreach ($sOGroups as $key_all_group => $value_all_group) {
          $gospelTeamReportData[] = array('gospel_group' => $value_all_group, 'flyers' => 0, 'people' => 0, 'prayers' => 0, 'baptism' => 0, 'meets_last' => 0, 'meets_current' => 0, 'meetings_last' => 0, 'meetings_current' => 0, 'homes' => 0);
        }
      }

      $res = db_query("SELECT `name` FROM `ftt_gospel_team` WHERE `id`='$team'");
      while ($row = $res->fetch_assoc()) $team = $row['name'];
      $gospelText .= "<b>Команда {$team}</b><br>";
      $statistic = [];
      foreach ($gospelTeamReportData as $key_1 => $value_1) {
        if (!isset($statistic[$value_1['gospel_group']])) {
          $statistic[$value_1['gospel_group']] = array($value_1['flyers'], $value_1['people'], $value_1['prayers'], $value_1['baptism'], $value_1['meets_last'], $value_1['meets_current'], $value_1['meetings_last'], $value_1['meetings_current'], $value_1['homes']);
        } else {
          $statistic[$value_1['gospel_group']][0] += $value_1['flyers'];
          $statistic[$value_1['gospel_group']][1] += $value_1['people'];
          $statistic[$value_1['gospel_group']][2] += $value_1['prayers'];
          $statistic[$value_1['gospel_group']][3] += $value_1['baptism'];
          $statistic[$value_1['gospel_group']][4] += $value_1['meets_last'];
          $statistic[$value_1['gospel_group']][5] += $value_1['meets_current'];
          $statistic[$value_1['gospel_group']][6] += $value_1['meetings_last'];
          $statistic[$value_1['gospel_group']][7] += $value_1['meetings_current'];
          $statistic[$value_1['gospel_group']][8] += $value_1['homes'];
        }
      }

      $group_missing = array_diff_key($sOGroups,$statistic);

      if (count($group_missing) > 0) {
        foreach ($group_missing as $key_1 => $value_1) {
          $statistic[$key_1] = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        }
        ksort($statistic);
      }

      foreach ($statistic as $key_1 => $value_1) {
        $colorRedGrp = '';
        if (!$value_1[0] && !$value_1[1] && !$value_1[2] && !$value_1[3] && !$value_1[4] && !$value_1[5] && !$value_1[6] && !$value_1[7] && !$value_1[8]) {
          $colorRedGrp = 'style="color: red;"';
        }
        $gospelText .= "<span {$colorRedGrp}>Группа ";
         $gospelText .= $key_1 . ': Л' . $value_1[0] . ', Б' . $value_1[1] . ', М' . $value_1[2];
         $gospelText .= ', К' .$value_1[3] . ', В' . (intval($value_1[4]) + intval($value_1[5]));
         $gospelText .= ', С' . (intval($value_1[6]) + intval($value_1[7])) . ', Д' . $value_1[8] . '</span><br>';
      }

      $gospelText .= '<br>';
    }
    $trainee_list_team = GospelStatistic::traineesByTeamName($sOteam);
    $gospelTextData = statistics::gospelPersonalSeven($trainee_list_team);
    if (count($gospelTextData) > 0 || count($sOTrainees) > 0) {
      if (empty($gospelText)) {
        $gospelText = 'Статистика благовестия за неделю с ' . date("d.m", mktime(0, 0, 0, date("m"), date("d")-7)) . ' по ' . date("d.m", mktime(0, 0, 0, date("m"), date("d")-1)) . ' (со среды по вторник):<br><br>';
      }
      $trainePrepare = [];
      foreach ($gospelTextData as $key_1 => $value_1) {
        $trainePrepare[$value_1['member_key']] = $value_1['member_key'];
      }

      $trainees_missing = array_diff_key($sOTrainees, $trainePrepare);

      if (count($trainees_missing) > 0) {
        foreach ($trainees_missing as $key_1 => $value_1) {
          $gospelTextData[] = array('member_key' => $key_1, 'number' => 0, 'first_contacts' => 0, 'further_contacts' => 0, 'name' => Member::get_name($key_1));
        }
        // Сортируем
        $nameSort  = array_column($gospelTextData, 'name');
        array_multisort($nameSort, SORT_ASC, $gospelTextData);
      }
      $statisticPersonal = [];
      $gospelText .= '<b>Выходы на благовестие и звонки</b><br>';
      foreach ($gospelTextData as $key_1 => $value_1) {
        if ($value_1['member_key']) {
          if (!isset($statisticPersonal[$value_1['member_key']])) {
            $statisticPersonal[$value_1['member_key']] = array($value_1['number'], $value_1['first_contacts'], $value_1['further_contacts']);
          } else {
            $statisticPersonal[$value_1['member_key']][0] += $value_1['number'];
            $statisticPersonal[$value_1['member_key']][1] += $value_1['first_contacts'];
            $statisticPersonal[$value_1['member_key']][2] += $value_1['further_contacts'];

          }
        }
      }
      foreach ($statisticPersonal as $key_1 => $value_1) {
        $colorRed = '';
        if (!$value_1[0] && !$value_1[1] && !$value_1[2]) {
          $colorRed = 'style="color: red;"';
        }
        $gospelText .= "<span {$colorRed}>" . short_name::no_middle(Member::get_name($key_1)) . " (группа " . $sOTrainees[$key_1] . "): В" . $value_1[0] . ', Н'. $value_1[1]. ', П'. $value_1[2];
        $gospelText .= "</span><br>";
      }
      //$gospelText .= "<a href='https://reg-page.ru/ftt_extrahelp.php?my=1'>Перейти в раздел «Доп. задания»</a><br>";
    }
    //Emailing::send_by_key
    //Emailing::send
    //a.rudanok@gmail.com
    //info@new-constellation.ru
    //Emailing::send_by_key($value, $topic, $gospelText);
    //Emailing::send('info@new-constellation.ru', $topic, $gospelText);

    if ($gospelText) {
      $success .= "$value - статистика благовестия - success<br>";
      //Emailing::send('info@new-constellation.ru', $topic, $gospelText);
      Emailing::send_by_key($value, $topic, $gospelText);
    } else {
      $success .= "$value - статистика благовестия - failure<br>";
    }
  }

  echo $success;
  return 1;
}

getServiceOnesWithTrainees ();

?>
