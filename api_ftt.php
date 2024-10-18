<?php
// Этот заголовок должен быть общим для айаксов
// Задаём хедер, настройки и запускаем сессию.
header("Content-Type: application/json; charset=utf-8");
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365);  // 365 day cookie lifetime
session_start();
// API для ajax(JS) запросов из браузера
// Подключаем БД.
require_once "config.php";
// Подключаем систему аутификации.
require_once 'db/classes/auth/auth.php';
// Подключаем ведение лога
include_once "extensions/write_to_log/write_to_log.php";
// Получаем админа по сессии.
$adminId = Auth::get_member_key_by_session(session_id());
// Проверка аутификации. Если пользователь не аутифицирован по сессии, то останавливаем выполнение скрипта.
if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

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

// Запрос содержит имя раздела? Иначе останавливаем выполнение скрипта.
if (isset($_GET['section']) && !empty($_GET['section'])) {
  $section = $_GET['section'];
}  else {
  exit;
}

// Подключаем соответствующий файл для раздела.
$error = '';
switch ($section) {
  case 'service':
    //require_once 'ajax/ftt_service_ajax.php';
    break;
  case 'fellowship':
    require_once 'ajax/ftt_fellowship_extra_ajax.php';
    break;
  default:
    $error = 'No section exist.';
    break;
}

// если для переданного раздела не обнаружено соответствий
if (isset($error) && !empty($error)) {
  echo $error;
  exit();
}
