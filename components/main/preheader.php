<?php
/* настройки */
header('Content-Type: text/html; charset=utf-8');
// отображение ошибок и предупреждений в браузере
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

/* API */
// BFA подписка --> контакты.
if (isset($_GET['method']) && $_GET['method'] === 'contacts.add_member' && $_GET['api_key'] === 'f3db58b7cb4baa82ea5321d08b6f0ff9') {
  require_once 'api_v1.php';
  exit;
}

/* переадресации */
// Redirect to service page
// header("Location: /attention.html");

// настройки кукки
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365);  // 365 дней время жизни кукки

// старт сессии
session_start();

// security
if (!isset($_COOKIE['PHPSESSID']) && !isset($_SERVER['HTTP_USER_AGENT'])) {
  exit;
}

// лог
include_once 'extensions/write_to_log/write_to_log.php';
// подключение необходимых функций и конфигов
include_once "config.php";
// аутификация
include_once "db/classes/common/db_query.php";
// аутификация
include_once "db/classes/auth/auth.php";
// доступы
include_once "db/classes/access.php";
// данные админа
include_once "db/classes/admin_data.php";
// дополнительный текстовый блок
include_once "db/classes/common/textblock.php";

/* пути */
// переменная из config.php
global $appRootPath;

/* авторизация на сайте */
// получаем админа по сессии
$memberId = Auth::get_member_key_by_session(session_id());

// сохраняем дату текущего визита при условии, что после предыдущего визита прошло 12 часов и более
if (!isset($_COOKIE['l_v_today']) && $memberId) {
  setcookie("l_v_today", 1, time() + 43200);  // куки живёт 12 часов
}

// получаем имя скрипта из запроса
$thispage = explode('.', substr($_SERVER['PHP_SELF'], 1))[0];

// Добавляем запись в лог посещаемости
//$memberId && $thispage != 'archive' ? db_activityLogInsert($memberId, $thispage) : '';

/* ПРАВИЛА ДЛЯ ДОСТУПА К РАЗДЕЛАМ */
// это раздел ПВОМ?
$isFttPage = explode('_', $_SERVER['PHP_SELF'])[0];

if ($isFttPage === '/ftt') {
  $isFttPage = true;
} else {
  $isFttPage = false;
}

define("IS_FTT", $isFttPage);

/* разбор адресов */
// Custom page. Если название страницы состоит из двух символов типа '/bt'
// Названия разделов из двух символов не допустимы, такие названия используются для специальных страниц
if (strlen($_SERVER['REQUEST_URI']) == 3) {
  // СДЕЛАТЬ ПОДОБНЫЕ КЛАССЫ НА БАЗЕ КЛАССА С ПОДОБНЫМ ЗАПРОСАМ
  include_once "db/classes/common/custom_page.php";
  include_once "components/main/custom_page.php";
  exit;
}

// переадресация если пользователь не админ, а запрашиваемая страница для зарегистрированых пользователей
if (!$memberId && preg_match("/(login.php)|(signup.php)|(passrec.php)/", $_SERVER["SCRIPT_NAME"])==0){
    header("Location: ".$appRootPath."login?returl=".urlencode ($_SERVER["REQUEST_URI"]));
  	exit;
}

// получаем данные администратора
$admin_data = get_admin_data::data($memberId);

/*  П В О М  */
// правила отображения разделов для обучающихся
$ftt_access = get_admin_data::ftt($memberId);

// переадресация обучающихся с перечисленных в коде разделов на главную.
if ($ftt_access !== 'denied') {
  if ($ftt_access['group'] === 'trainee' && ($thispage === 'meetings' || $thispage === 'reg' || $thispage === 'members')) {
    header("Location: ".$appRootPath);
    exit;
  }
} elseif ($ftt_access === 'denied' && IS_FTT) {
  header("Location: ".$appRootPath);
  exit;
}

// переадресация если пользователь админ, а страница не существует или её нет в списке в данном условии
if ($memberId && count(Access::getAdminEventsRespForReg($memberId)) == 0 && !Access::isAdmin($memberId) && preg_match("/(index.php)|(signup.php)|(passrec.php)|(login.php)|(ftt_application.php)|(ftt_list.php)|(ftt_schedule.php)|(ftt_absence.php)|(ftt_announcement.php)|(ftt_extrahelp.php)|(ftt_attendance.php)|(ftt_gospel.php)|(ftt_service.php)|(application.php)|(practices.php)|(contacts.php)|(profile.php)|(settings.php)|(meetings.php)|(opros.php)|(attend.php)|(ftt_fellowship.php)|(ftt_reading.php)|(ftt_settings.php)|(vtraining.php)|(ch_statistic.php)/", $_SERVER["SCRIPT_NAME"])==0){ //|(links.php)
    header("Location: ".$appRootPath);
  	exit;
}

// печать доп. текстового блока при необходимости
TextBlock::get_block();
echo "STOP";
exit;
