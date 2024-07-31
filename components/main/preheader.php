<?php
/*
* настройки
* безопасность
* подключения
* авторизация
* доступы
* текстовый блок
*/
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

/* безопасность */
// защита от нежелательных запросов
if (!isset($_COOKIE['PHPSESSID']) && !isset($_SERVER['HTTP_USER_AGENT'])) {
  exit;
}

/* подключения */
// лог
require_once 'extensions/write_to_log/write_to_log.php';
// подключение необходимых функций и конфигов
require_once "config.php";
// аутификация
require_once "db/classes/common/db_query.php";
// аутификация
require_once "db/classes/auth/auth.php";
// доступы
require_once "db/classes/access.php";
// данные админа
require_once "db/classes/admin_data.php";
// дополнительный текстовый блок
require_once "db/classes/common/textblock.php";

// путь, переменная из config.php
global $appRootPath;
define("APP_ROOT_PATH", $appRootPath);
/* авторизация на сайте */
// получаем админа по сессии
$memberId = Auth::get_member_key_by_session(session_id());
define("MEMBER_ID", $memberId);

// сохраняем дату текущего визита при условии, что после предыдущего визита прошло 12 часов и более
if (!isset($_COOKIE['l_v_today']) && MEMBER_ID) {
  setcookie("l_v_today", 1, time() + 43200);  // куки живёт 12 часов
}

/* ПРАВИЛА ДЛЯ ДОСТУПА К РАЗДЕЛАМ */
define("IS_ZONE_ADMIN", Access::isZoneAdmin(MEMBER_ID));
// получаем имя скрипта из запроса
define("THIS_PAGE", explode('.', substr($_SERVER['PHP_SELF'], 1))[0]);

// Добавляем запись в лог посещаемости
//MEMBER_ID && THIS_PAGE != 'archive' ? db_activityLogInsert(MEMBER_ID, THIS_PAGE) : '';

// это раздел ПВОМ?
define("IS_FTT_PAGE", Access::isFttPage());

// разбор адресов Custom page. Если название страницы состоит из двух символов типа '/bt'
// Названия разделов из двух символов не допустимы, такие названия используются для специальных страниц
if (strlen($_SERVER['REQUEST_URI']) == 3) {
  // СДЕЛАТЬ ПОДОБНЫЕ КЛАССЫ НА БАЗЕ КЛАССА С ПОДОБНЫМ ЗАПРОСАМ
  require_once "db/classes/common/custom_page.php";
  require_once "components/main/custom_page.php";
  exit;
}

// переадресация на страницу авторизации если пользователь не админ, а запрашиваемая страница для зарегистрированых пользователей
if (!MEMBER_ID && preg_match("/(login.php)|(signup.php)|(passrec.php)/", $_SERVER["SCRIPT_NAME"])==0){
    header("Location: ".APP_ROOT_PATH."login?returl=".urlencode ($_SERVER["REQUEST_URI"]));
  	exit;
}

// получаем данные администратора
$admin_data = get_admin_data::data(MEMBER_ID);

//  П В О М
// правила отображения разделов для обучающихся
$ftt_access = get_admin_data::ftt(MEMBER_ID);

// переадресация на главную обучающихся с перечисленных в коде разделов на главную.
if ($ftt_access !== 'denied') {
  if ($ftt_access['group'] === 'trainee' && (THIS_PAGE === 'meetings' || THIS_PAGE === 'reg' || THIS_PAGE === 'members')) {
    header("Location: ".APP_ROOT_PATH);
    exit;
  }
} elseif ($ftt_access === 'denied' && IS_FTT_PAGE) {
  header("Location: ".APP_ROOT_PATH);
  exit;
}

// переадресация на главную если пользователь админ, но не админ мероприятия и него нет зон, а запрашиваемая страница не существует или её нет в списке в данном условии
if (MEMBER_ID && count(Access::getAdminEventsRespForReg(MEMBER_ID)) == 0 && !IS_ZONE_ADMIN && preg_match("/(index.php)|(signup.php)|(passrec.php)|(login.php)|(ftt_application.php)|(ftt_list.php)|(ftt_schedule.php)|(ftt_absence.php)|(ftt_announcement.php)|(ftt_extrahelp.php)|(ftt_attendance.php)|(ftt_gospel.php)|(ftt_service.php)|(application.php)|(contacts.php)|(profile.php)|(settings.php)|(meetings.php)|(opros.php)|(attend.php)|(ftt_fellowship.php)|(ftt_reading.php)|(ftt_settings.php)|(vtraining.php)|(ch_statistic.php)/", $_SERVER["SCRIPT_NAME"])==0){ //|(links.php)|(practices.php)
    header("Location: ".APP_ROOT_PATH);
  	exit;
}
/* доп. текст блок */
// печать доп. текстового блока при необходимости
TextBlock::get_block();
