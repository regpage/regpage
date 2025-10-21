<?php
/* настройки */
header('Content-Type: text/html; charset=utf-8');
// отображение ошибок и предупреждений в браузере
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

/* переадресации */
// Redirect на сервисную страницу типа САЙТ ВРЕМЕННО НЕ ДОСТУПЕН
// header("Location: /attention.html"); // redirect to service page
// нет необходимости подключать библиотеки майлера и некоторые утилиты подключаемые в db.php в новых разделах

/* API */
// BFA подписка --> контакты.
if (isset($_GET['method']) && $_GET['method'] === 'contacts.add_member' && $_GET['api_key'] === 'f3db58b7cb4baa82ea5321d08b6f0ff9') {
  require_once 'api_v1.php';  
  exit;
}

/* настройки */
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365);  // 365 дней жизни куки
session_start();

// инфо раздел общения для братьев КБК
if (isset($_GET['bbd_key']) && $_GET['bbd_key'] === 'forbbdbrothers' && !empty($_GET['member_key'])) {
  include_once "ftt_fellowship_bbd.php";
  exit;
}


// logs
include_once 'extensions/write_to_log/write_to_log.php';
// подключение необходимых функций и конфигов
include_once "db.php";
// данные админа
include_once "db/classes/admin_data.php";
// доступы
require_once "db/classes/access.php";

/* авторизация на сайте */
// получаем админа по сессии
$memberId = db_getMemberIdBySessionId (session_id());

// security
// ДОБАВЛЕННО ИЗ ЗА БАГА В ГЕТ КУРСЕ (постоянной перезагрузке страницы)
// Заблокированы обращения (от ботов) не имеющие номера сессии или названия агента.
// Его положение в коде, должно быть, имеет значение
// изучить возможность расположить после старта сессии
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
define("THIS_PAGE", $thispage);
// гостевой режим с авторизацией по пермалинку
if (!$memberId && ($thispage === 'arrdep' || $thispage === 'invites') && isset($_GET['link']) && !empty($_GET['link'])) {
  $isGuest = true;
} else {
  // сначала исправить ошибки в обращениях к этой переменной
  //$isGuest = false;
}
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

define("IS_FTT_PAGE", $isFttPage);
// Бланки по ссылке. Эта проверка перенесена в index.php
/* if ((!$memberId && isset ($_GET["link"])) || (!$memberId && isset ($_GET["invited"]))){
} else*/
// Custom page. Если название страницы состоит из двух символов типа '/bt'
/* разбор адресов */
// if (!isset($isGuest)) {} // переменная оппределяется в invites.php этот блок исключал проверки для гостей
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
} else if (!$memberId && ((isset($isGuest) && !$isGuest) || !isset($isGuest)) && preg_match("/(login.php)|(signup.php)|(passrec.php)/", $_SERVER["SCRIPT_NAME"])==0){
    header("Location: ".$appRootPath."login?returl=".urlencode ($_SERVER["REQUEST_URI"]));
  	exit;
// Если пользователь админ, а страница не существует или её нет в списке в условии
} else if($memberId && count(db_getAdminEventsRespForReg($memberId)) == 0 && !db_isAdmin($memberId) && preg_match("/(index.php)|(signup.php)|(passrec.php)|(login.php)|(ftt_application.php)|(ftt_list.php)|(ftt_schedule.php)|(ftt_absence.php)|(ftt_announcement.php)|(ftt_extrahelp.php)|(ftt_attendance.php)|(ftt_gospel.php)|(ftt_service.php)|(application.php)|(practices.php)|(contacts.php)|(profile.php)|(settings.php)|(meetings.php)|(opros.php)|(attend.php)|(ftt_fellowship.php)|(ftt_reading.php)|(ftt_settings.php)|(ftt_prophecy.php)|(vtraining.php)|(ch_statistic.php|itero_2025_w.php)/", $_SERVER["SCRIPT_NAME"])==0){ //|(links.php)
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
// текстовые блоки
include_once "textblock.php";

if ((isset($isGuest) && !$isGuest) || !isset($isGuest)) {
  $admin_data = get_admin_data::data($memberId);
  // правило отображения разделов для обучающихся
  $ftt_access = get_admin_data::ftt($memberId);

  if ($ftt_access !== 'denied') {
    if ($ftt_access['group'] === 'trainee' && ($thispage === 'meetings' || $thispage === 'reg' || $thispage === 'members')) {
      header("Location: ".$appRootPath);
      exit;
    }
  }
}

/*
if ($memberId && $ftt_access['group'] === 'trainee' && preg_match("/(index.php)|(signup.php)|(passrec.php)|(login.php)|(ftt.php)|(practices.php)|(contacts.php)|(profile.php)|(settings.php)|(links.php)/", $_SERVER["SCRIPT_NAME"])==0) {
  header("Location: ".$appRootPath);
  exit;
}
*/
