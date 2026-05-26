<?php

// Доб. задания
function getExtraHelp($adminId, $serving_trainee, $sorting=''){
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $serving_trainee = $db->real_escape_string($serving_trainee);
  $sorting = $db->real_escape_string($sorting);
  if ($serving_trainee === 2) {
    $condition = "feh.author='{$adminId}'";
  } else {
    $condition = 1;
  }
  if ($sorting === 'sort_date-desc') {
    $order_by = 'feh.date DESC, m.name';
  } elseif ($sorting === 'sort_date-asc') {
    $order_by = 'feh.date ASC, m.name';
  } elseif ($sorting === 'sort_trainee-desc') {
    $order_by = 'm.name DESC, feh.date';
  } elseif ($sorting === 'sort_trainee-asc') {
    $order_by = 'm.name ASC, feh.date';
  } else {
    $order_by = 'feh.date DESC, m.name';
  }

  $result = [];
  //ORDER BY feh.date
  $res = db_query("SELECT feh.id AS feh_id, feh.date, feh.member_key AS feh_member_key, feh.reason, feh.archive, feh.author, feh.serving_one AS feh_serving_one, feh.comment, feh.archive_date, feh.file, ft.semester, ft.serving_one, m.name
    FROM ftt_extra_help AS feh
    INNER JOIN ftt_trainee ft ON ft.member_key = feh.member_key
    INNER JOIN member m ON m.key = feh.member_key
    WHERE $condition
    ORDER BY $order_by");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

function getExtraHelpTrainee($adminId){
  $result = [];
  $res = db_query("SELECT feh.id AS feh_id, feh.date, feh.member_key AS feh_member_key, feh.reason, feh.archive, feh.author, feh.serving_one AS feh_serving_one, feh.comment, feh.archive_date, feh.file, ft.semester, ft.serving_one
    FROM ftt_extra_help AS feh
    INNER JOIN ftt_trainee ft ON ft.member_key = feh.member_key
    WHERE feh.member_key = '$adminId'
    ORDER BY feh.date");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

function setAddExtraHelp($data){
  global $db;
  $result;
  $result2;
  $date = $db->real_escape_string($data['date']);
  $member_key = $db->real_escape_string($data['member_key']);
  $reason = $db->real_escape_string($data['reason']);
  $archive = $db->real_escape_string($data['archive']);
  $author = $db->real_escape_string($data['author']);
  $serving_one = $db->real_escape_string($data['serving_one']);
  $comment = $db->real_escape_string($data['comment']);
  $archive_date = $db->real_escape_string($data['archive_date']);
  db_query("LOCK TABLES ftt_extra_help WRITE");
  $res = db_query("INSERT INTO `ftt_extra_help`(`date`, `member_key`, `reason`, `archive`, `author`, `comment`, `archive_date`, `serving_one`, `changed`)
  VALUES ('$date','$member_key','$reason','$archive','$author','$comment','$archive_date', '$serving_one', 1)");
  if ($res) {
    $result = $db->insert_id;
    db_query("UNLOCK TABLES;");
    $res3 = db_query("SELECT feh.id AS feh_id, feh.date, feh.member_key, feh.reason, feh.archive, feh.author,
    feh.serving_one AS archivator, feh.comment, feh.archive_date, feh.changed,
    ft.semester, ft.serving_one as ft_serving_one
    FROM `ftt_extra_help` AS feh
    INNER JOIN ftt_trainee ft ON ft.member_key = feh.member_key
    WHERE `id`='$result'");
    while ($row = $res3->fetch_assoc()) $result2 = $row;
    return $result2;
  } else {
    db_query("UNLOCK TABLES;");
    return $res;
  }
}

function updateAddExtraHelp($data){
  global $db;
  $id = $db->real_escape_string($data['id']);
  $date = $db->real_escape_string($data['date']);
  $member_key = $db->real_escape_string($data['member_key']);
  $reason = $db->real_escape_string($data['reason']);
  $archive = $db->real_escape_string($data['archive']);
  $author = $db->real_escape_string($data['author']);
  $serving_one = $db->real_escape_string($data['serving_one']);
  $comment = $db->real_escape_string($data['comment']);
  $archive_date = $db->real_escape_string($data['archive_date']);

  $res = db_query("UPDATE `ftt_extra_help` SET `date`='$date', `member_key`='$member_key',
     `reason`='$reason',`archive`='$archive', `author`='$author', `comment`='$comment', `archive_date`='$archive_date', `serving_one` = '$serving_one', `changed`= 1
    WHERE `id`='$id'");

  $result;
  if ($res) {
    $res2 = db_query("SELECT feh.id AS feh_id, feh.date, feh.member_key, feh.reason, feh.archive, feh.author,
    feh.serving_one AS archivator, feh.comment, feh.archive_date, feh.changed,
    ft.semester, ft.serving_one as ft_serving_one
    FROM `ftt_extra_help` AS feh
    INNER JOIN ftt_trainee ft ON ft.member_key = feh.member_key
    WHERE `id`='$id'");
    while ($row = $res2->fetch_assoc()) $result = $row;

    return $result;
  } else {
    return $res;
  }
}

// Доп. задания
function setExtraHelpDone($id, $archive, $adminId) {
  global $db;
  $id = $db->real_escape_string($id);
  $archive = $db->real_escape_string($archive);
  $adminId = $db->real_escape_string($adminId);
  if ($archive == 1) {
    $res = db_query("UPDATE `ftt_extra_help` SET `archive`='$archive', `serving_one`= '$adminId', `archive_date`=CURDATE(), `changed`= 1 WHERE `id` = $id");
  } else {
    $res = db_query("UPDATE `ftt_extra_help` SET `archive`='$archive', `serving_one`= '', `archive_date`='0000-00-00', `changed`= 1 WHERE `id` = $id");
  }

  return $res;
}

// удалить доп. задания
function deleteExtraHelpString($id){
  global $db;
  $id = $db->real_escape_string($id);
  $res = db_query("DELETE FROM `ftt_extra_help` WHERE `id` = $id");

  return $res;
}

function getStatisticsExtraHelp($sorting)
{
  global $db;
  $sorting = $db->real_escape_string($sorting);
  $result = [];
  //ORDER BY feh.date
  $res = db_query("SELECT feh.id AS feh_id, feh.date, feh.member_key AS feh_member_key, feh.reason, feh.archive, feh.author, feh.serving_one AS feh_serving_one, feh.comment, feh.archive_date, ft.semester, ft.serving_one, m.name
    FROM ftt_extra_help AS feh
    INNER JOIN ftt_trainee ft ON ft.member_key = feh.member_key
    INNER JOIN member m ON m.key = feh.member_key
    WHERE 1
    ORDER BY m.name {$sorting}, feh.date DESC");
  while ($row = $res->fetch_assoc()) $result[$row['feh_member_key']][] = $row;
  return $result;
}

// ==== ОПОЗДАНИЯ ====
// get strings with a late
function getLateStrings() {
  $result = [];
  $res = db_query("SELECT fl.id, fl.member_key, fl.date, fl.delay, fl.session_name, fl.done, fl.author, fl.changed,
    m.name, ft.semester, ft.serving_one
    FROM ftt_late AS fl
    INNER JOIN ftt_trainee ft ON ft.member_key = fl.member_key
    INNER JOIN member m ON m.key = fl.member_key
    WHERE 1
    ORDER BY fl.date DESC, m.name ASC");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

// Отметить как выполненное
function setLateDone($id, $done){
  global $db;
  $id = $db->real_escape_string($id);
  $done = $db->real_escape_string($done);

  $res = db_query("UPDATE `ftt_late` SET `done`='$done', `changed`= 1 WHERE `id` = $id");

  return $res;
}

// set late
function setAddLate($data){
  global $db;
  $result;
  $result2;
  $date = $db->real_escape_string($data['date']);
  $member_key = $db->real_escape_string($data['member_key']);
  $session_name = $db->real_escape_string($data['session_name']);
  $done = $db->real_escape_string($data['done']);
  $author = $db->real_escape_string($data['author']);
  $delay = $db->real_escape_string($data['delay']);

  db_query("LOCK TABLES ftt_late WRITE");
  $res = db_query("INSERT INTO `ftt_late`(`date`, `member_key`, `session_name`, `done`, `author`, `delay`, `changed`)
  VALUES ('$date','$member_key','$session_name','$done','$author','$delay', 1)");
  if ($res) {
    $result = $db->insert_id;
    db_query("UNLOCK TABLES;");
    // check 3 lates
    latesToExtraHelp($member_key);
    // get data the added late
    $res3 = db_query("SELECT feh.id AS feh_id, feh.date, feh.member_key, feh.session_name, feh.done, feh.author,
    feh.delay,  feh.changed,
    ft.semester, ft.serving_one as ft_serving_one
    FROM `ftt_late` AS feh
    INNER JOIN ftt_trainee ft ON ft.member_key = feh.member_key
    WHERE `id`='$result'");
    while ($row = $res3->fetch_assoc()) $result2 = $row;
    return $result2;
  } else {
    db_query("UNLOCK TABLES;");
    return $res;
  }
}

// check 3 lates AND create extrahelp
function latesToExtraHelp($member_key)
{
  $threeLatesCheckList = [];
  $threeLatesCheck = db_query("SELECT * FROM `ftt_late` WHERE member_key ='{$member_key}' AND `done` = 0 ORDER BY `id`");
  while ($row = $threeLatesCheck->fetch_assoc()) $threeLatesCheckList[] = $row;

  if (count($threeLatesCheckList) > 2) {
    $text = '';
    $ids = [];
    for ($i = 0; $i <= 2; $i++) {
      $text .= date_convert::yyyymmdd_to_ddmm($threeLatesCheckList[$i]['date']) . " {$threeLatesCheckList[$i]['session_name']} — опоздание на {$threeLatesCheckList[$i]['delay']} мин.\r\n";
      $ids[] = $threeLatesCheckList[$i]['id'];
    }

    $newExtraHelp = setAddExtraHelp(['date' => date('Y-m-d'), 'member_key' => $member_key, 'reason' => $text, 'author' => '', 'serving_one' => '', 'comment' => '', 'archive_date' => '0000-00-00', 'archive' => 0]);
    if (count($newExtraHelp) > 0) {
      foreach ($ids as $id) {
        setLateDone($id, 1);
      }
    }
  }
}

// update late
function updateAddLate($data){
  global $db;
  $id = $db->real_escape_string($data['id']);
  $date = $db->real_escape_string($data['date']);
  $member_key = $db->real_escape_string($data['member_key']);
  $session_name = $db->real_escape_string($data['session_name']);
  $done = $db->real_escape_string($data['done']);
  $author = $db->real_escape_string($data['author']);
  $delay = $db->real_escape_string($data['delay']);

  $res = db_query("UPDATE `ftt_late` SET `date`='$date', `member_key`='$member_key',
     `session_name`='$session_name',`done`='$done', `author`='$author', `delay`='$delay', `changed`= 1
    WHERE `id`='$id'");

  $result;
  if ($res) {
    // check 3 lates
    latesToExtraHelp($member_key);
    // get data the updated late
    $res2 = db_query("SELECT feh.id AS feh_id, feh.date, feh.member_key, feh.session_name, feh.done, feh.author,
    feh.delay, feh.changed,
    ft.semester, ft.serving_one as ft_serving_one
    FROM `ftt_late` AS feh
    INNER JOIN ftt_trainee ft ON ft.member_key = feh.member_key
    WHERE `id`='$id'");
    while ($row = $res2->fetch_assoc()) $result = $row;

    return $result;
  } else {
    return $res;
  }

}

// удалить доб. задания
function deleteLateString($id){
  global $db;
  $id = $db->real_escape_string($id);
  $res = db_query("DELETE FROM `ftt_late` WHERE `id` = $id");

  return $res;
}
