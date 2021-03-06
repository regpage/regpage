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

  if ($sorting === 'sort_date-desc') {
    $order_by = 'fg.date DESC';
  } elseif ($sorting === 'sort_date-asc') {
    $order_by = 'fg.date ASC';
  } elseif ($sorting === 'sort_team-desc') {
    $order_by = 'place_name DESC, fg.gospel_group';
  } elseif ($sorting === 'sort_team-asc') {
    $order_by = 'place_name ASC, fg.gospel_group';
  } elseif ($sorting === 'sort_group-desc') {
    $order_by = 'fg.gospel_group DESC';
  } elseif ($sorting === 'sort_group-asc') {
    $order_by = 'fg.gospel_group ASC';
  } else {
    $order_by = 'fg.date DESC';
  }

  $result = [];
  $res = db_query("SELECT fg.id, fg.date, fg.gospel_team, fg.gospel_group, fg.place, fg.group_members, fg.number, fg.flyers,
     fg.people, fg.prayers, fg.baptism, fg.meets_last, fg.meets_current, fg.meetings_last, fg.meetings_current,
     fg.first_contacts, fg.further_contacts, fg.homes, fg.author, fg.comment, fg.changed,
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
  $number = $db->real_escape_string($data['number_field']);
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

  $first_contacts = $db->real_escape_string($data['first_contacts_field']);
  $further_contacts = $db->real_escape_string($data['further_contacts_field']);
  $homes = $db->real_escape_string($data['homes_field']);
  //$place_name = $db->real_escape_string($data['place_name_field']);
  //$fgt_place = $db->real_escape_string($data['fgt_place']);
  $author = $db->real_escape_string($data['author']);
  $comment = $db->real_escape_string($data['comment_field']);
//`place`, '$place',
  $res = db_query("INSERT INTO `ftt_gospel`(`date`, `gospel_team`, `gospel_group`, `group_members`,
    `number`, `flyers`, `people`, `prayers`, `baptism`, `meets_last`, `meets_current`, `meetings_last`, `meetings_current`,
    `first_contacts`, `further_contacts`, `homes`, `author`, `comment`, `changed`)
  VALUES ('$date','$gospel_team','$gospel_group','$group_members','$number','$flyers','$people', '$prayers', '$baptism',
     '$meets_last', '$meets_current', '$meetings_last', '$meetings_current', '$first_contacts', '$further_contacts',
     '$homes', '$author', '$comment', 1)");
  if ($res) {
    $res2 = db_query("SELECT MAX(`id`) AS last_id FROM `ftt_gospel` LIMIT 1");
    while ($row = $res2->fetch_assoc()) $result = $row['last_id'];

    $res3 = db_query("SELECT fg.id, fg.date, fg.gospel_team, fg.gospel_group, fg.place, fg.group_members, fg.number, fg.flyers,
       fg.people, fg.prayers, fg.baptism, fg.meets_last, fg.meets_current, fg.meetings_last, fg.meetings_current,
       fg.first_contacts, fg.further_contacts, fg.homes, fg.author, fg.comment, fg.changed,
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
  $number = $db->real_escape_string($data['number_field']);
  $flyers = $db->real_escape_string($data['flyers_field']);
  $people = $db->real_escape_string($data['people_field']);
  $prayers = $db->real_escape_string($data['prayers_field']);
  $baptism = $db->real_escape_string($data['baptism_field']);
  $meets_last = $db->real_escape_string($data['meets_last_field']);
  $meets_current = $db->real_escape_string($data['meets_current_field']);
  $meetings_last = $db->real_escape_string($data['meetings_last_field']);
  $meetings_current = $db->real_escape_string($data['meetings_current_field']);
  $first_contacts = $db->real_escape_string($data['first_contacts_field']);
  $further_contacts = $db->real_escape_string($data['further_contacts_field']);
  $homes = $db->real_escape_string($data['homes_field']);
  //$place_name = $db->real_escape_string($data['place_name_field']);
  //$fgt_place = $db->real_escape_string($data['fgt_place']);
  $author = $db->real_escape_string($data['author']);
  $comment = $db->real_escape_string($data['comment_field']);
//`place`='$place',
  $res = db_query("UPDATE `ftt_gospel` SET `date`='$date',`gospel_team`='$gospel_team',`gospel_group`='$gospel_group',`group_members`='$group_members',
    `number`='$number',`flyers`='$flyers',`people`='$people',`prayers`='$prayers',`baptism`='$baptism',`meets_last`='$meets_last',
    `meets_current`='$meets_current', `meetings_last`='$meetings_last',`meetings_current`='$meetings_current',
    `first_contacts`='$first_contacts',`further_contacts`='$further_contacts',`homes`='$homes',`author`='$author',`comment`='$comment',`changed`= 1
    WHERE `id`='$id'");

  $result;
  if ($res) {
    $res2 = db_query("SELECT fg.id, fg.date, fg.gospel_team, fg.gospel_group, fg.place, fg.group_members, fg.number, fg.flyers,
       fg.people, fg.prayers, fg.baptism, fg.meets_last, fg.meets_current, fg.meetings_last, fg.meetings_current,
       fg.first_contacts, fg.further_contacts, fg.homes, fg.author, fg.comment, fg.changed,
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

// ?????????? ?? ??????????
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
// ?????????????? ??????????
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
?>
