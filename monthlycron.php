<?php
// Автоматическое ежемесячное удаление мусора из контактов. Выполняется по заданию (cron)
include_once 'db.php';
include_once 'logWriter.php';

function db_deleteTrashFromContacts(){
  $counter = [];

  $res = db_query ("SELECT `id` FROM `contacts`  WHERE `notice` = 2 AND (DATEDIFF(CURRENT_DATE, STR_TO_DATE(sending_date, '%Y-%m-%d'))/31) > 1");
  while ($row = $res->fetch_assoc()) $counter[]=$row['id'];

  $count = count($counter);

  if ($count > 0) {
    foreach ($counter as $key => $value) {
      db_query("DELETE FROM contacts WHERE `id`='$value'");
      db_query("DELETE FROM chat WHERE `group_id`='$value'");
    }
      //db_query ("DELETE FROM `contacts` WHERE `notice` = 2 AND (DATEDIFF(CURRENT_DATE, STR_TO_DATE(sending_date, '%Y-%m-%d'))/31) > 1");
    logFileWriter(false, 'УДАЛЕНИЕ КОНТАКТОВ ИЗ КОРЗИНЫ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Удалено '.$counter.' контактов из корзины.', 'WARNING');
  } else {
    logFileWriter(false, 'УДАЛЕНИЕ КОНТАКТОВ ИЗ КОРЗИНЫ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Контакты в корзине отсутствуют.', 'WARNING');
  }

  // отметка о выполнении скрипта крона
  $faleName = $_SERVER['PHP_SELF'];
  db_query("INSERT INTO `cron` (`date`,`script`, `status`, `comment`) VALUES (CURRENT_DATE(),'{$faleName}', '1', '')");

  // вывод ответа
  echo "УДАЛЕНИЕ {$count} КОНТАКТОВ ИЗ КОРЗИНЫ - ОК";
}

//DATEDIFF(CURRENT_DATE, STR_TO_DATE(m.birth_date, '%Y-%m-%d'))/365
db_deleteTrashFromContacts();
