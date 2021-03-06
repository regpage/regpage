<?php
// DB Query for FTT
// get requests
function db_getAllRequests ($adminId, $role, $guest){
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $role = $db->real_escape_string($role);
  $guest = $db->real_escape_string($guest);
  $condition = '';
  if ($role == 1) {
    $condition = "AND fr.recommendation_name = '".$adminId."'";
  } elseif ($role == 2) {
    $condition = "AND fi.interview_name = '".$adminId."' ";
  }
  if ($guest == 1) {
    $condition .= " AND fr.guest = 1";
  } else {
    $condition .= " AND fr.guest = 0";
  }
    $result = [];
//fr.interview_name, fr.interview_status, fr.interview_info,  fr.interview_meetings, fr.interview_apprehension, fr.interview_coordination, fr.interview_signature, fr.interview_date,
    $res=db_query ("SELECT fr.id as fr_id, fr.member_key, fr.request_date, fr.request_status, fr.notice, fr.send_date, fr.decision,
      m.name, m.male, m.locality_key, m.cell_phone, m.email, m.category_key, l.name AS locality_name,
      fi.interview_name
    FROM ftt_request AS fr
    INNER JOIN member m ON m.key = fr.member_key
    INNER JOIN locality l ON l.key = m.locality_key
    INNER JOIN ftt_interview fi ON fi.request_id = fr.id
    WHERE fr.notice < 2 {$condition} ");
    while ($row = $res->fetch_assoc()) $result[]=$row;
    // для коректного запроса все ключевые поля для выборки из присоединяемых таблиц должны быть заполнены

    $result_count = count($result);
    write_to_log::debug('000005716', "получено {$result_count} строк из списка заявлений для раздела ПВОМ"); //$adminId

    return $result;
}

// получаем рекомендатора
function db_getRecommender($adminId) {
  $access = false;
  $res=db_query("SELECT `id` FROM ftt_request WHERE `recommendation_name` = '$adminId' AND `notice` != 2");
  while ($row = $res->fetch_assoc()) $access = true;

  return $access;
}

// получаем собеседующего
function db_getInterviewer($adminId) {
  $access = false;
  $res=db_query("SELECT fi.id AS interview_id
    FROM ftt_interview AS fi
    INNER JOIN ftt_request fr ON fr.id = fi.request_id
    WHERE fi.interview_name = '$adminId' AND fr.notice != 2");
  while ($row = $res->fetch_assoc()) $access = true;

  return $access;
}

/*
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
