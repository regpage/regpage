<?php

// Доб. задания
function getExtraHelp($adminId, $serving_trainee, $sorting=''){
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $serving_trainee = $db->real_escape_string($serving_trainee);
  $sorting = $db->real_escape_string($sorting);
  $sort = $db->real_escape_string($sort);
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
  $res = db_query("SELECT feh.id AS feh_id, feh.date, feh.member_key AS feh_member_key, feh.reason, feh.archive, feh.author, feh.serving_one AS feh_serving_one, feh.comment, feh.archive_date, ft.semester, ft.serving_one, m.name
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
  $res = db_query("SELECT feh.id AS feh_id, feh.date, feh.member_key AS feh_member_key, feh.reason, feh.archive, feh.author, feh.serving_one AS feh_serving_one, feh.comment, feh.archive_date, ft.semester, ft.serving_one
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

  $res = db_query("INSERT INTO `ftt_extra_help`(`date`, `member_key`, `reason`, `archive`, `author`, `comment`, `archive_date`, `serving_one`, `changed`)
  VALUES ('$date','$member_key','$reason','$archive','$author','$comment','$archive_date', '$serving_one', 1)");
  if ($res) {
    $res2 = db_query("SELECT MAX(`id`) AS last_id FROM `ftt_extra_help` LIMIT 1");
    while ($row = $res2->fetch_assoc()) $result = $row['last_id'];

    $res3 = db_query("SELECT feh.id AS feh_id, feh.date, feh.member_key, feh.reason, feh.archive, feh.author,
    feh.serving_one AS archivator, feh.comment, feh.archive_date, feh.changed,
    ft.semester, ft.serving_one as ft_serving_one
    FROM `ftt_extra_help` AS feh
    INNER JOIN ftt_trainee ft ON ft.member_key = feh.member_key
    WHERE `id`='$result'");
    while ($row = $res3->fetch_assoc()) $result2 = $row;

    return $result2;
  } else {
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

// Доб. задания
function setExtraHelpDone($id, $archive, $adminId) {
  global $db;
  $id = $db->real_escape_string($id);
  $archive = $db->real_escape_string($archive);
  $adminId = $db->real_escape_string($adminId);
  if ($archive == 1) {
    $res = db_query("UPDATE `ftt_extra_help` SET `archive`='$archive', `serving_one`= '$adminId', `archive_date`=NOW(), `changed`= 1 WHERE `id` = $id");
  } else {
    $res = db_query("UPDATE `ftt_extra_help` SET `archive`='$archive', `serving_one`= '', `archive_date`='0000-00-00', `changed`= 1 WHERE `id` = $id");
  }

  return $res;
}

// удалить доб. задания
function deleteExtraHelpString($id){
  global $db;
  $id = $db->real_escape_string($id);
  $res = db_query("DELETE FROM `ftt_extra_help` WHERE `id` = $id");

  return $res;
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


  $res = db_query("INSERT INTO `ftt_late`(`date`, `member_key`, `session_name`, `done`, `author`, `delay`, `changed`)
  VALUES ('$date','$member_key','$session_name','$done','$author','$delay', 1)");
  if ($res) {
    $res2 = db_query("SELECT MAX(`id`) AS last_id FROM `ftt_late` LIMIT 1");
    while ($row = $res2->fetch_assoc()) $result = $row['last_id'];

    $res3 = db_query("SELECT feh.id AS feh_id, feh.date, feh.member_key, feh.session_name, feh.done, feh.author,
    feh.delay,  feh.changed,
    ft.semester, ft.serving_one as ft_serving_one
    FROM `ftt_late` AS feh
    INNER JOIN ftt_trainee ft ON ft.member_key = feh.member_key
    WHERE `id`='$result'");
    while ($row = $res3->fetch_assoc()) $result2 = $row;

    return $result2;
  } else {
    return $res;
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

?>
