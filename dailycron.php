<?php
// право доступа
require_once 'cronkey.php';

// Выполняется по заданию (cron)
// Автоматическое проверка учёта практик (practices) ОТКЛЮЧЕНО
// Автоматическое удаление старых практик ОТКЛЮЧЕНО
// Проверка и удаление временных и просроченных сессий
// Добавление записей на общение из шаблонов
// строку ниже заменить на config.php
include_once 'db.php';
include_once 'logWriter.php';
include_once 'db/classes/ftt_info.php';
require_once 'db/classes/emailing.php';

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
  // Проверяем что расписание не выходит за период обучения
  // ИНТЕРВАЛ ДАТ ДОЛЖЕН БЫТЬ = ДАТА СТАРТА РАСПИСАНИЯ - 7 ДНЕЙ И ДАТА завершения РАСПИСАНИЯ - 14 ДНЕЙ
  if (ftt_info::pauseForFellowship()) {
    // отметка о выполнении
    $faleName = $_SERVER['PHP_SELF'];
    db_query("INSERT INTO `cron` (`date`,`script`, `status`, `comment`) VALUES (CURRENT_DATE(),'{$faleName}', '1', 'Вне периода')");
    echo "Вне периода проведения обучения. ";
    return;
  }

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
  // Получить список служащих у которых перерыв на данный момент Учитывать NULL в дате или запрашивать инфо о паузе при переборе.
  $servingonesOnPause = [];
  $pause = db_query ("SELECT `member_key` FROM `ftt_serving_one` WHERE (`pause_start` IS NOT NULL AND `pause_stop` IS NOT NULL AND `pause_start` <= CURDATE() AND `pause_stop` >= CURDATE()) OR (`pause_start` IS NOT NULL AND `pause_stop` IS NULL AND `pause_start` <= CURDATE())");
  while ($row = $pause->fetch_assoc()) $servingonesOnPause[] = $row['member_key'];

  $servingonesOnPauseCondition = '';
  if (count($servingonesOnPause) > 0) {
    $servingonesOnPauseCondition = 'AND `serving_one` NOT IN (';
    foreach ($servingonesOnPause as $key => $value) {
      if ($key > 0) {
        $servingonesOnPauseCondition .= ",'{$value}'";
      } else {
        $servingonesOnPauseCondition .= "'{$value}'";
      }
    }
    $servingonesOnPauseCondition .= ')';
  }
  $res = db_query ("SELECT * FROM `ftt_fellowship_tmpl` WHERE `day` = '$dayOfWeek' {$servingonesOnPauseCondition}");
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

// Проверка целостности данных
// отсутстствие местности в таблице locality на котороую ссылается таблица member
function isLocalitiesExist()
{
  $result = '';
  $res = db_query("SELECT `key`, `name`, `locality_key`
    FROM `member`
    WHERE `locality_key` NOT IN (
    SELECT `key`
    FROM `locality`)
    ");
  while ($row = $res->fetch_assoc()) $result .= $row['key'] . ' ' . $row['name'] . ' ' . $row['locality_key'] . '<br>';

  if (!empty($result)) {
    $content = "Сообщение с сайта reg-page.ru.<br>Ошибка целостности данных.<br>" . date('m.d.Y H:i') . "Для следующих участников отсутствует соответствующая местность в таблице locality<br>{$result}";
    $topic = 'Ошибка целостности данных на reg-page.ru';
    Emailing::send('zhichkinroman@gmail.com', $topic, $content);
    echo " \r\nНАРУШЕНИЕ целостности данных\r\nДля следующих участников отсутствует соответствующая местность в таблице locality\r\n{$result}\r\n";
  } else {
    echo " \r\nПроверка целостности данных — ОК";
  }
}

isLocalitiesExist();

// добавляем расписание в управление электронной доской функция
require_once 'db/classes/ftt_param.php';
require_once 'db/classes/schedule_class.php';
function addTodayScheduleToInfoboard()
{
  $dayN = 'day' . date('N');
  $dateToday = date('Y-m-d');
  // расписание 1-4 семестра сегодня
  $result = schedule_class::get(1, '02', date('Y-m-d'), $dayN);
  // Обработка полученных данных и формирование расписания
  $scheduleHTML = '';

  foreach ($result as $key => $value) {
      if ($value[$dayN]) {
        // продолжительность, время окончания мероприятия
        $finishTime = '';
        if ($value['duration'] && $value['duration'] !== '0') {
          $finishTime = '-' . (new DateTime($dateToday . ' ' . $value[$dayN] . ':00'))->modify("+{$value['duration']} minutes")->format('H:i');
        }
         $scheduleHTML .= '<div>' . $value[$dayN] . $finishTime . ' — ' . $value['session_name'] . "</div>";
      }
  }

  $res = db_query("UPDATE `ftt_infoboard` SET `text` = '{$scheduleHTML}' WHERE `type`='schedule'");
  if ($res) {
    echo " /r/n Добавлено текущее расписание в Управление электронной доской";
  } else {
    echo " /r/n НЕ Добавлено текущее расписание в Управление электронной доской";
  }
}
// добавляем расписание в управление электронной доской Вызов
addTodayScheduleToInfoboard();

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
