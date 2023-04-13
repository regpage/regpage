<?php
require_once "preheader.php";
include_once 'header2.php';
include_once 'nav2.php';
include_once 'panelsource/panelDB.php';
include_once 'panelsource/adminpaneldb.php';
include_once 'panelsource/panelModal.php';
include_once 'extensions/write_to_log/write_to_log.php';
//$allLocalities = db_getLocalities();
$pages = db_getPages();
$customPages = db_getCustomPagesPanel();
$ResponsibleContacts = db_getResponsibleContacts1And2();
$memberId = db_getMemberIdBySessionId (session_id());
$ResponsibleZero = db_getResponsibleContactsZero();
$checkLostContactsList = db_checkLostContacts();
if ($memberId !== '000001679'){
  if ($memberId !== '000005716') {
    return;
  }
}
$active = 'active';
$active_ftt = '';
if (isset($_COOKIE['panel_tab_active']) && $_COOKIE['panel_tab_active'] === 'ftt') {
  $active = '';
  $active_ftt = 'active';
}

write_to_log::info($memberId, 'Админ зашёл в панел администратора.');
//$aaa = db_newDailyPracticesPac(9); Dont touch!!!
?>

<div id="" class="container">
  <div class="" style="display: flex">
    <div class="col-md-12" style="margin-top: 50px;">
      <h4>Раздел разработчика</h4>
      <div class="container">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link <?php echo $active; ?>" data-toggle="tab" href="#home">Логи</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu1">Разделы</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu4">Контакты</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu5">Заявления трэш</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu6">Заявления черн.</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $active_ftt; ?>" data-toggle="tab" href="#menu7">ПВОМ</a>
          </li>
          <!--<li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu2">Практики</a>
          </li>-->
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu2">BFA</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu3">Ещё</a>
          </li>

        </ul>

  <!-- Tab panes -->
        <div class="tab-content">
          <div id="home" class="container tab-pane <?php echo $active; ?>"><br>
            <h3>Лог файлы</h3>
            <hr>
            <h5>Download log files</h5>
            <div class="">
              <?php
              if ($_SERVER['HTTP_HOST'] === 'reg-page.ru') {
                $dirPatch = '/home/regpager/domains/reg-page.ru/public_html/ajax/';
                $extraPath = 'domains/reg-page.ru/public_html/ajax/';
              } else {
                $dirPatch = '/var/www/vhosts/u0654376.plsk.regruhosting.ru/test.new-constellation.ru/ajax/';
                $extraPath = 'ajax/';
              }

              if ($handle = opendir($dirPatch)) {
                while (false !== ($entry = readdir($handle))) {
                  if ($entry != "." && $entry != ".." && strpos($entry, 'logFile') !== false) {
                    echo "<a href='download.php?file=".$entry."&path=".$extraPath."'>".$entry."</a>\n";
                  }
                }
                closedir($handle);
              }?>;
            </div>
            <hr>
            <h5>Download log files of system</h5>
            <div class="">
              <?php
              if ($_SERVER['HTTP_HOST'] === 'reg-page.ru') {
                $dirPatch2 = '/home/regpager/';
                $extraPath4 = '';
              } else {
                $dirPatch2 = '/var/www/vhosts/u0654376.plsk.regruhosting.ru/';
                $extraPath4 = '/../';
              }

              if ($handle2 = opendir($dirPatch2)) {
                while (false !== ($entry2 = readdir($handle2))) {
                  if ($entry2 != "." && $entry2 != ".." && strpos($entry2, 'logFile') !== false) {
                    echo "<a href='download.php?file=".$entry2."&path=".$extraPath4."'>".$entry2."</a>\n";
                  }
                }
                closedir($handle2);
              }?>;
            </div>
            <hr>
            <h5>Download log files of System II</h5>
            <div class="">
              <?php
              if ($_SERVER['HTTP_HOST'] === 'reg-page.ru') {
                $dirPatch3 = '/home/regpager/domains/reg-page.ru/public_html/';
                $extraPath2 = 'domains/reg-page.ru/public_html/';
              } else {
                $dirPatch3 = '/var/www/vhosts/u0654376.plsk.regruhosting.ru/test.new-constellation.ru';
                $extraPath2 = '/';
              }

              if ($handle3 = opendir($dirPatch3)) {
                while (false !== ($entry3 = readdir($handle3))) {
                  if ($entry3 != "." && $entry3 != ".." && strpos($entry3, 'logFile') !== false) {
                    echo "<a href='download.php?file=".$entry3."&path=".$extraPath2."'>".$entry3."</a>\n";
                  }
                }
                closedir($handle3);
              }?>;
            </div>
            <hr>
            <h5>Download log files of administrator</h5>
            <div class="">
              <?php
              if ($_SERVER['HTTP_HOST'] === 'reg-page.ru') {
                $dirPatch4 = '/home/regpager/domains/reg-page.ru/public_html/panelsource/';
                $extraPath3 = 'domains/reg-page.ru/public_html/panelsource/';
              } else {
                $dirPatch4 = '/var/www/vhosts/u0654376.plsk.regruhosting.ru/test.new-constellation.ru/panelsource/';
                $extraPath3 = 'panelsource/';
              }

              if ($handle3 = opendir($dirPatch4)) {
                while (false !== ($entry3 = readdir($handle3))) {
                  if ($entry3 != "." && $entry3 != ".." && strpos($entry3, 'logFile') !== false) {
                    echo "<a href='download.php?file=".$entry3."&path=".$extraPath3."'>".$entry3."</a>\n";
                  }
                }
                closedir($handle3);
              }?>;
            </div>
            <hr>
            <h5>Log of admins</h5>
            <div class=""style="border: 1px solid black; margin: 7px; padding: 7px;">
              <a href="logadmins">LOG ADMINS</a>
            </div>
          </div>
          <div id="menu1" class="container tab-pane fade"><br>
            <h3>Разделы</h3>
            <div class="col-md-12">
              <select id="selMemberCategory" class="form-control form-control form-control-sm" title="Все страницы на которые когда либо осуществляется переход.">
                <option value="_all_" selected>Все страницы</option>
                <option value="index">События</option>
                <option value="reg">Регистрация</option>
                <option value="members">Общий список</option>
                <option value="youth">Молодые люди</option>
                <option value="list">Ответственные за регистрацию</option>
                <option value="meetings">Собрания</option>
                <option value="visits">Посещения</option>
                <option value="links">Ссылки</option>
                <option value="help">Помощь</option>
                <option value="profile">Профиль</option>
                <option value="settings">Настройки</option>
                <option value="login">Логин</option>
                <option value="invites">Пермалинки</option>
                <option value="vt">Видеообучение</option>
                <option value="pd">Официальные документы</option>
                <option value="pm">Молитвенная рассылка</option>
                <option value="st">Статистика</option>
                <option value="rb">Обучение в Индии</option>
                <option value="os">Обучение братьев</option>
                <option value="mc">Мини-конференции</option>
                <option value="ul">Избранные ссылки</option>
                <option value="reference">Настройка помощи</option>
                <option value="activity">Журнал активности</option>
              </select>
              <hr>
              <h4>Ссылки на разделы</h4>
              <div class="">
                <?php
                foreach ($pages as $key => $page) {
                    echo "<div><a target = '_blank' href='".$key."' >".$page."</a> <i class='icon-pencil'></i></div>";
                }?>
              </div>
              <hr>
              <h4>Ссылки на custom pages</h4>
              <div class="">
                <?php
                foreach ($customPages as $name => $value) {
                    echo "<div><a target = '_blank' href='".$name."' >".$name."</a> <i class='icon-pencil'></i></div>";
                }?>
              </div>
            </div>
          </div>
          <div id="menu2" class="container tab-pane fade"><br>
            <?php include('panelsource/bfa/apipanel.php'); ?>
            <!--<h3>Practices</h3>
            <div class="" style="margin: 7px;">
              <input type="button" class="btn btn-danger btn-sm" id="onPracticesForStudentsPVOM" name="" value="Включить учёт практик для обучающихся ПВОМ">
            </div>
            <div class="" style="margin: 7px;" id="noticeForAddPractices">
            </div>
          </div>-->
          <div id="menu4" class="container tab-pane fade"><br>
            <div class="row">
              <div class="col-sm-8">
                <h3>Контакты</h3>
                <hr>
                <?php // include_once 'panelsource/content/contacts/category.php'; ?>
                <h4>Статистика по статусам</h4>
                <div class="row">
                  <div id="InfoStatisticStatusesContainer" class="col-sm-12">

                  </div>
                  <div class="col-sm-6">
                    <select id="statusesStatisticsSelect" class="form-control form-control form-control-sm" name="" title="Выберите месяц.">
                      <option value="">Выберите месяц</option>
                      <option value="" disabled>---- 2022 г. ----</option>
                      <option value="2021-12-31_2022-02-01">Январь</option>
                      <option value="2022-01-31_2022-03-01">Февраль</option>
                      <option value="2022-02-28_2022-04-01">Март</option>
                      <option value="2022-03-31_2022-05-01">Апрель</option>
                      <option value="2022-04-30_2022-06-01">Май</option>
                      <option value="2022-05-31_2022-07-01">Июнь</option>
                      <option value="2022-06-30_2022-08-01">Июль</option>
                      <option value="2022-07-31_2022-09-01">Август</option>
                      <option value="2022-08-31_2022-10-01">Сентябрь</option>
                      <option value="2022-09-30_2022-11-01">Октябрь</option>
                      <option value="2022-10-31_2022-12-01">Ноябрь</option>
                      <option value="2022-11-30_2023-01-01">Декабрь</option>
                      <option value="" disabled>---- 2021 г. ----</option>
                      <option value="2020-12-31_2021-02-01">Январь</option>
                      <option value="2021-01-31_2021-03-01">Февраль</option>
                      <option value="2021-02-28_2021-04-01">Март</option>
                      <option value="2021-03-31_2021-05-01">Апрель</option>
                      <option value="2021-04-30_2021-06-01">Май</option>
                      <option value="2021-05-31_2021-07-01">Июнь</option>
                      <option value="2021-06-30_2021-08-01">Июль</option>
                      <option value="2021-07-31_2021-09-01">Август</option>
                      <option value="2021-08-31_2021-10-01">Сентябрь</option>
                      <option value="2021-09-30_2021-11-01">Октябрь</option>
                      <option value="2021-10-31_2021-12-01">Ноябрь</option>
                      <option value="2021-11-30_2022-01-01">Декабрь</option>
                      <option value="" disabled>---- 2020 г. ----</option>
                      <option value="2020-06-30_2020-08-01">Июль</option>
                      <option value="2020-07-31_2020-09-01">Август</option>
                      <option value="2020-08-31_2020-10-01">Сентябрь</option>
                      <option value="2020-09-30_2020-11-01">Октябрь</option>
                      <option value="2020-10-31_2020-12-01">Ноябрь</option>
                      <option value="2020-11-30_2021-01-01">Декабрь</option>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <button type="button" id="statusesStatisticsBtn" class="btn btn-info btn-sm" name="button" data-toggle="modal" data-target="#statuWindowStatistic">Статистика</button>
                  </div>
                </div>
                <hr>
                <h4>Ответственные 1 & 2</h4>
                <div class="" style="margin: 7px;">
                  <?php
                  for ($i=0; $i < count($ResponsibleContacts); $i++) {
                     $text = $ResponsibleContacts[$i]['name'].', роль - '.$ResponsibleContacts[$i]['role'].', key - '.$ResponsibleContacts[$i]['member_key'].'<br>';
                     echo $text;
                  }
                  ?>
                </div>
                <hr>
                <h4>Ответственные 0</h4>
                <div class="">
                  <?php
                  foreach ($ResponsibleZero as $name => $names) {
                      echo '<b>'.$name.':</b><br>';
                      foreach ($names as $key2 => $name2) {
                          echo $name2.', '.$key2.'<br>';
                      }
                  }?>
                </div>
              </div>
              <div class="col-sm-4">
                <h3>Потеряные контакты</h3>
                <hr>
                <?php
                for ($i=0; $i < count($checkLostContactsList); $i++) {
                   echo $checkLostContactsList[$i].'<br>';
                }
                ?>
              </div>
            </div>
          </div>
          <div id="menu3" class="container tab-pane fade"><br>
            <h3>Other</h3>
            <div class="" style="margin: 7px;">
              <input type="button" id="dltSameStrOfLog" class="btn btn-danger btn-sm" name="" value="Удалить схожие строки из лога администраторов">
            </div>
            <div class="" style="margin: 7px;">
              <input type="button" id="dlt99LogStr" class="btn btn-danger btn-sm" name="" value="Delete 99 strings from admins log">
            </div>
            <div class="" style="margin: 7px;">
              <input type="button" id="dltDvlpLogStr" class="btn btn-danger btn-sm" name="" value="Delete developers strings from admins log">
            </div>
            <div class=""style="border: 1px solid black; margin: 7px; padding: 7px;">
              <a href="panel">ADMIN PANEL</a>
            </div>
            <hr>
            <div class="">
              <h2>Text input fields</h2>
              <form action="/envycrm.php" method="post">
                <select class="" name="value3">
                  <option>Россия
                  <option>Беларусь
                  <option>Израиль
                  <option>Украина
                  <option>США
                  <option>Канада
                </select><br>
                <input type="text" id="name" name="name" value="" placeholder="Name"><br>
                <input type="text" id="name" name="phone" value="" placeholder="Phone"><br>
                <input type="text" id="" name="value2" value="" placeholder="Комментарий"><br>
                <input type="text" id="" name="value4" value="" placeholder="Область"><br>
                <input type="text" id="" name="value5" value="" placeholder="Район"><br>
                <input type="text" id="" name="value6" value="" placeholder="Населённый пункт"><br>
                <input type="text" id="" name="value7" value="" placeholder="Адрес"><br>
                <input type="text" id="" name="value8" value="" placeholder="Индекс"><br><br>
                <input type="submit" value="Submit">
              </form>
            </div>
            <hr>
          </div>
          <div id="menu5" class="container tab-pane fade"><br>
            <?php require_once 'panelsource/content/applications/application_trash.php' ?>
          </div>
          <div id="menu6" class="container tab-pane fade"><br>
            <?php require_once 'panelsource/content/applications/application_drafts.php' ?>
          </div>
          <div id="menu7" class="container tab-pane <?php echo $active_ftt; ?>"><br>
            <?php require_once 'panelsource/content/ftt/ftt_reset.php' ?>
          </div>
        </div>
      </div>
        <div id="noticePlace">
          <div class="alert alert-success alert-dismissible fade">
            <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
            <strong>Успех!</strong> Операция прошла успешна.
          </div>
          <div class="alert alert-danger alert-dismissible fade">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Ошибка!</strong> Что то пошло не так.
          </div>
          <div class="alert alert-warning alert-dismissible fade">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Внимание!</strong> Это предупреждение.
          </div>
        </div>
      </div>
  </div>

</div>
<script type="text/javascript">
var somePages = <?php echo $pages; ?>;
var data_page = {};
</script>


<script src="/panelsource/panel.js?v31"></script>

<?php
include_once 'panelsource/js_part.php';
include_once 'footer2.php';
?>
