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

  $res=db_query ("SELECT fr.*,
    m.key AS m_key, m.name, m.male, m.locality_key, m.citizenship_key, m.baptized, m.document_auth, m.birth_date,
    DATEDIFF(CURRENT_DATE, STR_TO_DATE(m.birth_date, '%Y-%m-%d'))/365 as age, m.document_num, m.document_date, m.tp_num, m.tp_date, m.tp_name,
    m.email, m.address, m.cell_phone, m.document_dep_code, m.tp_auth,
    l.name AS locality_name, c.name AS country_name, r.country_key AS r_country_key
  FROM ftt_request AS fr
  INNER JOIN member m ON m.key = fr.member_key
  INNER JOIN locality l ON l.key = m.locality_key
  INNER JOIN region r ON r.key = l.region_key
  INNER JOIN country c ON c.key = r.country_key
  WHERE fr.member_key = '$adminId' AND fr.notice <> 2");
  while ($row = $res->fetch_assoc()) $result[]=$row;
  // для коректного запроса все ключевые поля для выборки из присоединяемых таблиц должны быть заполнены
  // $result_count = count($result);
  // write_to_log::debug('000005716', "получено {$result_count} строк из списка заявлений для раздела ПВОМ"); //$adminId

  return $result[0];
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
function setRequestField($adminId, $field, $data, $id, $table, $isGuest, $blob=false, $data_post=false) {
  global $db;
  $adminId = $db->real_escape_string($adminId);
  $field = $db->real_escape_string($field);
  if ($data_post) {
    $data = $db->real_escape_string($data_post);
  } else {
    $data = $db->real_escape_string($data);
  }
  $id = $db->real_escape_string($id);
  $table = $db->real_escape_string($table);
  $isGuest = $db->real_escape_string($isGuest);
  $blob = $db->real_escape_string($blob);

  if ($table === 'member') {
    $id_field = 'key';
    $changed_one = ", `changed` = '1'";
    //$changed_one = '';
  } else {
    $id_field = 'id';
    $changed_one = '';
  }
  // дополнительные фотки
  if ($blob == 1) {
    $field .= '_2';
  } elseif ($blob == 2) {
    $field .= '_3';
  }
  //write_to_log::debug($adminId, "ПВОМ. Получены данные {$field} & {$data} & {$id} для обновления строк таблицы заявлений.");$changed_one
  if ($id) {
    $res = db_query("UPDATE $table SET `$field` = '$data' $changed_one  WHERE  `$id_field` = '$id'");
  } else {
    $res = db_query("INSERT INTO $table (`$field`, `member_key`, `guest`, `stage`) VALUES ('$data', '$adminId', '$isGuest', '0')");
    $res = $db->insert_id;
  }

  return $res;
}
// удалить заявление из базы
function db_deleteRequest($id) {
  $res = db_query("DELETE FROM ftt_request WHERE `id` = '$id'");
  /*if ($res) {
    db_query("DELETE FROM ftt_interview WHERE `request_id` = '$id'");
  }*/
  return $res;
}
// отправить заявление в корзину
function db_setTrashForRequest($id) {
  $res = db_query("DELETE FROM ftt_request WHERE `id` = '$id'");
  //$res = db_query("UPDATE ftt_request SET `notice` = 2 WHERE `id` = '$id'");

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
function db_setStatusRequestToSent($id, $status = 1, $adminId='') {
  global $db;
  $id = $db->real_escape_string($id);
  $status = $db->real_escape_string($status);
  $date = 'send_date';
  $responsible = '';
  if ($status == 2 || $status == 3) {
    $date = 'recommendation_date';
  } elseif ($status == 4 || $status == 5) {
    $date = 'interview_date';
  } elseif ($status == 6) {
    $date = 'decision_date';
  }
  if ($adminId && ($status == 2 || $status == 4)) {
    $responsible = ", `responsible` = '$adminId' ";
  }
  $res = db_query("UPDATE ftt_request SET `stage` = '$status', `$date` = NOW() $responsible WHERE `id` = '$id'");
}

// Получаем вопросы
function db_getChurchLifeBrothers() { // управлять зависимо от роли можно при рендеренге
  /*global $db;
  $admin = $db->real_escape_string($admin);*/
  $result = [];
  $res=db_query("SELECT `key`,`name`
    FROM `member`
    WHERE `male` = 1 AND (`category_key` = 'ST' OR `category_key` = 'RB' OR `category_key` = 'FS' OR `category_key` = 'FT') ORDER BY `name`");
    while ($row = $res->fetch_assoc()) $result[$row['key']] = $row['name'];

  return $result;
}

?>
