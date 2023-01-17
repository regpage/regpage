<?php
$s = $_SERVER["SCRIPT_NAME"];
$isEventAdminNav = isset($memberId) ? db_hasRightToHandleEvents($memberId) : false;
$h = ($_SERVER['PHP_SELF']);
$res = '';
db_checkNotice($memberId) ? $noticeOn = '' : $noticeOn = 'none';
$tempTmp = db_checkNotice($memberId);
$contact_page_name = 'Контакты';
if ($ftt_access['group'] === 'trainee') {
  $contact_page_name = 'ПВОМ';
}

switch ($h) {
     case '/index.php':
        $res = 'Главная';
        break;
    case '/reg.php':
        $res = 'Регистрация';
        break;
    case '/members.php':
        $res = 'Списки';
        break;
    case '/meetings.php':
        $res = 'Собрания';
        break;
    case '/visits.php':
        $res = 'Посещения и звонки';
        break;
    case '/list.php':
        $res = 'Ответственные';
        break;
    case '/login.php':
        $res = 'Войти';
        break;
    case '/signup.php':
        $res = 'Создать учётную запись';
        break;
    case '/reference.php':
        $res = 'Справка';
        break;
    case '/statistic.php':
        $res = 'Статистика';
        break;
    case '/youth.php':
        $res = 'Молодёжь';
        break;
    case '/event.php':
        $res = 'Мероприятия';
        break;
    case '/practices.php':
        $res = 'Практики';
        break;
    case '/contacts.php':
        $res = $contact_page_name;
        break;
    case '/panel.php':
        $res = 'Панель';
        break;
    case '/ftt_application.php':
        $res = 'ПВОМ';
        break;
    case '/application.php':
        $res = 'Заявление на ПВОМ';
        break;
    case '/ftt_schedule.php':
        $res = 'ПВОМ';
        break;
    case '/ftt_announcement.php':
        $res = 'ПВОМ';
        break;
    case '/ftt_attendance.php':
        $res = 'ПВОМ';
        break;
    case '/ftt_service.php':
        $res = 'ПВОМ';
        break;
    case '/ftt_gospel.php':
        $res = 'ПВОМ';
        break;
    case '/ftt_absence.php':
        $res = 'ПВОМ';
        break;
    case '/ftt_extrahelp.php':
        $res = 'ПВОМ';
        break;
    case '/ftt_list.php':
        $res = 'ПВОМ';
        break;
    default:
      $res = '';
      break;
}
?>
    <nav class="navbar navbarmain navbar-expand-md bg-dark navbar-dark fixed-top" style="background-color: #1b1b1b !important; height: 43px;">
      <span class="show-name-list" style="color: white;"><b><?php echo $res; ?></b></span>
      <div class="row">
        <ul id="helpButtonMbl" class="nav" style="margin-left: auto; margin-right: 10px; display: none;">
          <i class="fa fa-bell bell-alarm-mbl cursor-pointer" style="<?php echo db_checkNotice($memberId); ?>" title="У вас есть новые карточки"></i>
          <!--<i class="fa fa-envelope envelope-support-mbl cursor-pointer send-message-support-phone" title="Обратится в службу поддержки"></i>-->
          <li class="nav-item dropdown" style="margin-top: 3px;">
            <a class="btn help_link" type="button" data-toggle="dropdown" style="background-color: white; font-size: 14px; padding: 3px 10px!important;"><i class="fa fa-question fa-lg"></i><span class="hide-name"></span></a>
              <ul class="dropdown-menu pull-right" style="padding: 5px; left: -320%; min-width: 190px">
                <?php

                  $sortField = isset ($_COOKIE['sort_field_reference']) ? $_COOKIE ['sort_field_reference'] : 'name';
                  $sortType = isset ($_COOKIE['sort_type_reference']) ? $_COOKIE ['sort_type_reference'] : 'asc';
                  $references = db_getReferences($sortField, $sortType);

                  $page = explode('.', substr($_SERVER['PHP_SELF'], 1))[0];
                  $countReference = 0;

                  foreach ($references as $key => $reference) {
                      if($page == $reference['page'] && $reference['published'] == '1'){
                          $countReference ++;
                          echo '<li class="modal-reference"><a href="'.$reference['link_article'].'" target="_blank">'.$reference['name'].'</a></li>';
                      }
                  }

                  if($countReference == 0){
                      echo "<li class='modal-reference' style='font-size: 14px;'>Справочной информации по этому разделу пока нет</li>";
                  }
                  ?>
              </ul>
          </li>
        </ul>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation" style="font-size: 1em;">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="navbar-collapse collapse justify-content-center" id="navbarNav">
        <div class="nav-sub-container" style="min-width: 1170px;">
            <ul class="navbar-nav" style="background-color: #1b1b1b; padding-left: 15px;">
            <?php
            if(!isset($isGuest) && isset($memberId)){
              if ($ftt_access['group'] === 'trainee') {
                $main_point = 'Полновременное обучение';
              } else {
                $main_point = 'Главная';
              }
                echo "<li class='nav-item'";
                if (strpos ($s,"/index")!==FALSE) echo 'class="active"';
                echo "><a class='nav-link' href='/index'>{$main_point}</a></li>";
            }

            if(!isset($isGuest) && db_isAdmin($memberId) || db_hasAdminFullAccess($memberId)) {
              if ($ftt_access['group'] !== 'trainee') {
                echo '<li class="nav-item"';
                if (strpos ($s,"/reg")!==FALSE || strpos ($s,"/admin")!==FALSE) {echo " class='active'";}
                echo"><a class='nav-link' href='/reg'>Регистрация</a></li>";
              }
            }

            if(!isset($isGuest) && db_isAdmin($memberId)) {
              if ($ftt_access['group'] !== 'trainee') {
                echo '<li class="nav-item ';
                if (strpos($s,"/members")!==FALSE || strpos($s,"/youth")!==FALSE || strpos($s,"/list")!==FALSE) {echo ' active"';} else {echo ' "';}
                echo'><a class="nav-link" href="/members">Списки</a></li>';
              }
            }

            if (!isset($isGuest) && $ftt_access['group'] === 'staff') {
                echo '<li class="nav-item ';
                if (strpos($s,"/ftt_list")!==FALSE) {echo ' active"';} else {echo ' "';}
                echo'><a class="nav-link" href="/ftt_list">ПВОМ</a></li>';
            }

            if((!isset($isGuest) && db_isAdmin($memberId) && (!in_array('8', db_getUserSettings($memberId)))) || (db_hasAdminFullAccess($memberId) && (!in_array('8', db_getUserSettings($memberId))))) {
              if ($ftt_access['group'] !== 'trainee') {
                echo '<li class="nav-item"';
                if (strpos ($s,"/meetings")!==FALSE || strpos ($s,"/visits")!==FALSE ) {echo " class='active'";}
                echo"><a class='nav-link' href='/meetings'>Собрания</a></li>";
              }
            }

            /*if((!isset($isGuest) && (in_array('9', db_getUserSettings($memberId)))) || (db_hasAdminFullAccess($memberId) && (in_array('9', db_getUserSettings($memberId)))) || (!isset($isGuest) && (in_array('12', db_getUserSettings($memberId)))) || (db_hasAdminFullAccess($memberId) && (in_array('10', db_getUserSettings($memberId))))) {
              if ($ftt_access['group'] !== 'trainee') {
                echo '<li  class="nav-item"';
                if (strpos ($s,"/practices")!==FALSE) {echo " class='active'";}
                echo"><a class='nav-link' href='/practices'>Практики</a></li>";
              }
            }*/
            if(isset($memberId) && ((in_array('14', db_getUserSettings($memberId))) || db_getAnyActiveContactStr($memberId)) && !isset($isGuest) && $ftt_access['group'] !== 'trainee' && $ftt_access['group'] !== 'staff') {
                echo '<li ';
                if ($res === 'Контакты') {echo " class='nav-item active'";}else{echo " class='nav-item'";}
                echo"><a class='nav-link' href='/contacts'>Контакты</a></li>";
            }

            if(!isset($isGuest) && $memberId && $ftt_access['group'] !== 'trainee'){

                echo '<li  class="nav-item"';
                if (strpos ($s,"/settings")!==FALSE) {echo " class='active'";}
                echo"><a class='nav-link' href='/settings'>Настройки</a></li>";
            }

            if(isset($memberId) && ($memberId == '000008601' || $memberId == '000001679' || $memberId == '000005716')){

                echo '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Ещё</a><div class="dropdown-menu"><a href="/statistic" class="dropdown-item ';
                if (strpos ($s,'/statistic')!==FALSE) {echo ' active ';}
                echo '">Статистика</a>';

                echo '<a href="/reference" class="dropdown-item ';
                if (strpos ($s,'/reference')!==FALSE) {echo ' active ';}
                echo'">Справка</a></a><div></li>';
            }

            if(!isset($isGuest) && isset($memberId)){
                echo '<li class="divider-vertical"></li>';
            }

            if (!isset($isGuest) && $memberId) {
                list($name, $email) = db_getMemberNameEmail($memberId);

                $_name = '';

                if($name){
                    $nameArr = explode(' ', $name);
                    $_name  = $nameArr[0].' '.( $nameArr[1] ? strtoupper(mb_substr($nameArr[1], 0, 1, 'utf-8')).'. ' : '' ).' '.($nameArr[2] ? strtoupper(mb_substr($nameArr[2], 0, 1, 'utf-8')).'. ' : '');
                }
                else{
                    $_name = $email;
                }

                echo //'<li class="nav-item dropdown">
                      //  <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown"';
                      //      echo 'href="#"><span class="user-name">'.$_name.'</span>
                      //  </a>
                        '<li class="nav-item"><a class="nav-link ';
                        if (strpos ($s,'/profile')!==FALSE) echo ' active ';
                        echo '" href="/profile" title="'.$_name.'" style="margin-right:0px;">Профиль</a></li>';
                        echo'<li class="nav-item"><a class="logout nav-link" href="/" title="Выйти"><i class="fa fa-sign-out" aria-hidden="true" style="font-size: 18px; margin-top:2px;"></i></a></li>';
                    //</li>';
            }
            else {
                echo '<li class="nav-item"';
                if (strpos ($s,"/index")!==FALSE) echo 'class="active"';
                echo '><a href="/index">Войти</a></li>';
                echo '<li class="nav-item"';
                if (strpos ($s,"/signup")!==FALSE) echo 'class="active"';
                echo '><a href="/signup">Создать учётную запись</a></li>';
            }
            ?>
            <i class="fa fa-bell bell-alarm cursor-pointer" style="<?php echo db_checkNotice($memberId); ?>" title="У вас есть новые карточки"></i>
            <?php
            //
            if ($memberId === '000001679' || $memberId === '000005716') {
              echo '<i class="fa fa-wrench cursor-pointer" style="color: silver; font-size: 20px; margin-top: 5px; margin-left: 10px;" title="Дополнительные опции"></i>';
            }
            ?>
            <!--<i class="fa fa-envelope envelope-support cursor-pointer" title="Обратится в службу поддержки"></i>-->
            <ul id="helpButton" class="nav" style="margin-left: auto; margin-right: 10px; margin-left: 10px;">
              <li class="nav-item dropdown" style="margin-top: 3px;">
                <a class="btn dropdown-toggle help_link" type="button" data-toggle="dropdown" style="background-color: white; font-size: 14px; padding: 3px 10px!important;"><i class="fa fa-question fa-lg"></i><span class="hide-name"> Справка</span></a>
                  <ul class="dropdown-menu pull-right" style="padding: 5px;">
                    <?php

                      $sortField = isset ($_COOKIE['sort_field_reference']) ? $_COOKIE ['sort_field_reference'] : 'name';
                      $sortType = isset ($_COOKIE['sort_type_reference']) ? $_COOKIE ['sort_type_reference'] : 'asc';
                      $references = db_getReferences($sortField, $sortType);

                      $page = explode('.', substr($_SERVER['PHP_SELF'], 1))[0];
                      $countReference = 0;

                      foreach ($references as $key => $reference) {
                          if($page == $reference['page'] && $reference['published'] == '1'){
                              $countReference ++;
                              echo '<li class="modal-reference"><a href="'.$reference['link_article'].'" target="_blank">'.$reference['name'].'</a></li>';
                          }
                      }

                      if($countReference == 0){
                          echo "<li class='modal-reference' style='font-size: 14px;'>Справочной информации по этому разделу пока нет</li>";
                      }
                      ?>
                  </ul>
              </li>
            </ul>
          </ul>
        </div>
      </div>
    </nav>

<script>
// Скрываем название раздела из меню
if ($(window).width()>769) {
  $(".show-name-list").hide();
  if ($(window).width() >= 1170) {
		let position_help_btn = $("#helpButton").position();
		let free_place  = (1170 - (position_help_btn.left + 100) + (($(window).width()-1170 - 60)/2));
		$("#helpButton").attr("style", "margin-left: "+free_place+"px !important; margin-right: 10px; margin-left: 10px;");
	}
}

function referenceSysAnew() {
  var memberId = '<?php echo $memberId; ?>';
  if (window.location.pathname.length === 3 && memberId) {
    var linksArr=[];
    var pathpath = window.location.pathname;
    pathpath = pathpath[1] + pathpath[2];
    $.post('/ajax/reference.php', {})
    .done(function(data){

      $(data.references).each(function (i) {
        var reference = data.references[i];
         if (reference['page'] == pathpath) {
            linksArr.push('<li class="modal-reference"><a href="'+reference["link_article"]+'" target="_blank">'+reference["name"]+'</a></li>');

         }
      })
      if (linksArr.length != 0) {
        $('.dropdown-menu.pull-right').html(linksArr);
      } else {
        linksArr = '<li class="modal-reference"><a href="#">Справочной информации по этому разделу пока нет</a></li>';
        $('.dropdown-menu.pull-right').html(linksArr);
      }
    });
  }
}

referenceSysAnew();

    $('.logout').click(function(e){
        e.preventDefault();

        var memberId = '<?php echo $memberId; ?>';
        var getSessionIdLogOut = "<?php print(session_id()); ?>"
        $.get('ajax/login.php?logout', {memberId: memberId, sessionId: getSessionIdLogOut})
        .done (function() {
            window.location ='<?php $_SESSION["sess_last_page"]; ?>';
        })
        .fail(function() {
            window.location = "/";
        })

    });

    $('.btn-navbar').click(function(){
        if($('.nav-collapse').hasClass('in')){
            $('.show-name-list').css('display','inline');
        }
        else $('.show-name-list').css('display','none');
    });

    $(".send-message-regteam").click (function (){
        $("#sendMsgEventName").text ($('#events-list option:selected').text());
    });

    $('.fa-wrench').click(function () {
      if (window.location != '/panel') {
        window.location = '/panel';
      }
    });
// Give me Admin Role 0   ver 5.1.8
    function setAdminRole_0(element1, element2) {
        var adminRole = parseInt('<?php echo db_getAdminRole($memberId); ?>');
        if (adminRole===0) {
          $ (element1).hide ();
          $ (element2).hide ();
        }
    }
    var glbRoleAdmin = parseInt('<?php echo db_getAdminRole($memberId); ?>');

</script>
