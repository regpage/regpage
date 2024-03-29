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
  $checkLocality;
  $res=db_query ("SELECT `locality_key` FROM `member` WHERE `key` = '$adminId'");
  while ($row = $res->fetch_assoc()) $checkLocality=$row['locality_key'];

  if (empty($checkLocality)) {
    $localityQuery = '';
    $localityTables = '';
  } else {
    $localityQuery = ', l.name AS locality_name, c.name AS country_name, r.country_key AS r_country_key';
    $localityTables = 'INNER JOIN locality l ON l.key = m.locality_key INNER JOIN region r ON r.key = l.region_key INNER JOIN country c ON c.key = r.country_key';
  }

  $res=db_query ("SELECT fr.*,
    m.key AS m_key, m.name, m.male, m.locality_key, m.citizenship_key, m.baptized, m.document_auth, m.birth_date,
    DATEDIFF(CURRENT_DATE, STR_TO_DATE(m.birth_date, '%Y-%m-%d'))/365 as age, m.document_num, m.document_date,
    m.tp_num, m.tp_date, m.tp_name, m.email, m.address, m.cell_phone, m.document_dep_code, m.tp_auth, m.new_locality
    {$localityQuery}
  FROM ftt_request AS fr
  INNER JOIN member m ON m.key = fr.member_key
  {$localityTables}
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
    DATEDIFF(CURRENT_DATE, STR_TO_DATE(m.birth_date, '%Y-%m-%d'))/365 as age, m.document_num, m.document_auth, m.new_locality,
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
    //db_query("LOCK TABLES {$table} WRITE");
    $res = db_query("INSERT INTO {$table} (`$field`, `member_key`, `guest`, `stage`) VALUES ('$data', '$adminId', '$isGuest', '0')");
    //$res = $db->insert_id;
    //db_query("UNLOCK TABLES;");
  }

  return $res;
}
// удалить заявление из базы
function db_deleteRequest($id) {
  // Удаление сканов из бланка
  $paths = [];
  $resPath=db_query("SELECT `passport_scan`, `passport_scan_2`, `passport_scan_3`, `photo`, `spouse_consent` FROM ftt_request WHERE `id` = '$id'");
  while ($row = $resPath->fetch_assoc()) $paths=[$row['passport_scan'],$row['passport_scan_2'],$row['passport_scan_3'],$row['photo'],$row['spouse_consent']];

  foreach ($paths as $key => $value) {
    if (!empty($value)) {
      $file = explode('ajax/', $value);
      if (isset($file[1]) && !empty($file[1])) {
        unlink($file[1]);
      }
    }
  }

  $res = db_query("DELETE FROM ftt_request WHERE `id` = '$id'");

  return $res;
}
// отправить заявление в корзину
function db_setTrashForRequest($id) {
  $res = db_query("UPDATE ftt_request SET `notice` = 2 WHERE `id` = '$id'");
  return $res;
}

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

  if ($status == 1) {
    if (empty($adminId)) {
      $adminId = db_getMemberIdBySessionId (session_id());
    }
    if (false) { //debug
	   $men = 'zhichkinroman@gmail.com, info@new-constellation.ru';
    } else {
	   $men = 'zhichkinroman@gmail.com, a.rudanok@gmail.com, kristalenkoserg@gmail.com';
    }

    // получаем имя пользователя
    $user = '';
    $res=db_query("SELECT `name` FROM `member` WHERE `key` = '$adminId'");
      while ($row = $res->fetch_assoc()) $user = $row['name'];
    $guest = '';
    $res4=db_query("SELECT `guest` FROM `ftt_request` WHERE `id` = '$id'");
      while ($row = $res4->fetch_assoc()) $guest = $row['guest'];

    if ($guest == 1) {
      $guest = " ГОСТЬ ";
    } else {
      $guest = '';
    }

    $message = "Получено новое заявление ПВОМ {$guest} от {$user} ".date("H:i:s").' '.date("d.m.Y").".<br><br> https://reg-page.ru/application.php?member_key=".strval($adminId);
    Emailing::send($men, "Новое заявление ПВОМ {$guest}", $message);
  }

  if ($adminId && $status == 2) {
    $responsible = ", `responsible_rec` = '$adminId' ";
  } elseif ($adminId && $status == 4) {
    $responsible = ", `responsible_int` = '$adminId' ";
  } elseif ($adminId && $status == 6) {
    $responsible = ", `responsible` = '$adminId' ";
  }

  $res2 = db_query("UPDATE ftt_request SET `stage` = '$status', `$date` = NOW() $responsible WHERE `id` = '$id'");

  if ($res2 && $status == 2) {
    $data;
    $res3 = db_query("SELECT fr.recommendation_name, fr.member_key, m.name
      FROM ftt_request fr
      INNER JOIN member m ON m.key = fr.member_key
      WHERE `id` = '$id'");
      while ($row = $res3->fetch_assoc()) $data = $row;
    $message = "Просим вас дать рекомендацию кандидату на ПВОМ — {$data['name']}.<br><br>Ссылка на заявление ПВОМ  https://reg-page.ru/application.php?member_key=".strval($data['member_key'])."<br><br>Служащие ПВОМ";
    Emailing::send_by_key($data['recommendation_name'], 'Рекомендация кандидату на ПВОМ', $message);
  }

  if ($res2 && $status == 4) {
    $data;
    $res3 = db_query("SELECT fr.interview_name, fr.member_key, m.name
      FROM ftt_request fr
      INNER JOIN member m ON m.key = fr.member_key
      WHERE `id` = '$id'");
      while ($row = $res3->fetch_assoc()) $data = $row;
    $message = "Просим вас провести собеседование с кандидатом на ПВОМ — {$data['name']}.<br><br> https://reg-page.ru/application.php?member_key=".strval($data['member_key'])."<br><br>Служащие ПВОМ";
    Emailing::send_by_key($data['interview_name'], 'Собеседование с кандидатом на ПВОМ', $message);
  }

  if ($res2 && $status == 3) {
    $data;
    $res3 = db_query("SELECT fr.responsible_rec, fr.member_key, m.name
      FROM ftt_request fr
      INNER JOIN member m ON m.key = fr.member_key
      WHERE `id` = '$id'");
      while ($row = $res3->fetch_assoc()) $data = $row;
    $message = "Получена рекомендация. Ссылка на заявление ПВОМ от {$data['name']}.<br><br> https://reg-page.ru/application.php?member_key=".strval($data['member_key']);
    Emailing::send_by_key($data['responsible_rec'], 'Получена рекомендация', $message);
  }

  if ($res2 && $status == 5) {
    $data;
    $res3 = db_query("SELECT fr.responsible_int, fr.member_key, m.name
      FROM ftt_request fr
      INNER JOIN member m ON m.key = fr.member_key
      WHERE `id` = '$id'");
      while ($row = $res3->fetch_assoc()) $data = $row;
    $message = "Пройдено собеседование. Ссылка на заявление ПВОМ от {$data['name']}.<br><br> https://reg-page.ru/application.php?member_key=".strval($data['member_key']);
    Emailing::send_by_key($data['responsible_int'], 'Пройдено собеседование', $message);
  }
}

// Получаем вопросы
function db_getChurchLifeBrothers() { // управлять зависимо от роли можно при рендеренге
  /*global $db;
  $admin = $db->real_escape_string($admin);*/
  $result = [];
  $res=db_query("SELECT m.key, m.name, m.locality_key, l.name AS locality
    FROM member m
    INNER JOIN locality l ON l.key = m.locality_key
    WHERE male = 1 AND (m.category_key = 'SN' OR m.category_key = 'RB' OR m.category_key = 'FS' OR m.category_key = 'FT') ORDER BY m.name");
    while ($row = $res->fetch_assoc()) $result[$row['key']] = $row['name'].' ('.$row['locality'].')';
  return $result;
}

?>
