<?php

function db_getSessionsAdmins(){
    $res=db_query ("SELECT member_key, session FROM admin WHERE session IS NOT NULL");

		$sessions = array ();
		while ($row = $res->fetch_object()) $sessions[]=$row;
		return $sessions;
}

/*
function db_copySessions($adminId, $sessionId)
{
	global $db;
	$adminId = $db->real_escape_string($adminId);
	$sessionId = $db->real_escape_string($sessionId);
	db_query ("INSERT INTO admin_session (id_session, admin_key) VALUES ('$sessionId','$adminId')");
}
*/
function db_delete_old_sessions()
{
	global $db;
  $datatime = date("Y-m-d H:i:s");
  db_query ("DELETE FROM admin_session WHERE ($datatime - `time_last_visit`)>356");
}

function db_getCustomPagesPanel(){
    $res = db_query("SELECT * FROM custom_page");

    $pages = array();
    while($row = $res->fetch_assoc()){
        $pages [$row['name']] = $row['value'];
    }
    return $pages;
}

function db_setPracticesForStudentsPVOM() {
  logFileWriter(db_getMemberIdBySessionId (session_id()), 'ПРАКТИКИ. Пакетное добавление учёта практик для обучающихся ПВОМ администратором.', 'WARNING');

  $currentDate = date("Y-m-d");
  $resultFoUser = ':';
  $students = array();
  $queryStudents=db_query ("SELECT `key` FROM member WHERE `locality_key` = ''");
  while ($rowOfStudents = $queryStudents->fetch_assoc()) $students[]=$rowOfStudents['key'];

  $checkSettingOn = '';
  foreach ($students as $student){
    $checkSettingOn = '';
    $queryPracticesOn=db_query ("SELECT `member_key` FROM user_setting WHERE `member_key` = '$student' AND `setting_key` = '9'");
    while ($rowOfPracticesOn = $queryPracticesOn->fetch_assoc()) $checkSettingOn=$rowOfPracticesOn['member_key'];

    if (!$checkSettingOn) {
      $resultFoUser = $resultFoUser.' '.$student;
      db_query("INSERT INTO user_setting (`member_key`, `setting_key`) VALUES ('$student', '9')");
      $queryExistString=db_query ("SELECT `member_id` FROM practices WHERE `member_id` = '$student' AND `date_practic` = '$currentDate'");
      $rowExistString = $queryExistString->fetch_assoc();
      if (!$rowExistString['member_id']) {
        db_query("INSERT INTO practices (`date_create`, `member_id`, `date_practic`) VALUES (NOW(), '$student', '$currentDate')");
      }

      logFileWriter($student, 'ПРАКТИКИ. Пакетное подключение учёта практик для данного пользователя.', 'DEBUG');
    } else {
      logFileWriter($student, 'ПРАКТИКИ. Опция учёта практик для данного пользователя была подключена ранее.', 'DEBUG');
    }
  }

  if ($resultFoUser === ':') {
    $resultFoUser = 'У всех обучающихся ПВОМ включен учёт ежедневных практик.';
  } else {
    $resultFoUser = 'Опции включены для пользователей c ключами'.$resultFoUser;
  }
  return $resultFoUser;
}
// Roles of responsibles in contacts
function db_getResponsibleContacts1And2() {
    $res=db_query ("SELECT c.member_key, c.role, c.group_of_admin, m.name
      FROM contacts_resp AS c
      INNER JOIN member m ON m.key = c.member_key");

		$responsibles = array ();
		while ($row = $res->fetch_assoc()) $responsibles[]=$row;
		return $responsibles;
}

function db_getResponsibleContactsZero() {
    $res=db_query ("SELECT c.member_key, c.role, c.group_of_admin, m.name
    FROM contacts_resp AS c
    INNER JOIN member m ON m.key = c.member_key");

    $responsibles = [];
    while ($row = $res->fetch_assoc()) $responsibles[]=$row;

    $responsiblesZero = [];
    $responsiblesTemp = [];
    for ($i=0; $i < count($responsibles); $i++) {
      $temp = explode(',', $responsibles[$i]['group_of_admin']);
      for ($ii=0; $ii < count($temp); $ii++) {
        $tempKey = $temp[$ii];
        $res2=db_query ("SELECT `key`, `name` FROM member WHERE `key` = '$tempKey'");
        while ($row2 = $res2->fetch_assoc()) $responsiblesTemp[$row2['key']]=$row2['name'];
      }
      $responsiblesZero[$responsibles[$i]['name'].', роль '.$responsibles[$i]['role']] = $responsiblesTemp;
      $responsiblesTemp = [];
    }

		return $responsiblesZero;
}

function db_checkLostContacts($adminsFirstAndSecondRoles='') {
  $contacts =[];

  $responsiblesOneAndTwo = db_getResponsibleContacts1And2();
  $a = '(';
  $b = '(';
  $c = ' ';

  for ($i=0; $i < count($responsiblesOneAndTwo); $i++) {
    $value = $responsiblesOneAndTwo[$i]['member_key'];
    if ($a === '(') {
      $a.="`responsible` <> '".$value."'";
    } else {
      $a.=" and `responsible` <> '".$value."'";
    }
    if ($b === '(') {
      $b.="`responsible_previous` <> '".$value."'";
    } else {
      $b.=" and `responsible_previous` <> '".$value."'";
    }
  }
  /*
  foreach ($responsiblesOneAndTwo as $key => $value) {
    if ($a === '(') {
      $a."`responsible` <> '".$value->member_key."'";
    } else {
      $a." AND "."`responsible` <> '".$value->member_key."' ";
    }
    if ($b === '(') {
      $b."`responsible_previous` <> '".$value->member_key."'";
    } else {
      $b." AND "."`responsible_previous` <> '".$value->member_key."'";
    }
  }
  */
  if ($a !=='(') {
    $c = $a.") AND ".$b.")";
  }

  $res=db_query ("SELECT `id`, `name`, `notice` FROM `contacts` WHERE ".$c);
  while ($row = $res->fetch_assoc()) $contacts[]=$row['id'].' '.$row['name'].' '.$row['notice'];

  return $contacts;
}

function db_statusStatisticsContacts($from, $to) {
  $strs =[];

  $res=db_query ("SELECT * FROM `contacts_statistic` WHERE `date_changed` > '$from' AND `date_changed` < '$to'");
  while ($row = $res->fetch_assoc()) $strs[]=[$row['date_changed'], $row['status'], $row['id_contact']];

  return $strs;
}
// ПЕРЕДЕЛАТЬ СКРИПТ В SQL СКРИПТ
function db_deleteSameStrLogs() {
  $members = [];
  $res=db_query ("SELECT DISTINCT admin_key FROM activity_log");
  while ($row = $res->fetch_assoc()) $members[]=$row['admin_key'];
  $memberStrings = array();
  foreach ($members as $a){
    $res1=db_query ("SELECT * FROM activity_log WHERE `admin_key` = '$a'");
    while ($row1 = $res1->fetch_assoc()) $memberStrings[]=$row1;

      for ($i=0; $i < count($memberStrings); $i++) {
        if (count($memberStrings) - 1 !== $i) {
          $x = false;
          $x = $memberStrings[$i+1]['page'] === $memberStrings[$i]['page'];
          if ($x) {
            $date1 = new DateTime($memberStrings[$i+1]['time_create']);
            $date2 = new DateTime($memberStrings[$i]['time_create']);
            $diff = $date1->diff($date2);

            if ($diff->i < 24 && $diff->h === 0 && $diff->d === 0) {
              $z = $memberStrings[$i+1]['id'];
              db_query ("DELETE FROM activity_log WHERE `id` = '$z'");
            }
          }
        }
      }
    }
    //logFileWriter(false, 'АКТИВНОСТЬ АДМИНИСТРАТОРОВ. Автоматическое удаление близких по времени строк активности администраторов. Удалено '.$counter.' строк.', 'WARNING');
}

function dltStrLog99() {
  db_query ("DELETE FROM activity_log WHERE `admin_key` LIKE '99%'");
  //logFileWriter(false, 'АКТИВНОСТЬ АДМИНИСТРАТОРОВ. Автоматическое удаление строк 99 активности администраторов. Удаление завешено.', 'WARNING');
}

function dltStrLogDvlp() {
  db_query ("DELETE FROM activity_log WHERE `admin_key` = '000005716'");
  //logFileWriter(false, 'АКТИВНОСТЬ АДМИНИСТРАТОРОВ. Автоматическое удаление строк 99 активности администраторов. Удаление завешено.', 'WARNING');
}

// get requests
function db_getApplicationsPanel ($adminId, $trash=''){
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

function resetSemester(){

  // ftt_skip prepare
  $pathsToFiles = [];
  $res=db_query ("SELECT `file` FROM `ftt_skip`");
  while ($row = $res->fetch_assoc()) $pathsToFiles[]=$row['file'];

  foreach ($pathsToFiles as $paths) {
    if (empty($paths)) {
      continue;
    }
    $paths = explode(';', $paths);

    foreach ($paths as $file) {
      $root = __DIR__;
      $root = explode('panelsource', $root);
      if (file_exists($root[0].$file)) {
        unlink($root[0].$file);
      }
    }
  }

  $tables = array('ftt_announcement', 'ftt_announcement_recipients', 'ftt_attendance', 	'ftt_attendance_sheet', 'ftt_extra_help', 'ftt_gospel', 'ftt_gospel_members', 'ftt_gospel_goals', 'ftt_late', 'ftt_permission', 'ftt_permission_sheet', 'ftt_session', 'ftt_session_correction', 'ftt_trainee', 'ftt_skip', 'ftt_fellowship');
  $result;

  foreach ($tables as $value) {
    $result = db_query ("DELETE FROM {$value}");
  }

  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблиц ПВОМ удалены администратором. Результат: {$result}");
  return $result;
}

function resetApplications() {
// не удаляет фотографии с диска
  $tables = array('ftt_request');
  $result;

  foreach ($tables as $value) {
    $result = db_query ("DELETE FROM {$value}");
  }
  write_to_log::warning(db_getMemberIdBySessionId (session_id()), "Данные таблиц ПВОМ удалены администратором. Результат: {$result}");
  return $result;
}

function checkDataSemester() {
    $tables = array('ftt_announcement', 'ftt_announcement_recipients', 'ftt_attendance', 	'ftt_attendance_sheet', 'ftt_extra_help', 'ftt_gospel', 'ftt_gospel_members', 'ftt_gospel_goals', 'ftt_late', 'ftt_permission', 'ftt_permission_sheet', 'ftt_session', 'ftt_session_correction', 'ftt_trainee', 'ftt_skip', 'ftt_fellowship');
    $result = array();
    foreach ($tables as $key => $value) {
      $result[$value] = db_query ("SELECT * FROM {$value} limit 1");
    }
    //while ($row = $res->fetch_assoc()) $result[]=$row;
    return $result;
}

function checkOtherDataSemester() {
    $tables = array('ftt_serving_one', 'ftt_apartment', 'ftt_service', 'ftt_param', 'ftt_study_group', 'ftt_gospel_team');
    $result = array();
    foreach ($tables as $key => $value) {
      $result[$value] = db_query ("SELECT * FROM {$value} limit 1");
    }

    return $result;
}

function checkApplicationData(){
    $tables = array('ftt_request', 'ftt_request_points');
    $result = array();
    foreach ($tables as $key => $value) {
      $result[$value] = db_query ("SELECT * FROM {$value} limit 1");
    }

    return $result;
}
