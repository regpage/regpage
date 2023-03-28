<?php

function getGospelTeam() {
  $result = [];
  $res = db_query("SELECT * FROM `ftt_gospel_team` ORDER BY `name`");
  while ($row = $res->fetch_assoc()) $result[$row['id']] = $row['name'];
  return $result;
}

// get gospel reports
function getGospel($condition, $memberId, $sorting, $from = "", $to = "", $team = '_all_') {

  global $db;
  $condition = $db->real_escape_string($condition);
  $memberId = $db->real_escape_string($memberId);
  $sorting = $db->real_escape_string($sorting);
  $from = $db->real_escape_string($from);
  $to = $db->real_escape_string($to);
  $team = $db->real_escape_string($team);

  $order_by = '';
  if ($condition === 'month') {
    $condition = 'DATE(fg.date) >= (NOW() - INTERVAL 1 MONTH)';
  } elseif ($condition === 'range') {
    $condition = " fg.date >= '{$from}' AND fg.date <= '{$to}' ";
  } else {
    $condition = '1';
  }

  if ($team && $team !== '_all_') {
    if ($condition === '1') {
      $condition = "fg.gospel_team=" . "'$team'";
    } else {
      $condition = "fg.gospel_team=" . "'$team'" . ' AND ' . $condition;
    }
  }

  if ($sorting === 'sort__team-desc') {
    $order_by = 'place_name DESC, fg.gospel_group';
  } elseif ($sorting === 'sort__team-asc') {
    $order_by = 'place_name ASC, fg.gospel_group';
  } elseif (!empty($sorting)) {
    $sorting = explode('__', $sorting);
    if (count($sorting)>1) {
      $sorting = explode('-', $sorting[1]);
      $order_by = "fg.{$sorting[0]} {$sorting[1]}";
    } else {
      $order_by = 'fg.date DESC';
    }
  } else {
    $order_by = 'fg.date DESC';
  }  

  $result = [];
  $res = db_query("SELECT fg.id, fg.date, fg.gospel_team, fg.gospel_group, fg.place, fg.group_members, fg.flyers,
     fg.people, fg.prayers, fg.baptism, fg.meets_last, fg.meets_current, fg.meetings_last, fg.meetings_current,
     fg.homes, fg.author, fg.comment, fg.changed,
     fgt.name AS place_name, fgt.place AS fgt_place,
     m.name AS m_name, m.male
    FROM ftt_gospel AS fg
    INNER JOIN ftt_gospel_team fgt ON fgt.id = fg.gospel_team
    INNER JOIN member m ON m.key = fg.author
    WHERE {$condition}
    ORDER BY {$order_by}");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

// get gospel goals
function getGospelGoals(){
  $result = [];
  $res = db_query("SELECT fgg.gospel_team, fgg.gospel_group, fgg.group_members, fgg.flyers, fgg.people,
    fgg.prayers, fgg.baptism, fgg.fruit
    FROM ftt_gospel_goals AS fgg
    ORDER BY fgg.gospel_team");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

// get gospel groups
function getGospelGroups($team){
  global $db;
  $team = $db->real_escape_string($team);
  $result = [];
  $res = db_query("SELECT DISTINCT `gospel_group` FROM ftt_trainee WHERE `gospel_team`='$team' ORDER BY `gospel_group`");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

// get group gospel goals
function get_group_gospel_goals($team, $group) {
  global $db;
  $team = $db->real_escape_string($team);
  $group = $db->real_escape_string($group);
  $result = [];
  if ($group !== '_none_') {
    $res = db_query("SELECT fgg.gospel_team, fgg.gospel_group, fgg.group_members, fgg.flyers, fgg.people,
      fgg.prayers, fgg.baptism, fgg.fruit
      FROM ftt_gospel_goals AS fgg
      WHERE fgg.gospel_team = '$team' AND fgg.gospel_group = '$group'
      ORDER BY fgg.gospel_team");
    while ($row = $res->fetch_assoc()) $result = $row;
  } else {
    $res = db_query("SELECT fgg.gospel_team, fgg.gospel_group, fgg.group_members, fgg.flyers, fgg.people,
      fgg.prayers, fgg.baptism, fgg.fruit
      FROM ftt_gospel_goals AS fgg
      WHERE fgg.gospel_team = '$team'
      ORDER BY fgg.gospel_team");
    while ($row = $res->fetch_assoc()) $result[] = $row;
  }

  return $result;
}

// set gospel goals
function set_ftt_gospel_goals($team, $group, $column, $value){
  global $db;
  $team = $db->real_escape_string($team);
  $group = $db->real_escape_string($group);
  $column = $db->real_escape_string($column);
  $value = $db->real_escape_string($value);
  $result = [];
  $res=db_query("SELECT * FROM `ftt_gospel_goals` WHERE `gospel_team`='$team' AND `gospel_group`='$group'");
  while ($row = $res->fetch_assoc()) $result[] = $row;

  if (count($result) > 0) {
    $res2=db_query("UPDATE `ftt_gospel_goals` SET `$column`='$value' WHERE `gospel_team`='$team' AND `gospel_group`='$group'");
  } else {
    $members = '';
    $res3=db_query("SELECT * FROM `ftt_trainee` WHERE `gospel_team`='$team' AND `gospel_group`='$group'");
    while ($row = $res3->fetch_assoc()){
      if ($members) {
        $members .= ','.$row['member_key'];
      } else {
        $members .= $row['member_key'];
      }
    }
    $res2=db_query("INSERT INTO `ftt_gospel_goals` (`$column`, `gospel_team`, `gospel_group`, `group_members`) VALUES ('$value', '$team', '$group', '$members')");
  }

  return $res2;
}

// save blank
function addDataBlank($data){
  global $db;
  $result;
  $result2;

  $gospel_team = $db->real_escape_string($data['fio_field']);
  $date = $db->real_escape_string($data['date_field']);
  //$number = $db->real_escape_string($data['number_field']);
  $flyers = $db->real_escape_string($data['flyers_field']);
  $people = $db->real_escape_string($data['people_field']);
  $prayers = $db->real_escape_string($data['prayers_field']);
  $baptism = $db->real_escape_string($data['baptism_field']);
  $meets_last = $db->real_escape_string($data['meets_last_field']);
  $meets_current = $db->real_escape_string($data['meets_current_field']);
  $meetings_last = $db->real_escape_string($data['meetings_last_field']);
  $meetings_current = $db->real_escape_string($data['meetings_current_field']);
  $gospel_group = $db->real_escape_string($data['gospel_group_field']);
  //$place = $db->real_escape_string($data['place_field']);
  $group_members = $db->real_escape_string($data['group_members_field']);
  $homes = $db->real_escape_string($data['homes_field']);
  //$place_name = $db->real_escape_string($data['place_name_field']);
  //$fgt_place = $db->real_escape_string($data['fgt_place']);
  $author = $db->real_escape_string($data['author']);
  $comment = $db->real_escape_string($data['comment_field']);
//`place`, '$place',
  $res = db_query("INSERT INTO `ftt_gospel`(`date`, `gospel_team`, `gospel_group`, `group_members`,
    `flyers`, `people`, `prayers`, `baptism`, `meets_last`, `meets_current`, `meetings_last`, `meetings_current`, `homes`, `author`, `comment`, `changed`)
  VALUES ('$date','$gospel_team','$gospel_group','$group_members','$flyers','$people', '$prayers', '$baptism',
     '$meets_last', '$meets_current', '$meetings_last', '$meetings_current',
     '$homes', '$author', '$comment', 1)");
  if ($res) {
    $res2 = db_query("SELECT MAX(`id`) AS last_id FROM `ftt_gospel` LIMIT 1");
    while ($row = $res2->fetch_assoc()) $result = $row['last_id'];

    // personal block
    $group_members_data = json_decode($data['personal_blocks']);

    if (!empty($group_members) && count((array)$group_members_data)) {
      foreach ($group_members_data as $key => $value) {
        $first_contacts_resonal = $db->real_escape_string($value->first_contacts);
        $further_contacts_resonal = $db->real_escape_string($value->further_contacts);
        $number = $db->real_escape_string($value->number);
        db_query("INSERT INTO `ftt_gospel_members` (`blank_id`, `member_key`, `number`, `first_contacts`, `further_contacts`, `date`)
        VALUES ('$result','$key', '$number', '$first_contacts_resonal', '$further_contacts_resonal', NOW())");
      }
    }


    $res3 = db_query("SELECT fg.id, fg.date, fg.gospel_team, fg.gospel_group, fg.place, fg.group_members, fg.flyers,
       fg.people, fg.prayers, fg.baptism, fg.meets_last, fg.meets_current, fg.meetings_last, fg.meetings_current,
       fg.homes, fg.author, fg.comment, fg.changed,
       fgt.name AS place_name, fgt.place AS fgt_place,
       m.name AS m_name, m.male
      FROM ftt_gospel AS fg
      INNER JOIN ftt_gospel_team fgt ON fgt.id = fg.gospel_team
      INNER JOIN member m ON m.key = fg.author
      WHERE fg.id = '$result'");
    while ($row = $res3->fetch_assoc()) $result2 = $row;

    return $result2;
  } else {
    return $res;
  }
}
// update blank
function updateDataBlank($data){
  global $db;

  $gospel_team = $db->real_escape_string($data['fio_field']);
  $id = $db->real_escape_string($data['id']);
  $date = $db->real_escape_string($data['date_field']);
  $gospel_group = $db->real_escape_string($data['gospel_group_field']);
  //$place = $db->real_escape_string($data['place_field']);
  $group_members = $db->real_escape_string($data['group_members_field']);
  //$number = $db->real_escape_string($data['number_field']);
  $flyers = $db->real_escape_string($data['flyers_field']);
  $people = $db->real_escape_string($data['people_field']);
  $prayers = $db->real_escape_string($data['prayers_field']);
  $baptism = $db->real_escape_string($data['baptism_field']);
  $meets_last = $db->real_escape_string($data['meets_last_field']);
  $meets_current = $db->real_escape_string($data['meets_current_field']);
  $meetings_last = $db->real_escape_string($data['meetings_last_field']);
  $meetings_current = $db->real_escape_string($data['meetings_current_field']);
  $homes = $db->real_escape_string($data['homes_field']);
  //$place_name = $db->real_escape_string($data['place_name_field']);
  //$fgt_place = $db->real_escape_string($data['fgt_place']);
  $author = $db->real_escape_string($data['author']);
  $comment = $db->real_escape_string($data['comment_field']);
//`place`='$place',
  $res = db_query("UPDATE `ftt_gospel` SET `date`='$date',`gospel_team`='$gospel_team',`gospel_group`='$gospel_group',`group_members`='$group_members',
    `flyers`='$flyers',`people`='$people',`prayers`='$prayers',`baptism`='$baptism',`meets_last`='$meets_last',
    `meets_current`='$meets_current', `meetings_last`='$meetings_last',`meetings_current`='$meetings_current',
    `homes`='$homes',`author`='$author',`comment`='$comment',`changed`= 1
    WHERE `id`='$id'");

  // personal block
  $group_members_data = json_decode($data['personal_blocks']);

  if (!empty($group_members) && count((array)$group_members_data)) {
    $group_members_arr = explode(',', $group_members);
    $condition_dlt = '';
    for ($i=0; $i < count($group_members_arr); $i++) {
      if (!empty($condition_dlt)) {
        $condition_dlt .= " AND `member_key` <> '".$group_members_arr[$i]."' ";
      } else {
        $condition_dlt .= " `member_key` <> '".$group_members_arr[$i]."' ";
      }
    }
    db_query("DELETE FROM `ftt_gospel_members` WHERE `blank_id`='$id' AND $condition_dlt ");
    foreach ($group_members_data as $key => $value) {
      $first_contacts_resonal = $db->real_escape_string($value->first_contacts);
      $further_contacts_resonal = $db->real_escape_string($value->further_contacts);
      $number = $db->real_escape_string($value->number);
      $result_check = '';
      $res_check = db_query("SELECT DISTINCT `id` FROM `ftt_gospel_members` WHERE `blank_id`='$id' AND `member_key`='$key'");
      while ($row = $res_check->fetch_assoc()) $result_check = $row['id'];

      if ($result_check) {
        db_query("UPDATE `ftt_gospel_members` SET `number`='$number', `first_contacts`='$first_contacts_resonal', `further_contacts`='$further_contacts_resonal', `date`= NOW()
        WHERE `blank_id`='$id' AND `member_key`='$key'");
      } else {
        db_query("INSERT INTO `ftt_gospel_members` (`blank_id`, `member_key`, `number`, `first_contacts`, `further_contacts`, `date`)
        VALUES ('$id', '$key', '$number', '$first_contacts_resonal', '$further_contacts_resonal', NOW())");
      }
    }
  } else {
    db_query("DELETE FROM `ftt_gospel_members` WHERE `blank_id`='$id'");
  }

  $result;
  if ($res) {
    $res2 = db_query("SELECT fg.id, fg.date, fg.gospel_team, fg.gospel_group, fg.place, fg.group_members, fg.flyers,
       fg.people, fg.prayers, fg.baptism, fg.meets_last, fg.meets_current, fg.meetings_last, fg.meetings_current,
       fg.homes, fg.author, fg.comment, fg.changed,
       fgt.name AS place_name, fgt.place AS fgt_place,
       m.name AS m_name, m.male
      FROM ftt_gospel AS fg
      INNER JOIN ftt_gospel_team fgt ON fgt.id = fg.gospel_team
      INNER JOIN member m ON m.key = fg.author
      WHERE fg.id='$id'");
    while ($row = $res2->fetch_assoc()) $result = $row;

    return $result;
  } else {
    return $res;
  }
}

// Бланк в архив
/*
function setBlankToArchive($id, $archive, $adminId) {
  global $db;
  $id = $db->real_escape_string($id);
  $archive = $db->real_escape_string($archive);
  $adminId = $db->real_escape_string($adminId);
  if ($archive == 1) {
    $res = db_query("UPDATE `ftt_gospel` SET ``='$archive', `changed`= 1 WHERE `id` = $id");
  } else {
    $res = db_query("UPDATE `ftt_gospel` SET ``='$archive', `changed`= 1 WHERE `id` = $id");
  }

  return $res;
}
*/
// удалить Бланк
function deleteBlank($id){
  global $db;
  $id = $db->real_escape_string($id);
  $res = db_query("DELETE FROM `ftt_gospel` WHERE `id` = $id");

  return $res;
}

// members group
function getGospelGroup() {
  $result;
  $res = db_query("SELECT ft.gospel_group, ft.gospel_team, fgt.name, fgt.place, ft.member_key
    FROM ftt_trainee AS ft
    INNER JOIN ftt_gospel_team fgt ON fgt.id = ft.gospel_team
    WHERE ft.gospel_group <> 0
    ORDER BY ft.gospel_team, ft.gospel_group");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

function getGospelGroupNumber() {
  $result;
  $res = db_query("SELECT DISTINCT `gospel_group` FROM `ftt_trainee` WHERE `gospel_group` <> 0 ORDER BY `gospel_group`");
  while ($row = $res->fetch_assoc()) $result[] = $row['gospel_group'];
  return $result;
}
/*
function getGospelGroupsNumber($team_id) {
  global $db;
  $team_id = $db->real_escape_string($team_id);
  $result;
  $res = db_query("SELECT DISTINCT `gospel_group` FROM `ftt_trainee` WHERE `gospel_group` <> 0 AND `gospel_team` = '$team_id' ORDER BY `gospel_group`");
  while ($row = $res->fetch_assoc()) $result[] = $row['gospel_group'];
  return $result;
}
*/
function get_ftt_group_members($team_id, $goup_id = '_none_')
{
  global $db;
  $team_id = $db->real_escape_string($team_id);
  $goup_id = $db->real_escape_string($goup_id);
  $result = [];
  $condition_extra = '';

  if ($goup_id !== "null" && $goup_id !== "_all_" && $goup_id !== "_none_" && $goup_id >= 0) {
    $condition_extra = " AND ft.gospel_group = '$goup_id' ";
  }

  // group members
  $res = db_query("SELECT ft.member_key, ft.gospel_group, m.name
    FROM ftt_trainee AS ft
    INNER JOIN member m ON m.key = ft.member_key
    WHERE ft.gospel_team = '$team_id' {$condition_extra}
    ORDER BY ft.gospel_group");
  while ($row = $res->fetch_assoc()) {
    if (empty($result[$row['gospel_group']])) {
      $result[$row['gospel_group']] = [$row];
    } else {
      array_push($result[$row['gospel_group']],$row);
    }
  }
  return $result;
}

// get gospel team members
function get_gospel_members($blankId) {
  global $db;
  $blankId = $db->real_escape_string($blankId);
  $result = [];
  $res = db_query("SELECT * FROM `ftt_gospel_members` WHERE `blank_id` = '$blankId'");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

function get_all_gospel_members() {
  $result = [];
  $res = db_query("SELECT * FROM `ftt_gospel_members`");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

// СТАТИСТИКА БЛАГОВЕСТИЯ
function gospelStatFun($team, $teamsList)
{
  // список обучающиеся в команде
  $traineesList = GospelStatistic::traineesByTeam($team);
  // группы команды
  $groupsList = getGospelGroups($team);

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
    $datePeriodWeek = date_create(date('Y-m-d'));
    date_sub($datePeriodWeek,date_interval_create_from_date_string("{$remainder} days"));
    $key_date = date_format($datePeriodWeek,"Y-m-d") . ' — ' . date('Y-m-d');
    // получаем данные по команде за период
    $gospelTeamReportData[$key_date] = GospelStatistic::teamReport($team, date('Y-m-d'), $remainder);
    // задаём дату для следующей итерации
    date_sub($date_current_report,date_interval_create_from_date_string("{$remainder} days"));
  } elseif ($remainder < 0) {
    $remainder = 7 + $remainder;
    // подготавлеваем даты периода
    $datePeriodWeek = date_create(date('Y-m-d'));
    date_sub($datePeriodWeek,date_interval_create_from_date_string("{$remainder} days"));
    $key_date = date_format($datePeriodWeek,"Y-m-d") . ' — ' . date('Y-m-d');
    // получаем данные по команде за период
    $gospelTeamReportData[$key_date] = GospelStatistic::teamReport($team, date('Y-m-d'), $remainder);
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
    // задаём дату для следующей итерации
    date_sub($date_current_report,date_interval_create_from_date_string("7 days"));
  }
  // ДОБАВИТЬ ГРУППЫ СУЩЕСТВУЮЩИЕ ГРУППЫ ОТСУТСТВУЮЩИЕ В ОТЧЁТЕ
  $countForGTRDLoop = 0;
  foreach ($gospelTeamReportData as $key => $value) {
    $block = 0;

    if ($countForGTRDLoop == 0) {
      echo "<h5>{$teamsList[$team]}</h5>";
      $count = count($gospelTeamReportData);
    }
    if (empty($value) && $countForGTRDLoop == 0) {
      echo "<b>НЕДЕЛЯ {$count} {$key}</b><br>";
    } elseif(empty($value)) {
      echo "<b style='display: inline-block; padding-top: 10px;'>НЕДЕЛЯ {$count} {$key}</b><br>";
    }
    foreach ($value as $key_1 => $value_1) {
      if (!$block) {
        if ($countForGTRDLoop != 0) {
          echo "<b style='display: inline-block; padding-top: 10px;'>НЕДЕЛЯ {$count} {$key}</b><br>";
        } else {
          echo "<b>НЕДЕЛЯ {$count} {$key}</b><br>";
        }
      }

      $value_1['meets_last'] += $value_1['meets_current'];
      $value_1['meetings_last'] += $value_1['meetings_current'];

      echo "<b>Группа {$value_1['gospel_group']}</b><br>";
      echo $value_1['date'].', Л'.$value_1['flyers'].', Б'.$value_1['people'] .', М'. $value_1['prayers'] .', К';
      echo $value_1['baptism'] .', В'. $value_1['meets_last'] .', С'. $value_1['meetings_last'] .', Д'. $value_1['homes'];
      echo '.<br>';

      $block = 1;
    }
    $count--;
    $countForGTRDLoop++;
  }
  if (count($gospelTeamReportData) > 0) {
    echo "<hr>";
  }
}

?>
