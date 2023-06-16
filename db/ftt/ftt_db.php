<?php
// DB Query for FTT
// get requests
function db_getAllRequests ($adminId, $role, $guest, $sorting){
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $role = $db->real_escape_string($role);
  $guest = $db->real_escape_string($guest);
  $sorting = $db->real_escape_string($sorting);
  $result = [];
  $condition = '';
  if ($guest == 1) {
    $condition .= " fr.guest = 1";
  } else {
    $condition .= " fr.guest = 0";
  }
  if ($sorting === 'sort_fio-desc') {
    $order_by = 'm.name DESC';
  } elseif ($sorting === 'sort_fio-asc') {
    $order_by = 'm.name ASC';
  } elseif ($sorting === 'sort_locality-desc') {
    $order_by = 'l.name DESC';
  } elseif ($sorting === 'sort_locality-asc') {
    $order_by = 'l.name ASC';
  } else {
    $order_by = 'm.name DESC';
  }
//fr.interview_name, fr.interview_status, fr.interview_info,  fr.interview_meetings, fr.interview_apprehension, fr.interview_coordination, fr.interview_signature, fr.interview_date,
    $res=db_query ("SELECT fr.id as fr_id, fr.member_key, fr.request_date, fr.stage, fr.notice, fr.send_date, fr.decision,
      m.name, m.male, m.locality_key, m.cell_phone, m.email, m.category_key, l.name AS locality_name
    FROM ftt_request AS fr
    INNER JOIN member m ON m.key = fr.member_key
    INNER JOIN locality l ON l.key = m.locality_key
    WHERE {$condition} AND fr.notice != 2 ORDER BY {$order_by}");
    while ($row = $res->fetch_assoc()) $result[]=$row;
    // для коректного запроса все ключевые поля для выборки из присоединяемых таблиц должны быть заполнены

    //$result_count = count($result);
    //write_to_log::debug('000005716', "получено {$result_count} строк из списка заявлений для раздела ПВОМ"); //$adminId

    return $result;
}

// get requests
function db_getApplications ($adminId, $interview=false){
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $interview = $db->real_escape_string($interview);
  $result = [];
  if ($interview) {
    $condition = " fr.interview_name = '{$adminId}'";
  } else {
    $condition = " fr.recommendation_name = '{$adminId}'";
  }
  $res=db_query ("SELECT fr.id, fr.member_key, fr.request_date, fr.stage, fr.notice, fr.send_date, fr.decision,
    m.name, m.male, m.locality_key, m.cell_phone, m.email, m.category_key, l.name AS locality_name,
    fr.interview_name, fr.recommendation_name
  FROM ftt_request AS fr
  INNER JOIN member m ON m.key = fr.member_key
  INNER JOIN locality l ON l.key = m.locality_key
  WHERE fr.stage <> 0 AND fr.notice <> 2 AND {$condition}
  ORDER BY fr.stage, m.name");
  while ($row = $res->fetch_assoc()) $result[]=$row;

  return $result;
}

// получаем рекомендатора
function db_getRecommender($adminId) {
  $access = false;
  $res=db_query("SELECT `id` FROM ftt_request WHERE `recommendation_name` = '$adminId' AND `notice` != 2");
  while ($row = $res->fetch_assoc()) $access = true;

  return $access;
}

function sentRequestToPVOM($adminId, $guest)
{
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $guest = $db->real_escape_string($guest);
  $check = checkRequestToPVOM($adminId);
  if (!$check) {
    $res = db_query("INSERT INTO `ftt_request` (`member_key`, `notice`, `guest`) VALUES ('$adminId', 2, '$guest')");
    if ($res) {
      $topic = 'Новый запрос заявлениия на ПВОМ';
      $emailText = 'Поступил запрос на заявление на ПВОМ от ' . Member::get_name($adminId) . ' ' . date('d.m.Y G:i') . '<br><br><a href="https://reg-page.ru/ftt_application?tab=request">https://reg-page.ru/ftt_application?tab=request</a>';
      //Emailing::send('A.rudanok@gmail.com', $topic, $emailText);
      Emailing::send('kristalenkoserg@gmail.com', $topic, $emailText);
      Emailing::send('info@zhichkinroman.ru', $topic, $emailText);
      //Emailing::send_by_key($memberId, $topic, $emailText);
    }
  }
}

function checkRequestToPVOM($adminId)
{
  global $db;
  $adminId = $db->real_escape_string($adminId);

  $res=db_query("SELECT `id` FROM `ftt_request` WHERE `member_key` = '$adminId' AND `notice` = 2");
  while ($row = $res->fetch_assoc()) return $row['id'];

}

// get requests
function db_getRequestForApplication ($adminId, $trash=''){
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $trash = $db->real_escape_string($trash);
  $result = [];
  if ($trash) {
    $condition = " fr.notice = 2 ";
  } else {
    $condition = " fr.stage = 0 AND fr.notice <> 2 ";
  }
  $res=db_query ("SELECT fr.*,
    m.name, m.male, m.locality_key, m.cell_phone, m.email, m.category_key, l.name AS locality_name
  FROM ftt_request AS fr
  INNER JOIN member m ON m.key = fr.member_key
  INNER JOIN locality l ON l.key = m.locality_key
  WHERE {$condition}
  ORDER BY fr.stage, m.name");
  while ($row = $res->fetch_assoc()) $result[]=$row;

  return $result;
}

function createApplicationByRequest($id, $guest=0)
{
  global $db;
  $id = $db->real_escape_string($id);
  $guest = $db->real_escape_string($guest);

  $res = db_query("UPDATE `ftt_request` SET `notice` = 0, `guest` = '$guest' WHERE  `id` = '$id'");

  return $res;
}

function dltRequestFor($id)
{
  global $db;
  $id = $db->real_escape_string($id);

  $res = db_query("DELETE FROM `ftt_request` WHERE  `id` = '$id'");

  return $res;
}

// получаем собеседующего
/*
function db_getInterviewer($adminId) {
  $access = false;
  $res=db_query("SELECT fi.id AS interview_id
    FROM ftt_interview AS fi
    INNER JOIN ftt_request fr ON fr.id = fi.request_id
    WHERE fi.interview_name = '$adminId' AND fr.notice != 2");
  while ($row = $res->fetch_assoc()) $access = true;

  return $access;
}


// get requests
function db_getAllRequests ($adminId){
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $result = [];

    $res=db_query ("SELECT *
    FROM ftt_request AS fr
    INNER JOIN member m ON m.key = fr.member_key
    INNER JOIN ftt_interview fi ON fi.request_id = fr.id
    WHERE 1 ");
    while ($row = $res->fetch_assoc()) $result[]=$row;

  return $result;
}
*/
/*
// get request
function db_getAllRequests ($adminId){
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $result = [];

    $res=db_query ("SELECT c.id, m.name AS member_name, c.notice, c.project
    FROM ftt_request AS fr
    INNER JOIN member m ON m.key = fr.member_key
    INNER JOIN ftt_interview fi ON m.key = fr.id
    WHERE 1 ");
    while ($row = $res->fetch_assoc()) $result[]=$row;

  return $result;
}
*/
?>
