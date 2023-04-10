<?php
// СТАТИСТИКА БЛАГОВЕСТИЯ
function gospelStatFun($team, $teamsList, $html=true)
{
  $membersBlanksStatistic = GospelStatistic::membersBlanksStatistic();
  // список обучающиеся в команде
  $traineesList = GospelStatistic::traineesByTeam($team);
  // группы команды
  $groupsList = getGospelGroups($team);
  $groupsList_temp = [];
  foreach ($groupsList as $key_2 => $value_2) {
    $groupsList_temp[] = $value_2['gospel_group'];
  }

  // html
  $date_day = date('w');
  $remainder = $date_day - 2;
  $gospelTeamReportData = [];
  $date_current_report = date_create(date('Y-m-d'));

  // дней с начала семестра.
  $date1 = date('Y-m-d');
  $date2 = date_convert::ddmmyyyy_to_yyyymmdd(getValueFttParamByName('attendance_start'));
  $reportLength = DatesCompare::diff(date('Y-m-d'), date_convert::ddmmyyyy_to_yyyymmdd(getValueFttParamByName('attendance_start')));

  if ($remainder > 0) {
    // подготавлеваем даты периода
    $key_date = getDatePeriodText($remainder);
    // получаем данные по команде за период
    $gospelTeamReportData[$key_date] = GospelStatistic::teamReport($team, date('Y-m-d'), $remainder);
    // добавляем недостающие группы группу
    $tempCheck = addMissingGroups($groupsList_temp, $gospelTeamReportData[$key_date]);

    if (count($tempCheck) > 0) {
      for ($ii=0; $ii < count($tempCheck); $ii++) {
        $gospelTeamReportData[$key_date][] = array('id'=>0,'date'=>'−−.−−','gospel_team'=>$team, 'gospel_group'=>$tempCheck[$ii],'place'=>0, 'group_members'=>0,'number'=>0,'ftt_gospel'=>0, 'flyers'=>0,'people'=>0,'prayers'=>0,'baptism'=>0,'meets_last'=>0,'meets_current'=>0,'meetings_last'=>0, 'meetings_current'=>0,'first_contacts'=>0,'further_contacts'=>0,'homes'=>0,'comment'=>0);
      }
    }

    // Сортируем
    $nameSort  = array_column($gospelTeamReportData[$key_date], 'gospel_group');
    array_multisort($nameSort, SORT_ASC, $gospelTeamReportData[$key_date]);
    // задаём дату для следующей итерации
    date_sub($date_current_report,date_interval_create_from_date_string("{$remainder} days"));
  } elseif ($remainder < 0) {
    $remainder = 7 + $remainder;
    // подготавлеваем даты периода
    $key_date = getDatePeriodText($remainder);
    // получаем данные по команде за период
    $gospelTeamReportData[$key_date] = GospelStatistic::teamReport($team, date('Y-m-d'), $remainder);
    // добавляем недостающие группы группу
    $tempCheck = addMissingGroups($groupsList_temp, $gospelTeamReportData[$key_date]);

    if (count($tempCheck) > 0) {
      for ($ii=0; $ii < count($tempCheck); $ii++) {
        $gospelTeamReportData[$key_date][] = array(
          'id'=>0,'date'=>'−−.−−','gospel_team'=>$team, 'gospel_group'=>$tempCheck[$ii],'place'=>0, 'group_members'=>0,'number'=>0,'ftt_gospel'=>0,'flyers'=>0,'people'=>0,'prayers'=>0,
          'baptism'=>0,'meets_last'=>0,'meets_current'=>0,'meetings_last'=>0, 'meetings_current'=>0,'first_contacts'=>0,'further_contacts'=>0,'homes'=>0,'comment'=>0);
      }
    }

    // Сортируем
    $nameSort  = array_column($gospelTeamReportData[$key_date], 'gospel_group');
    array_multisort($nameSort, SORT_ASC, $gospelTeamReportData[$key_date]);
    // задаём дату для следующей итерации
    date_sub($date_current_report,date_interval_create_from_date_string("{$remainder} days"));
  }

  for ($i=0; $i < $reportLength; $i=$i+7) {
    // подготавлеваем даты периода
    $datePeriodWeek = date_create(date_format($date_current_report,"Y-m-d"));
    date_modify($datePeriodWeek,"-7 days");
    //date_sub($datePeriodWeek,date_interval_create_from_date_string("7 days"));
    $key_date = date_format($datePeriodWeek,"Y-m-d") . ' — ' . date_format($date_current_report,"Y-m-d");
    // получаем данные по команде за период
    $gospelTeamReportData[$key_date] = GospelStatistic::teamReport($team, date_format($date_current_report,"Y-m-d"));
    // добавляем недостающие группы группу
    $tempCheck = addMissingGroups($groupsList_temp, $gospelTeamReportData[$key_date]);
    if (count($tempCheck) > 0) {
      for ($ii=0; $ii < count($tempCheck); $ii++) {
        $gospelTeamReportData[$key_date][] = array(
          'id'=>0,'date'=>'−−.−−','gospel_team'=>$team, 'gospel_group'=>$tempCheck[$ii],'place'=>0, 'group_members'=>0,'number'=>0,'ftt_gospel'=>0,'flyers'=>0,'people'=>0,'prayers'=>0,
          'baptism'=>0,'meets_last'=>0,'meets_current'=>0,'meetings_last'=>0,'meetings_current'=>0,
          'first_contacts'=>0,'further_contacts'=>0,'homes'=>0,'comment'=>0);
      }
    }
    // Сортируем
    $nameSort  = array_column($gospelTeamReportData[$key_date], 'gospel_group');
    array_multisort($nameSort, SORT_ASC, $gospelTeamReportData[$key_date]);

    // задаём дату для следующей итерации
    date_sub($date_current_report,date_interval_create_from_date_string("7 days"));
  }
  if ($html) {
    gospelStatGroupsHtml($membersBlanksStatistic, $teamsList, $gospelTeamReportData, $team);
  } else {
    $diagramsReportData = [];
    foreach ($gospelTeamReportData as $key => $value) {
      foreach ($value as $key_1 => $value_1) {

        $value_1['key_date'] = $key;
        if (isset($value_1['gospel_group'])) { // && isset($diagramsReportData[$value_1['gospel_group']])
          $diagramsReportData[$value['gospel_group']][] = $value_1;
        } elseif(isset($value_1['gospel_group'])) {
          $diagramsReportData[$value['gospel_group']] = [];
          $diagramsReportData[$value['gospel_group']][] = $value_1;
        }
      }
    }

    foreach ($diagramsReportData as $key_3 => $value_3) {
      $nameSort = array_column($diagramsReportData[$key_3], 'gospel_group');
      array_multisort($nameSort, SORT_ASC, $diagramsReportData[$key_3]);
    }
    
    gospelStatСolumn(array(), $teamsList, $diagramsReportData, $team);
  }
}

function gospelStatGroupsHtml($membersBlanksStatistic, $teamsList, $gospelTeamReportData)
{
    $countForGTRDLoop = 0;
    foreach ($gospelTeamReportData as $key => $value) {
      $block = 0;

      if ($countForGTRDLoop == 0) {
        echo "<div><h5>{$teamsList[$team]}</h5>";
        $count = count($gospelTeamReportData);
      }
      if (empty($value) && $countForGTRDLoop == 0) {
        $keyTemp = periodDateConvert($key);
        echo "<b>НЕДЕЛЯ {$count} {$keyTemp}</b><br>";
      } elseif(empty($value)) {
        $keyTemp = periodDateConvert($key);
        echo "<b style='display: inline-block; padding-top: 10px;'>НЕДЕЛЯ {$count} {$keyTemp}</b><br>";
      }
      foreach ($value as $key_1 => $value_1) {
        if (!$block) {
          if ($countForGTRDLoop != 0) {
            $keyTemp = periodDateConvert($key);
            echo "<b style='display: inline-block; padding-top: 10px;'>НЕДЕЛЯ {$count} {$keyTemp}</b><br>";
          } else {
            $keyTemp = periodDateConvert($key);
            echo "<b>НЕДЕЛЯ {$count} {$keyTemp}</b><br>";
          }
        }

        $value_1['meets_last'] += $value_1['meets_current'];
        $value_1['meetings_last'] += $value_1['meetings_current'];
        $dateEcho = '−−.−−';
        $colorRed = '';
        if ($value_1['date'] !== '−−.−−') {
          $dateEcho = date_convert::yyyymmdd_to_ddmm($value_1['date']);
        } else {
          $colorRed = 'color: red;';
        }
        $numberGospels = 0;
        $firstConact = 0;
        $furtherConact = 0;
        if (isset($membersBlanksStatistic[$value_1['id']])) {
          $numberGospels = $membersBlanksStatistic[$value_1['id']]['number'];
          $firstConact = $membersBlanksStatistic[$value_1['id']]['first_contacts'];
          $furtherConact = $membersBlanksStatistic[$value_1['id']]['further_contacts'];

        }

        echo "<span style='{$colorRed}'><b>Группа {$value_1['gospel_group']}</b><br>";
        echo $dateEcho . ' — Л'.$value_1['flyers'].', Б'.$value_1['people'] .', М'. $value_1['prayers'];
        echo ', Г' . $numberGospels .', Н' . $firstConact .', П' . $furtherConact;
        echo ', К' . $value_1['baptism'] .', В'. $value_1['meets_last'] .', С'. $value_1['meetings_last'] .', Д'. $value_1['homes'];
        echo '.</span><br>';

        $block = 1;
      }
      $count--;
      $countForGTRDLoop++;
    }
    if (count($gospelTeamReportData) > 0) {
      echo "<hr></div>";
    }
}

// ГРАФИК СТОЛБИКИ СТАТИСТИКА БЛАГОВЕСТИЯ
function gospelStatСolumn($membersBlanksStatistic, $teamsList, $gospelTeamReportData, $team)
{
  $countForGTRDLoop = 0;
  foreach ($gospelTeamReportData as $key => $value) {
    $block = 0;

    if ($countForGTRDLoop == 0) {
      echo "<h5>{$teamsList[$team]}</h5>";
      echo "<div class='d-flex'>";
      $count = count($gospelTeamReportData);
    }
    if (empty($value) && $countForGTRDLoop == 0) {
      $keyTemp = periodDateConvert($key);
      echo "<b>НЕДЕЛЯ {$count} {$keyTemp}</b><br>";
    } elseif(empty($value)) {
      $keyTemp = periodDateConvert($key);
      echo "<b style='display: inline-block; padding-top: 10px;'>НЕДЕЛЯ {$count} {$keyTemp}</b><br>";
    }

    foreach ($value as $key_1 => $value_1) {
      if (!$value_1['gospel_group']) {
        continue;
      }
      if (!$block) {
        if ($countForGTRDLoop != 0) {
          $keyTemp = periodDateConvert($key);
          echo "<b style='display: inline-block; padding-top: 10px;'>НЕДЕЛЯ {$count} {$keyTemp}</b><br>";
        } else {
          $keyTemp = periodDateConvert($key);
          echo "<b>НЕДЕЛЯ {$count} {$keyTemp}</b><br>";
        }
      }

      $value_1['meets_last'] += $value_1['meets_current'];
      $value_1['meetings_last'] += $value_1['meetings_current'];
      $dateEcho = '−−.−−';
      $colorRed = '';
      if ($value_1['date'] !== '−−.−−') {
        $dateEcho = date_convert::yyyymmdd_to_ddmm($value_1['date']);
      } else {
        $colorRed = 'color: red;';
      }

      echo "<span style='{$colorRed}'><b>Группа {$value_1['gospel_group']}</b></span><br>";
      $statColumn = ['М'=>$value_1['prayers'], 'Л'=>$value_1['flyers'], 'Б'=>$value_1['people']];
      $plot = new SimplePlot($statColumn, 150); //Создать диаграмму
      $plot->show(); //И показать её

      $block = 1;
    }

    $count--;
    $countForGTRDLoop++;
  }
  if (count($gospelTeamReportData) > 0) {
    echo "</div>";
  }
}

function addMissingGroups($arr1, $arr2)
{
  $temp = [];
  $tempCheck = [];
  foreach ($arr2 as $key => $value) {
    $temp[$value['gospel_group']] = $value['gospel_group'];
  }
  $tempCheck = array_diff($arr1, $temp);

  return $tempCheck;
}

function addMissingTrainees($arr1, $arr2)
{
  $temp = [];

  foreach ($arr2 as $key => $value) {
    $temp[$value['member_key']] = $value['name'];
  }

  return array_diff($arr1, $temp);
}

function periodDateConvert($period)
{
  global $db;
  $period = $db->real_escape_string($period);

  $keyTemp = explode(' — ', $period);
  $keyTemp = date_convert::yyyymmdd_to_ddmm($keyTemp[0]) . ' — ' . date_convert::yyyymmdd_to_ddmm($keyTemp[1]);

  return $keyTemp;
}

function getDatePeriodText($remainder=7)
{
  global $db;
  $remainder = $db->real_escape_string($remainder);

  $datePeriodWeek = date_create(date('Y-m-d'));
  date_sub($datePeriodWeek,date_interval_create_from_date_string("{$remainder} days"));
  return date_format($datePeriodWeek,"Y-m-d") . ' — ' . date('Y-m-d');
}

function addTraineeAndSort(&$arr, $keyArr, $check)
{
  if (count($check) > 0) {
    // добавляем
    foreach ($check as $key => $value) {
      $arr[$keyArr][] = array(
        'id'=>0,'date'=>'−−.−−', 'member_key'=>$key,
        'name'=>$value,'first_contacts'=>0,'further_contacts'=>0,'number'=>0);
    }
    // Сортируем
    array_multisort(array_column($arr[$keyArr], 'name'), SORT_ASC, $arr[$keyArr]);
  }
}

function gospelStatFunPersonal($team,$teamName)
{
  echo "<div><h5>{$teamName[$team]}</h5></div>";
  // обучающиеся

  // periods
  $date_day = date('w');
  $remainder = $date_day - 2;
  $gospelTeamReportData = [];
  $date_current_report = date_create(date('Y-m-d'));

  // дней с начала семестра.
  $date1 = date('Y-m-d');
  $date2 = date_convert::ddmmyyyy_to_yyyymmdd(getValueFttParamByName('attendance_start'));
  $reportLength = DatesCompare::diff(date('Y-m-d'), date_convert::ddmmyyyy_to_yyyymmdd(getValueFttParamByName('attendance_start')));

  // обучающиеся служащего
  $trainee_list_team = GospelStatistic::traineesByTeamWithName($team);

  // ЗДЕСЬ НУЖНО ДОБАВИТЬ ПЕРИОДЫ В ВЫЧИТАНИЕМ Х ДНЕЙ, А НИЖЕ 7 ДНЕЙ
  if ($remainder > 0) {
    // подготавливаем даты периода
    $key_date = getDatePeriodText($remainder);
    // получаем данные по команде за период
    $gospelTextData[$key_date] = statistics::gospelPersonalSeven($trainee_list_team,  $remainder);
    // добавляем недостающихся обучающихся и сортируем
    addTraineeAndSort($gospelTextData, $key_date, addMissingTrainees($trainee_list_team, $gospelTextData[$key_date]));
    // задаём дату для следующей итерации
    date_sub($date_current_report,date_interval_create_from_date_string("{$remainder} days"));
  } elseif ($remainder < 0) {
    $remainder = 7 + $remainder;
    // подготавлеваем даты периода
    $key_date = getDatePeriodText($remainder);
    // получаем данные по команде за период
    $gospelTextData[$key_date] = statistics::gospelPersonalSeven($team, $remainder);
    // добавляем недостающихся обучающихся и сортируем
    addTraineeAndSort($gospelTextData, $key_date, addMissingTrainees($trainee_list_team, $gospelTextData[$key_date]));
    // задаём дату для следующей итерации
    date_sub($date_current_report,date_interval_create_from_date_string("{$remainder} days"));
  }

  // ЗДЕСЬ С ВЫЧИТАНИЕМ 7 ДНЕЙ
  for ($i=0; $i < $reportLength; $i=$i+7) {

    // подготавлеваем даты периода
    $datePeriodWeek = date_create(date_format($date_current_report,"Y-m-d"));
    date_modify($datePeriodWeek,"-7 days");

    //date_sub($datePeriodWeek,date_interval_create_from_date_string("7 days"));
    $key_date = date_format($datePeriodWeek,"Y-m-d") . ' — ' . date_format($date_current_report,"Y-m-d");

    // получаем данные по команде за период
    $gospelTextData[$key_date] = GospelStatistic::personalReport($trainee_list_team, 7,  date_format($date_current_report,"Y-m-d"));

    // добавляем недостающихся обучающихся и сортируем
    addTraineeAndSort($gospelTextData, $key_date, addMissingTrainees($trainee_list_team, $gospelTextData[$key_date]));

    // задаём дату для следующей итерации
    date_sub($date_current_report,date_interval_create_from_date_string("7 days"));
  }

  if (count($gospelTextData) > 0 || count($trainee_list_team) > 0) {

    $statisticPersonal = [];
    // обучающиеся data
    foreach ($gospelTextData as $key_2 => $value_2) {
      foreach ($value_2 as $key_3 => $value_3) {
        if (!isset($value_3[$key_2])) {
            $value_3[$key_2] = [];
        }
        if (!isset($statisticPersonal[$key_2][$value_3['member_key']])) {
          $statisticPersonal[$key_2][$value_3['member_key']] = array($value_3['number'], $value_3['first_contacts'], $value_3['further_contacts']);
        } else {
          $statisticPersonal[$key_2][$value_3['member_key']][0] += $value_3['number'];
          $statisticPersonal[$key_2][$value_3['member_key']][1] += $value_3['first_contacts'];
          $statisticPersonal[$key_2][$value_3['member_key']][2] += $value_3['further_contacts'];
        }
      }
    }

    // обучающиеся html
    $counterPeriods = 0;
    foreach ($statisticPersonal as $key_2 => $value_2) {
      if ($counterPeriods > 0) {
        $gospelText .= '<br>';
      }
      $gospelText .= "<b>Период {$key_2}</b><br>";
      foreach ($value_2 as $key_3 => $value_3) {
        $colorRed = '';
        if (!$value_3[0] && !$value_3[1] && !$value_3[2]) {
          $colorRed = 'color: red;';
        }
        $gospelText .= "<span style='{$colorRed}'>" . short_name::no_middle($trainee_list_team[$key_3]) . ": В" . $value_3[0] . ', Н'. $value_3[1]. ', П'. $value_3[2];
        $gospelText .= "</span><br>";
      }
      $counterPeriods++;
    }
    $gospelText .= '<hr>';
  }
  echo $gospelText;
}
