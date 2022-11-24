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
    fr.health_condition, fr.health_problems, fr.known_to, fr.request_info, fr.passport_scan, fr.passport_scan_2, fr.passport_scan_3, fr.questions,
    fr.agreement, fr.candidate_signature,
    fr.send_date, fr.recommendation_name, fr.recommendation_status, fr.recommendation_info, fr.recommendation_signature,
    fr.recommendation_date, fr.request_status, fr.decision, fr.decision_info, fr.decision_date, fr.notice, fr.inn,
    fr.skills, fr.right_handed,
    fr.health_question1, fr.health_question2, fr.health_question3, fr.health_question4, fr.health_question5,
    fr.health_question6, fr.health_question7, fr.health_question8, fr.health_question9, fr.health_question10, fr.health_question11, fr.health_question12, fr.health_question13, fr.health_question14, fr.health_question15,
    fr.health_question16, fr.health_question17, fr.health_question18, fr.health_question19, fr.health_question20,
    fr.health_question21, fr.health_question22, fr.health_question23, fr.health_question24, fr.health_question25,
    fr.health_question26, fr.health_question27, fr.health_question28, fr.health_question29, fr.health_question30, fr.health_question31, fr.health_question32, fr.health_question33, fr.health_question34, fr.health_question35,
    fr.health_question36, fr.health_question37, fr.health_question38, fr.health_question39, fr.health_question40,
    fr.health_question41, fr.health_question42, fr.health_question43, fr.health_question44, fr.health_question45,
    fr.health_question46, fr.health_question47, fr.health_question48, fr.health_question49, fr.vac_question1,
    fr.vac_question2, fr.vac_question3, fr.vac_question4, fr.vac_question5, fr.vac_question6, fr.food_question1, fr.food_question2, fr.food_question3, fr.food_question4, fr.food_question6, fr.food_question7, fr.food_question8, fr.consecration, fr.decision_name,
    fr.another_names, fr.place_of_birth, fr.arrests, fr.criminal_cases, fr.administrative_cases, fr.snils,
    fr.reg_document, fr.photo, fr.spouse_occupation, fr.spouse_plans, fr.support, fr.educational_institution,
    fr.education_end, fr.work_place, fr.russian_knowlege, fr.driver_license, fr.driving_experience,
    fr.church_life_period, fr.first_church_life_city,
    fr.next_church_life_city, fr.church_life_city_when, fr.church_service, fr.conf_num, fr.read_nt, fr.read_to,
    fr.read_books, fr.semester, fr.was_there_training, fr.will_be_two_years, fr.how_many_semesters,
    fr.how_many_explanation, fr.who_will_pay,
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
