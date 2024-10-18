<?php
// Задаём хедер, настройки и запускаем сессию.
header("Content-Type: application/json; charset=utf-8");
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365);  // 365 day cookie lifetime
session_start();
// API для ajax(JS) запросов из браузера
// Подключаем БД.
require_once "../../config.php";
// Подключаем ведение лога
include_once "../../extensions/write_to_log/write_to_log.php";
// Добавляем свои функции для обработчиков.
function exception_handler($exception) {
	header("http/1.0 500 Internal server error");
	echo $exception->getMessage();
	exit;
}

function error_handler ($errno, $errstr, $errfile, $errline) {
    header("http/1.0 500 Internal server error");
    echo "$errno: ".$errstr;
    exit;
}

// Присываиваем функции для обработчикам.
set_exception_handler('exception_handler');
set_error_handler('error_handler');

if (isset($_GET['type']) && $_GET['type'] === 'arrdep') {
  function arrdep($eventKey, $memberKey, $arrDate, $depDate,$arrTime, $depTime, $memberComment)
  {
    $eventKey = db_real_escape_string($eventKey);
    $memberKey = db_real_escape_string($memberKey);
    $arrDate = db_real_escape_string($arrDate);
    $depDate = db_real_escape_string($depDate);
    $arrTime = db_real_escape_string($arrTime);
    $depTime = db_real_escape_string($depTime);
		$memberComment = db_real_escape_string($memberComment);

    $res = db_query("UPDATE `reg`
      SET `arr_date`='{$arrDate}', `dep_date`='{$depDate}', `arr_time`='{$arrTime}', `dep_time`='{$depTime}', `comment`='{$memberComment}'
      WHERE `event_key`='{$eventKey}' AND `member_key`='{$memberKey}'");
      return $res;
  }

  echo arrdep($_GET['event_key'], $_GET['member_key'], $_GET['arr_date'], $_GET['dep_date'] ,$_GET['arr_time'], $_GET['dep_time'], $_GET['member_comment']);
  exit;
}
