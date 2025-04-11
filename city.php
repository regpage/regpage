<?php
/*** CRON ***/
include_once 'config.php';
require_once 'db/classes/emailing.php';
// Проверка целостности данных целостности данных
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
    $content = "Сообщение с сайта reg-page.ru.<br>Ошибка целостности данных.<br>" . date('m.d.Y H:i') . "<br>Для следующих участников отсутствует соответствующая местность в таблице locality<br>{$result}";
    $topic = 'Ошибка целостности данных на reg-page.ru';
    Emailing::send('zhichkinroman@gmail.com', $topic, $content);
    echo "\r\nНАРУШЕНИЕ целостности данных\r\nДля следующих участников отсутствует соответствующая местность в таблице locality\r\n{$result}\r\n";
  } else {
    echo "\r\nПроверка целостности данных — ОК";
  }
}

isLocalitiesExist();
