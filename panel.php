<?php
include_once 'header2.php';
include_once 'nav2.php';
include_once 'panelsource/panelDB.php';
include_once 'panelsource/adminpaneldb.php';
include_once 'panelsource/panelModal.php';
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
//$aaa = db_newDailyPracticesPac(9); Dont touch!!!
?>

<div id="" class="container">
  <div class="" style="display: flex">
    <div class="col-md-12" style="margin-top: 50px;">
      <h4>Options panel</h4>
      <div class="container">
        <br>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#home">General</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu1">Pages</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu2">Practices</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu4">Contacts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#menu3">Other</a>
          </li>
        </ul>

  <!-- Tab panes -->
        <div class="tab-content">
          <div id="home" class="container tab-pane active"><br>
            <h3>GENERAL</h3>
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
            <h3>Pages</h3>
            <div class="col-md-12">
              <select id="selMemberCategory" class="form-control form-control form-control-sm" title="?????? ???????????????? ???? ?????????????? ?????????? ???????? ???????????????????????????? ??????????????.">
                <option value="_all_" selected>?????? ????????????????</option>
                <option value="index">??????????????</option>
                <option value="reg">??????????????????????</option>
                <option value="members">?????????? ????????????</option>
                <option value="youth">?????????????? ????????</option>
                <option value="list">?????????????????????????? ???? ??????????????????????</option>
                <option value="meetings">????????????????</option>
                <option value="visits">??????????????????</option>
                <option value="links">????????????</option>
                <option value="help">????????????</option>
                <option value="profile">??????????????</option>
                <option value="settings">??????????????????</option>
                <option value="login">??????????</option>
                <option value="invites">????????????????????</option>
                <option value="vt">??????????????????????????</option>
                <option value="pd">?????????????????????? ??????????????????</option>
                <option value="pm">?????????????????????? ????????????????</option>
                <option value="st">????????????????????</option>
                <option value="rb">???????????????? ?? ??????????</option>
                <option value="os">???????????????? ??????????????</option>
                <option value="mc">????????-??????????????????????</option>
                <option value="ul">?????????????????? ????????????</option>
                <option value="reference">?????????????????? ????????????</option>
                <option value="activity">???????????? ????????????????????</option>
              </select>
              <hr>
              <h4>Pages</h4>
              <div class="">
                <?php
                foreach ($pages as $key => $page) {
                    echo "<div><a target = '_blank' href='".$key."' >".$page."</a> <i class='icon-pencil'></i></div>";
                }?>
              </div>
              <hr>
              <h4>Custom pages</h4>
              <div class="">
                <?php
                foreach ($customPages as $name => $value) {
                    echo "<div><a target = '_blank' href='".$name."' >".$name."</a> <i class='icon-pencil'></i></div>";
                }?>
              </div>
            </div>
          </div>
          <div id="menu2" class="container tab-pane fade"><br>
            <h3>Practices</h3>
            <div class="" style="margin: 7px;">
              <input type="button" class="btn btn-danger btn-sm" id="onPracticesForStudentsPVOM" name="" value="???????????????? ???????? ?????????????? ?????? ?????????????????????? ????????">
            </div>
            <div class="" style="margin: 7px;" id="noticeForAddPractices">
            </div>
          </div>
          <div id="menu4" class="container tab-pane fade"><br>
            <div class="row">
              <div class="col-sm-8">
                <h3>Contacts</h3>
                <hr>
                <h4>???????????????????? ???? ????????????????</h4>
                <div class="row">
                  <div id="InfoStatisticStatusesContainer" class="col-sm-12">

                  </div>
                  <div class="col-sm-6">
                    <select id="statusesStatisticsSelect" class="form-control form-control form-control-sm" name="" title="???????????????? ??????????.">
                      <option value="">???????????????? ??????????</option>
                      <option value="" disabled>---- 2020 ??. ----</option>
                      <option value="2020-06-30_2020-08-01">????????</option>
                      <option value="2020-07-31_2020-09-01">????????????</option>
                      <option value="2020-08-31_2020-10-01">????????????????</option>
                      <option value="2020-09-30_2020-11-01">??????????????</option>
                      <option value="2020-10-31_2020-12-01">????????????</option>
                      <option value="2020-11-30_2021-01-01">??????????????</option>
                      <option value="" disabled>---- 2021 ??. ----</option>
                      <option value="2020-12-31_2021-02-01">????????????</option>
                      <option value="2021-01-31_2021-03-01">??????????????</option>
                      <option value="2021-02-28_2021-04-01">????????</option>
                      <option value="2021-03-31_2021-05-01">????????????</option>
                      <option value="2021-04-30_2021-06-01">??????</option>
                      <option value="2021-05-31_2021-07-01">????????</option>
                      <option value="2021-06-30_2021-08-01">????????</option>
                      <option value="2021-07-31_2021-09-01">????????????</option>
                      <option value="2021-08-31_2021-10-01">????????????????</option>
                      <option value="2021-09-30_2021-11-01">??????????????</option>
                      <option value="2021-10-31_2021-12-01">????????????</option>
                      <option value="2021-11-30_2022-01-01">??????????????</option>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <button type="button" id="statusesStatisticsBtn" class="btn btn-info btn-sm" name="button" data-toggle="modal" data-target="#statuWindowStatistic">????????????????????</button>
                  </div>
                </div>
                <hr>
                <h4>Responibles 1 & 2</h4>
                <div class="" style="margin: 7px;">
                  <?php
                  for ($i=0; $i < count($ResponsibleContacts); $i++) {
                     $text = $ResponsibleContacts[$i]['name'].', ???????? - '.$ResponsibleContacts[$i]['role'].', key - '.$ResponsibleContacts[$i]['member_key'].'<br>';
                     echo $text;
                  }
                  ?>
                </div>
                <hr>
                <h4>Responibles 0</h4>
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
                <h3>Lost contacts</h3>
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
              <input type="button" id="dltSameStrOfLog" class="btn btn-danger btn-sm" name="" value="?????????????? ???????????? ???????????? ???? ???????? ??????????????????????????????">
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
                  <option>????????????
                  <option>????????????????
                  <option>??????????????
                  <option>??????????????
                  <option>??????
                  <option>????????????
                </select><br>
                <input type="text" id="name" name="name" value="" placeholder="Name"><br>
                <input type="text" id="name" name="phone" value="" placeholder="Phone"><br>
                <input type="text" id="" name="value2" value="" placeholder="??????????????????????"><br>
                <input type="text" id="" name="value4" value="" placeholder="??????????????"><br>
                <input type="text" id="" name="value5" value="" placeholder="??????????"><br>
                <input type="text" id="" name="value6" value="" placeholder="???????????????????? ??????????"><br>
                <input type="text" id="" name="value7" value="" placeholder="??????????"><br>
                <input type="text" id="" name="value8" value="" placeholder="????????????"><br><br>
                <input type="submit" value="Submit">
              </form>
            </div>
            <hr>
          </div>
        </div>
      </div>
        <div class="noticePlace">
          <div class="alert alert-success alert-dismissible fade">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Success!</strong> Indicates a successful or positive action.
          </div>
        </div>
      </div>
  </div>

</div>
<script type="text/javascript">
var somePages = <?php echo $pages; ?>;
var data_page = {};
</script>


<script src="/panelsource/panel.js?v29"></script>

<?php
include_once 'footer2.php';
?>
