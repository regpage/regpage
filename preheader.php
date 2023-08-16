<?php
/* настройки */
header('Content-Type: text/html; charset=utf-8');

/* API */
// BFA подписка --> контакты.
if (isset($_GET['method']) && $_GET['method'] === 'contacts.add_member' && $_GET['api_key'] === 'f3db58b7cb4baa82ea5321d08b6f0ff9') {
  require_once 'api_v1.php';
  exit;
}
/* переадресации */
// Redirect to service page like SORRY THE WEBSIE NOT AVAILABLE........
// header("Location: /attention.html"); // redirect to service page
// нет необходимости подключать библиотеки майлера и некоторые утилиты подключаемые в db.php в новых разделах

// START COOKIES
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365);  // 365 day cookie lifetime
// STOP COOKIES
session_start();

// logs
include_once 'extensions/write_to_log/write_to_log.php';
// подключение необходимых функций и конфигов
include_once "db.php";
// if (!isset($isGuest)) { // лишнее условие, эта переменная выше не объявляется.
/* авторизация на сайте */
// получаем админа по сессии
$memberId = db_getMemberIdBySessionId (session_id());

// security
if (!isset($_COOKIE['PHPSESSID']) && !isset($_SERVER['HTTP_USER_AGENT'])) {
  //write_to_log::debug($memberId, session_id());
  //write_to_log::debug($memberId, 'PHPSESSID & HTTP_USER_AGENT missing');
  exit;
}

// можно записать сессию в кукки и если сессия была сегодня то пропускать обращение к бд для записи даты последнего визита
$memberId ? db_lastVisitTimeUpdate(session_id()) : '';
/* пути */
// переменная из config.php
global $appRootPath;
$global_root_path = __DIR__.DIRECTORY_SEPARATOR;
$thispage = explode('.', substr($_SERVER['PHP_SELF'], 1))[0];

// Добавляем запись в лог посещаемости
//$memberId && $thispage != 'archive' ? db_activityLogInsert($memberId, $thispage) : '';

/* ПРАВИЛА ДЛЯ ДОСТУПА К РАЗДЕЛАМ */
/* ВСЕ ПРАВИЛА ДОСТУПА ДОЛЖНЫ БЫТЬ ПЕРЕНЕСЕНЫ СЮДА */
// это раздел ПВОМ?
$isFttPage = explode('_', $_SERVER['PHP_SELF'])[0];

if ($isFttPage === '/ftt') {
  $isFttPage = true;
} else {
  $isFttPage = false;
}

define("IS_FTT", $isFttPage);

// Бланки по ссылке. Эта проверка перенесена в index.php
/* if ((!$memberId && isset ($_GET["link"])) || (!$memberId && isset ($_GET["invited"]))){
} else*/
// Custom page. Если название страницы состоит из двух символов типа '/bt'
/* разбор адресов */
if(strlen($_SERVER['REQUEST_URI']) == 3){
    // Названия разделов из двух символов не допустимы, так как два символа используются для специальных страниц
      // determine a special page
      $specPage = NULL;
      foreach (db_getSpecPages() as $sp){
          if (isset ($_GET[$sp])){
              $specPage = $sp;
              break;
          }
      }

      if ($specPage){
          include 'header.php';
          include 'nav.php';
          include 'modals.php';

          echo '<div class="container"><div style="background-color: white; padding: 20px;">';
          echo db_getCustomPage($specPage);
          echo'</div>';
          include 'footer.php';
      } else {?>
        <script>
          window.location.href = '/isnotfound.html';
        </script>
        <?php
        #header("Location: ".$appRootPath."login?returl=".urlencode ($_SERVER["REQUEST_URI"]));
      }
      exit;
// Если пользователь не админ, а страница не для незарегистрированых пользователей
} else if (!$memberId && preg_match("/(login.php)|(signup.php)|(passrec.php)/", $_SERVER["SCRIPT_NAME"])==0){
    header("Location: ".$appRootPath."login?returl=".urlencode ($_SERVER["REQUEST_URI"]));
  	exit;
// Если пользователь админ, а страница не существует или её нет в списке в условии
} else if($memberId && count(db_getAdminEventsRespForReg($memberId)) == 0 && !db_isAdmin($memberId) && preg_match("/(index.php)|(signup.php)|(passrec.php)|(login.php)|(ftt_application.php)|(ftt_list.php)|(ftt_schedule.php)|(ftt_absence.php)|(ftt_announcement.php)|(ftt_extrahelp.php)|(ftt_attendance.php)|(ftt_gospel.php)|(ftt_service.php)|(application.php)|(practices.php)|(contacts.php)|(profile.php)|(settings.php)|(meetings.php)|(opros.php)|(attend.php)|(ftt_fellowship.php)/", $_SERVER["SCRIPT_NAME"])==0){ //|(links.php)
    header("Location: ".$appRootPath);
  	exit;
}

/*Раздел ftt_reports.php не используется сейчас*/
/*
Убран потому что даёт доступ только админам шаблонов собраний
// доступ к разделу Собрания
if (!db_isAvailableMeetingPage($memberId) && $thispage === 'meetings') {
  header("Location: ".$appRootPath);
  exit;
}
*/
include_once "textblock.php";
// Данные Админа
include_once "db/classes/admin_data.php";
$admin_data = get_admin_data::data($memberId);

// правило отображения разделов для обучающихся
$ftt_access = get_admin_data::ftt($memberId);

if ($ftt_access !== 'denied') {
  if ($ftt_access['group'] === 'trainee' && ($thispage === 'meetings' || $thispage === 'reg' || $thispage === 'members')) {
    header("Location: ".$appRootPath);
    exit;
  }
}

/*
if ($memberId && $ftt_access['group'] === 'trainee' && preg_match("/(index.php)|(signup.php)|(passrec.php)|(login.php)|(ftt.php)|(practices.php)|(contacts.php)|(profile.php)|(settings.php)|(links.php)/", $_SERVER["SCRIPT_NAME"])==0) {
  header("Location: ".$appRootPath);
  exit;
}
*/
//}
