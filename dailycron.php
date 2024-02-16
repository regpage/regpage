<?php
// Выполняется по заданию (cron)
// Автоматическое проверка учёта практик (practices)
// Автоматическое удаление старых практик
// Проверка и удаление временных и просроченных сессий
// строку ниже заменить на config.php
include_once 'db.php';
include_once 'logWriter.php';

// ADMINS SESSIONS
function db_checkDeleteTempAdminSessions() {
    $counter = 0;
    $res = db_query ("SELECT `admin_key` FROM `admin_session` WHERE `admin_key` LIKE '990%'");
    while ($row = $res->fetch_assoc()) $counter++;

    if ($counter > 0) {
      db_query ("DELETE FROM `admin_session` WHERE `admin_key` LIKE '990%'");

      logFileWriter(false, 'СЕССИИ АДМИНИСТРАТОРОВ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Удалено '.$counter.' временных сессий.', 'WARNING');
    } else {
      logFileWriter(false, 'СЕССИИ АДМИНИСТРАТОРОВ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Временные сессии отсутствуют.', 'WARNING');
    }
  }

db_checkDeleteTempAdminSessions();

function db_checkDeleteOldAdminSessions() {
  $counter = 0;
  $res = db_query ("SELECT `admin_key` FROM `admin_session`  WHERE `time_last_visit` < DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL -12 MONTH)");
  while ($row = $res->fetch_assoc()) $counter++;

  if ($counter > 0) {
    logFileWriter(false, 'СЕССИИ АДМИНИСТРАТОРОВ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Удалено '.$counter.' просроченных сессий.', 'WARNING');
    db_query ("DELETE FROM `admin_session` WHERE `time_last_visit` < DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL -12 MONTH)");
  } else {
    logFileWriter(false, 'СЕССИИ АДМИНИСТРАТОРОВ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Просроченные сессии отсутствуют.', 'WARNING');
  }
}

db_checkDeleteOldAdminSessions();
// STOP ADMINS SESSIONS

//-------------------------------------//
// ОБЩЕНИЕ СОЗДАНИЕ ЗАПИСЕЙ ИЗ РАСПИСАНИЯ
function cron_set_fellowship_str() {
  $dayNumber = date("N", strtotime("+2 week"));
  $dayOfWeek = '';
  $result = [];
  switch ($dayNumber) {
    case 1:
      $dayOfWeek = 'пн';
      break;
    case 2:
      $dayOfWeek = 'вт';
      break;
    case 3:
      $dayOfWeek = 'ср';
      break;
    case 4:
      $dayOfWeek = 'чт';
      break;
    case 5:
      $dayOfWeek = 'пт';
      break;
    case 6:
      $dayOfWeek = 'сб';
      break;
    case 7:
      $dayOfWeek = 'вс';
    break;
    default:
      $dayOfWeek = '';
      break;
  }

  $res = db_query ("SELECT * FROM `ftt_fellowship_tmpl` WHERE `day` = '$dayOfWeek'");
  while ($row = $res->fetch_assoc()) $result[] = $row;

  if (count($result) > 0) {
    foreach ($result as $key => $value) {
      $res = db_query ("INSERT INTO `ftt_fellowship` (`serving_one`, `date`, `time`, `duration`) VALUES ('{$value['serving_one']}', (CURDATE() + INTERVAL 14 DAY) , '{$value['time']}', '{$value['duration']}')");
    }
    return true;
  } else {
    return false;
  }
}
if (cron_set_fellowship_str()) {
  echo "Добавлены строки в расписание общения из шаблона.";
} else {
  echo "Не добавлены строки в расписание общения из шаблона.";
}

// СТОП ОБЩЕНИЕ СОЗДАНИЕ ЗАПИСЕЙ ИЗ РАСПИСАНИЯ

//------------------------------------------//
// *** О Т К Л Ю Ч Е Н О ! *** //
// PRACTICES
function db_stopDailyPractices(){
  logFileWriter(false, 'ПРАКТИКИ. Автоматическая проверка учёта практик.', 'WARNING');
  $practicesMemberKeys=[];
// get keys of members
  $res=db_query ("SELECT `member_key` FROM user_setting WHERE `setting_key` = '9'");
  while ($row = $res->fetch_assoc()) $practicesMemberKeys[]=$row['member_key'];

  foreach ($practicesMemberKeys as $i){
    $resultat= array();
// get the not filled strings for members by the key
    $res2=db_query ("SELECT * FROM `practices`
      WHERE `member_id`='$i' AND `date_practic`>DATE_ADD(CURRENT_DATE(),INTERVAL -8 DAY) AND `m_revival`=0 AND `p_pray`=0 AND  `co_pray`=0 AND `r_bible`=0 AND `r_ministry`=0 AND `evangel`=0 AND `flyers`=0 AND `contacts`=0 AND
      `saved`=0 AND `meetings`=0 AND ISNULL(`wakeup`) AND ISNULL(`hangup`) AND `other`=''");
    while ($rows2 = $res2->fetch_assoc()) $resultat[]=$rows2;

// get the not filled strings for members by the key
    if (count($resultat) === 8) {
      $keyOfMember = $resultat[0]['member_id'];
      logFileWriter($resultat[0]['member_id'], 'ПРАКТИКИ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Для данного пользователя автоматически отключен учёт практик.', 'WARNING');
      db_query ("DELETE FROM `user_setting` WHERE `member_key`='$keyOfMember' AND `setting_key`=9");
      echo $keyOfMember.' has been disabled';
    }
  }
}

// db_stopDailyPractices();

function db_deleteOldDailyPractices() {
  $counter = 0;
  $res = db_query ("SELECT `member_id` FROM `practices` WHERE `date_practic` < DATE_ADD(CURRENT_DATE(), INTERVAL -5 MONTH)");
  while ($row = $res->fetch_assoc()) $counter++;

  if ($counter > 0) {
    db_query ("DELETE FROM `practices` WHERE `date_practic` < DATE_ADD(CURRENT_DATE(), INTERVAL -5 MONTH)");
    logFileWriter(false, 'ПРАКТИКИ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Удалено '.$counter.' строк старых практик.', 'WARNING');
  } else {
    logFileWriter(false, 'ПРАКТИКИ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Старые строки учёта практик отсутствуют.', 'WARNING');
  }
}

// db_deleteOldDailyPractices();

function db_checkDeleteOldAdminActivity() {
  $counter = 0;
  $res = db_query ("SELECT `admin_key` FROM `activity_log`  WHERE `time_create` < DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL -3 MONTH)");
  while ($row = $res->fetch_assoc()) $counter++;

  if ($counter > 0) {
    logFileWriter(false, 'АКТИВНОСТЬ АДМИНИСТРАТОРОВ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Удалено '.$counter.' просроченных строк активности администраторов.', 'WARNING');
    db_query ("DELETE FROM `activity_log`  WHERE `time_create` < DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL -3 MONTH)");
  } else {
    logFileWriter(false, 'АКТИВНОСТЬ АДМИНИСТРАТОРОВ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Просроченные строки активности администраторов отсутствуют.', 'WARNING');
  }
}

//db_checkDeleteOldAdminActivity();

// отметка о выполнении
$faleName = $_SERVER['PHP_SELF'];
db_query("INSERT INTO `cron` (`date`,`script`, `status`, `comment`) VALUES (CURRENT_DATE(),'{$faleName}', '1', '')");
