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
  function arrdep($eventKey, $memberKey, $arrDate, $depDate,$arrTime, $depTime, $accom, $regstate, $memberComment)
  {
    $eventKey = db_real_escape_string($eventKey);
    $memberKey = db_real_escape_string($memberKey);
    $arrDate = db_real_escape_string($arrDate);
    $depDate = db_real_escape_string($depDate);
    $arrTime = db_real_escape_string($arrTime);
    $depTime = db_real_escape_string($depTime);
		$regstate = db_real_escape_string($regstate);
		$memberComment = db_real_escape_string($memberComment);
		$regstateUpdate = '';
		if ($regstate === '03' || $regstate === '05') {
			$regstateUpdate = " `regstate_key`='01', ";
		}

    $res = db_query("UPDATE `reg`
      SET `arr_date`='{$arrDate}', `dep_date`='{$depDate}', `arr_time`='{$arrTime}', `dep_time`='{$depTime}', `accom`='{$accom}', `comment`='{$memberComment}', {$regstateUpdate} `changed`='1'
      WHERE `event_key`='{$eventKey}' AND `member_key`='{$memberKey}'");
      return $res;
  }

  echo arrdep($_GET['event_key'], $_GET['member_key'], $_GET['arr_date'], $_GET['dep_date'] ,$_GET['arr_time'], $_GET['dep_time'], $_GET['accom'], $_GET['regstate'], $_GET['member_comment']);
  exit;
}
// запись состояния регистрации (например отмены)
if (isset($_GET['type']) && $_GET['type'] === 'regstate') {
  function set_reg_state($eventKey, $memberKey, $memberComment, $regKey)
  {
    $eventKey = db_real_escape_string($eventKey);
    $memberKey = db_real_escape_string($memberKey);
		$memberComment = db_real_escape_string($memberComment);
		$regKey = db_real_escape_string($regKey);

    $res = db_query("UPDATE `reg`
      SET `regstate_key`='{$regKey}', `comment`='{$memberComment}', `changed`='1'
      WHERE `event_key`='{$eventKey}' AND `member_key`='{$memberKey}'");
      return $res;
  }

  echo set_reg_state($_GET['event_key'], $_GET['member_key'], $_GET['member_comment'], $_GET['reg_state']);
  exit;
}
