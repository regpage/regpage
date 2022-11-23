<?php
// МОЖНО РЕАЛИЗОВАТЬ КАК КЛАСС 'ВЫЗОВ ПАРАМЕТРОВ'
// ОБЯЗАТЕЛЬНО ПОСТАВИТЬ ЗАЩИТУ ОТ ИНЪЕКЦИЙ

// Получаем вопросы
function db_getRequestPoints() { // управлять зависимо от роли можно при рендеренге
  /*global $db;
  $admin = $db->real_escape_string($admin);*/
  $result = [];
  $res=db_query("SELECT * FROM `ftt_request_points` ORDER BY `group`, `position`");
    while ($row = $res->fetch_assoc()) $result[] = $row;

  return $result;
}

// заполнить поля заявление данными
function getMemberData($adminId) {
  global $db;
  $adminId = $db->real_escape_string($adminId);
  // LOG
  //write_to_log::debug('000005716', 'Запрошены данные пользователя '.$adminId);//$adminId

  $result = [];

  $res=db_query ("SELECT fr.id AS fr_id, fr.member_key, fr.request_date, fr.guest, fr.country_key AS fr_country_key, fr.salvation_date, fr.language,
    fr.passport_exp, fr.education, fr.profession, fr.occupation, fr.reg_address, fr.phone_home, fr.church_life_date, fr.church_life_city, fr.swt_num,
    fr.rbr_num, fr.ftt_num, fr.ftt_date, fr.guest_time_from, fr.guest_time_to, fr.marital_status, fr.marital_info, fr.spouse_name, fr.spouse_age,
    fr.spouse_faith, fr.spouse_church, fr.spouse_state, fr.spouse_consent, fr.support_persons, fr.support_info, fr.semester_pay, fr.baptize_date,
    fr.health_condition, fr.health_problems, fr.mental_problems, fr.mental_problems_when, fr.dependency_problems, fr.dependency_problems_when,
    fr.problems_info, fr.known_to, fr.request_info, fr.passport_scan, fr.passport_scan_2, fr.passport_scan_3, fr.questions,
    fr.agreement, fr.candidate_signature,
    fr.send_date, fr.recommendation_name, fr.recommendation_status, fr.recommendation_info, fr.recommendation_signature,
    fr.recommendation_date, fr.request_status, fr.decision, fr.decision_info, fr.decision_date, fr.notice, fr.inn,
    fr.skills, fr.right_handed,
    m.key AS m_key, m.name, m.male, m.locality_key, m.citizenship_key, m.baptized, m.document_auth, m.birth_date,
    DATEDIFF(CURRENT_DATE, STR_TO_DATE(m.birth_date, '%Y-%m-%d'))/365 as age, m.document_num, m.document_date, m.tp_num, m.tp_date,
    m.email, m.address, m.cell_phone, m.document_dep_code, m.tp_auth,
    fi.spiritual_question_02, fi.interview_name,
    l.name AS locality_name, c.name AS country_name, r.country_key
  FROM ftt_request AS fr
  INNER JOIN member m ON m.key = fr.member_key
  INNER JOIN locality l ON l.key = m.locality_key
  INNER JOIN region r ON r.key = l.region_key
  INNER JOIN country c ON c.key = r.country_key
  INNER JOIN ftt_interview fi ON fi.request_id = fr.id
  WHERE fr.member_key = '$adminId' AND fr.notice <> 2");
  while ($row = $res->fetch_assoc()) $result[]=$row;
  // для коректного запроса все ключевые поля для выборки из присоединяемых таблиц должны быть заполнены

  $result_count = count($result);
  //write_to_log::debug('000005716', "получено {$result_count} строк из списка заявлений для раздела ПВОМ"); //$adminId

  return $result[0];function db_getPicForRequest($id, $field) {
  global $db;
  $id = $db->real_escape_string($id);
  $field = $db->real_escape_string($field);
  $pics;
  if ($field === 'passport_scan') {
    $res=db_query("SELECT `passport_scan`, `passport_scan_2`, `passport_scan_3` FROM ftt_request WHERE `id` = '$id'");
    while ($row = $res->fetch_assoc()) $pics=[$row['passport_scan'],$row['passport_scan_2'],$row['passport_scan_3']];
  } else {
    $res=db_query("SELECT `$field` FROM ftt_request WHERE `id` = '$id'");
    while ($row = $res->fetch_assoc()) $pics=[$row[$field]];
  }

  return $pics;
}
}

// предварительное заполнение заявления данными из базы рег пэйдж
function getStartMemberData($adminId) {
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $res=db_query ("SELECT m.key AS m_key , m.name, m.male, m.locality_key, m.citizenship_key, m.baptized, m.birth_date,
    DATEDIFF(CURRENT_DATE, STR_TO_DATE(m.birth_date, '%Y-%m-%d'))/365 as age, m.document_num, m.document_auth,
    m.document_date, m.document_dep_code, m.tp_num, m.tp_date, m.tp_auth, m.email, m.address, m.cell_phone,
    l.name AS locality_name, c.name AS country_name, r.country_key
  FROM member AS m
  INNER JOIN locality l ON l.key = m.locality_key
  INNER JOIN region r ON r.key = l.region_key
  INNER JOIN country c ON c.key = r.country_key
  WHERE m.key = '$adminId'");
  while ($row = $res->fetch_assoc()) $result[]=$row;

  return $result[0];
}
// обновить данные переданного поля в заявлении переданными данными
function setRequestField($adminId, $field, $data, $id, $table, $isGuest, $blob=false) {
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $field = $db->real_escape_string($field);
  $data = $db->real_escape_string($data);
  $id = $db->real_escape_string($id);
  $table = $db->real_escape_string($table);
  $isGuest = $db->real_escape_string($isGuest);
  $blob = $db->real_escape_string($blob);

  if ($table === 'member') {
    $id_field = 'key';
  } else {
    $id_field = 'id';
  }
  // дополнительные фотки
  if ($blob == 1) {
    $field .= '_2';
  } elseif ($blob == 2) {
    $field .= '_3';
  }
  //write_to_log::debug($adminId, "ПВОМ. Получены данные {$field} & {$data} & {$id} для обновления строк таблицы заявлений.");
  if ($id) {
    $res = db_query("UPDATE $table SET `$field` = '$data' WHERE  `$id_field` = '$id'");
  } else {
    db_query("INSERT INTO $table (`$field`, `member_key`, `guest`, `request_status`) VALUES ('$data', '$adminId', '$isGuest', '1')");
    $res2 = db_query("SELECT MAX(id) AS maxid FROM $table");
    while ($row = $res2->fetch_assoc()) $res=$row['maxid'];

    db_query("INSERT INTO ftt_interview (`request_id`) VALUES ('$res')");
  }

  return $res;
}
// удалить заявление из базы
function db_deleteRequest($id) {
  $res = db_query("DELETE FROM ftt_request WHERE `id` = '$id'");
  if ($res) {
    db_query("DELETE FROM ftt_interview WHERE `request_id` = '$id'");
  }
  return $res;
}
// отправить заявление в корзину
function db_setTrashForRequest($id) {
  $res = db_query("UPDATE ftt_request SET `notice` = 2 WHERE `id` = '$id'");

  return $res;
}
// Удаление сканов из бланка
function db_deletePicFromRequest($id, $field) {
  global $db;
  $field = $db->real_escape_string($field);
  $id = $db->real_escape_string($id);
  $res;
  $res = db_query("UPDATE ftt_request SET `$field` = '' WHERE `id` = '$id'");

  return $res;
}

function db_getPicForRequest($id, $field) {
  global $db;
  $id = $db->real_escape_string($id);
  $field = $db->real_escape_string($field);
  $pics;
  if ($field === 'passport_scan') {
    $res=db_query("SELECT `passport_scan`, `passport_scan_2`, `passport_scan_3` FROM ftt_request WHERE `id` = '$id'");
    while ($row = $res->fetch_assoc()) $pics=[$row['passport_scan'],$row['passport_scan_2'],$row['passport_scan_3']];
  } else {
    $res=db_query("SELECT `$field` FROM ftt_request WHERE `id` = '$id'");
    while ($row = $res->fetch_assoc()) $pics=[$row[$field]];
  }

  return $pics;
}
// Задаём статус ОТПРАВЛЕНО
function db_setStatusRequestToSent($id, $status = 2) {
  global $db;
  $id = $db->real_escape_string($id);
  $status = $db->real_escape_string($status);
  $date = 'send_date';
  if ($status == 3) {
    $date = 'recommendation_date';
  }
  $res = db_query("UPDATE ftt_request SET `request_status` = '$status', `$date` = NOW() WHERE `id` = '$id'");
}


?>
