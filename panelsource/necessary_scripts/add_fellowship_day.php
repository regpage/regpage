<?php
// ОБЩЕНИЕ СОЗДАНИЕ ЗАПИСЕЙ ИЗ РАСПИСАНИЯ
function cron_set_fellowship_str() {
  // Проверяем что расписание не выходит за период обучения
  /*if (ftt_info::pause()) {
    // отметка о выполнении
    $faleName = $_SERVER['PHP_SELF'];
    db_query("INSERT INTO `cron` (`date`,`script`, `status`, `comment`) VALUES (CURRENT_DATE(),'{$faleName}', '1', 'Вне периода')");
    echo "Вне периода проведения обучения";
    exit();
  }*/

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
