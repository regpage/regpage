<?php
include_once 'config.php';
include_once 'db/classes/date_convert.php';
require_once 'db/classes/emailing.php';

// **** ЕЖЕДНЕВНЫЙ КРОН dailyattendance.php ****//

// sanitize string
/*function sanitizeString($var) {
  //$var = strip_tags($var);
  //$var = htmlentities($var);
  return stripslashes($var);
}
*/
// Проверка крона добавления листов посещаемости
$currentDate = date("Y-m-d");
$answers = '';
$scripts = array(
  'dailyattendance.php' => '*',
  'dailycron.php' => '*',
  'ftt_emailing_list.php' => '*',
  'weeklyattendance.php' => '*',
  'ftt_emailing_gospel.php' => 'w3',
  'weekly_ftt.php' => 'w0',
  'monthlycron.php' => 'd1',
  'cronsemester.php' => 'm1d20',
  'cronsemester.php' => 'm6d20'
);

// проверяем выполнение кронов
foreach ($scripts as $key => $value) {
  // добавить не ежедневные скрипты $value
  if (parsing_date($value)) {
    $answers .= checkCron($key, $currentDate);
  }
}

// правила для дней выполнения крон
function parsing_date($date) {
  // каждый день
  if ($date === '*') {
    return true;
  } elseif (isset($date[0]) && isset($date[1]) && $date[0] === 'w' && intval($date[1]) === intval(date('w'))) { // дни недели
    return true;
  } elseif (isset($date[0]) && isset($date[1]) && $date[0] === 'd') { // дени месяца
    $dayTemp = $date[1];
    if (isset($date[2])) {
      $dayTemp .= $date[2];
    }
    if (intval($dayTemp) == intval(date('d'))) {
      return true;
    }
  } elseif (isset($date[0]) && isset($date[1]) && $date[0] === 'm') { // месяц и день месяца
    $monthTemp = $date[1];
    $modificator = 0;
    if (isset($date[2]) && is_numeric($date[2])) {
      $monthTemp .= $date[2];
      $modificator = 1;
    }

    $dayTemp = $date[2+$modificator];
    if (isset($date[3+$modificator])) {
      $dayTemp .= $date[3+$modificator];
    }
    if (intval($monthTemp) === intval(date('m')) && intval($dayTemp) === intval(date('d'))) {
      return true;
    }
  }
  return false;
}

// проверка крона
function checkCron($script, $date) {
  // sanitize string
  //sanitizeString($path)

  $result = '';
  $answer = '';
  $dateRuFormat = date_convert::yyyymmdd_to_ddmmyyyy($date);
  $path = '/home/regpager/domains/reg-page.ru/public_html/' . trim($script);

  $res=db_query ("SELECT `date` FROM `cron` WHERE `date` = '{$date}' AND `script` = '{$path}'");
  while ($rows = $res->fetch_assoc()) $result=$rows['date'];

  if (empty($result)) {
    $content = "Сообщение с сайта reg-page.ru.<br>Ошибка CRON. Нет данных на {$dateRuFormat} о выполнении ежедневного CRON {$script}.<br>";
    $topic = 'Ошибка CRON reg-page.ru';
    Emailing::send('zhichkinroman@gmail.com', $topic, $content);
    Emailing::send('a.rudanok@gmail.com', $topic, $content);
    //Emailing::send_by_key($value, $topic, $content);
    $answer = "Внимание! Проблема на {$dateRuFormat} с {$script} CRON\r\n";
  } else {
    $answer = "{$date} {$script} CRON is OK\r\n";
  }
  return $answer;
}

echo $answers;
