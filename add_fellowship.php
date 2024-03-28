<?php
// === Функция ручного добавление записей Общения на две недели вперёд === //

include_once 'config.php';
include_once 'logWriter.php';

echo "Функция ручного добавление записей Общения на две недели вперёд ОТКЛЮЧЕНА.";
exit();

//-------------------------------------//
// ОБЩЕНИЕ СОЗДАНИЕ ЗАПИСЕЙ ИЗ РАСПИСАНИЯ
function cron_set_fellowship_str() {
  $dayNumber = date("N", strtotime("+2 week"));
  $dayOfWeek = '';
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
  $daysOfWeek = ['пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'вс'];
  if ($dayNumber === 7) {
    $start = 0;
  } else {
    $start = $dayNumber;
  }

  for ($period = 1; $period <= 14; $period++) {
    $result = [];
    $res = db_query ("SELECT *
      FROM `ftt_fellowship_tmpl`
      WHERE `day` = '{$daysOfWeek[$start]}' AND (`serving_one`='000010532' OR `serving_one`='000010642' OR `serving_one`='000009703' OR `serving_one`='000007096' OR `serving_one`='000003195' OR `serving_one`='000002097' OR `serving_one`='000002634')");
    while ($row = $res->fetch_assoc()) $result[] = $row;

    if (count($result) > 0) {
      foreach ($result as $key => $value) {
        $res = db_query ("INSERT INTO `ftt_fellowship` (`serving_one`, `date`, `time`, `duration`) VALUES ('{$value['serving_one']}', (CURDATE() + INTERVAL {$period} DAY) , '{$value['time']}', '{$value['duration']}')");
      }
      echo "Добавлены строки в расписание общения из шаблона.<br>";
    } else {
      echo "Не добавлены строки в расписание общения из шаблона.<br>";
    }
    // счётчик дней недели
    if (++$start === 7) {
      $start = 0;
    }
    unset($result);
  }
  return true;
}

// результат
if (cron_set_fellowship_str()) {
  echo '<a href="ftt_fellowship">Закончить<a>';
}
// СТОП ОБЩЕНИЕ СОЗДАНИЕ ЗАПИСЕЙ ИЗ РАСПИСАНИЯ

//------------------------------------------//
