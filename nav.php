<?php
$s = $_SERVER["SCRIPT_NAME"];
$isEventAdminNav = isset($memberId) ? db_hasRightToHandleEvents($memberId) : false;
$h = ($_SERVER['PHP_SELF']);
$res = '';
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
        $res = 'Создать аккаунт';
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
    case '/links.php':
        $res = 'Ссылки';
        break;
    case '/practices.php':
       $res = 'Практики';
       break;
    case '/contacts.php':
       $res = 'Контакты';
       break;
    case '/panel.php':
      $res = 'Панель';
       break;
    case '/ftt_application.php':
      $res = 'Полновременное обучение';
      break;
    case '/application.php':
      $res = 'Заявление на ПВОМ';
      break;
    case '/ftt_list.php':
      $res = 'ПВОМ';
      break;
    default:
        $res = '';
        break;
}
?>
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
        <span class="show-name-list" style="margin-top:10px;"><?php echo $res; ?></span>
        <i class="fa fa-bell bell-alarm-mbl cursor-pointer" style="color: gold; font-size: 18px; margin-top: 12px; margin-left: 150px; <?php echo db_checkNotice($memberId); ?>" aria-hidden="true" title="У вас есть новые карточки"></i>
        <!--<i class="fa fa-envelope cursor-pointer" title="Обратится в службу поддержки" aria-hidden="true" style="color: white; font-size: 18px; margin-top: 13px;"></i>-->
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="btn-group" style="float: right; margin-right: 10px;">
          <a class="btn dropdown-toggle" type="button" data-toggle="dropdown" style="margin-top: 1px; height: 19px;"><i class="fa fa-question fa-lg"></i><span class="hide-name" style="padding-left: 5px">Справка</span></a>
            <ul class="dropdown-menu pull-right">
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
                    echo "<li class='modal-reference'>Справочной информации по этому разделу пока нет</li>";
                }
                ?>
            </ul>
        </div>
        <?php
         //if ($h === "/signup.php" || $h === "/login.php" || $h === "/index.php") { ?>
          <!--<span class="btn fa fa-envelope-o fa-lg send-message-support-phone" style="float: right; margin-top: 6px; height: 19px;" data-toggle="modal" data-target="#messageAdmins" title="Отправить сообщение службе поддержки" aria-hidden="true"></span>-->
        <?php // } ?>
        <div class="nav-collapse collapse">
            <ul class="nav">
            <?php
// && (!(db_isAdmin($memberId)) || $memberId === '000005716' || $memberId == '000001679') Блок для аминов с зоной регистрации раздела события
            if(!isset($isGuest) && isset($memberId)){
              if ($ftt_access['group'] === 'trainee') {
                $main_point = 'Полновременное обучение';
              } else {
                $main_point = 'Главная';
              }
                echo "<li ";
                if (strpos ($s,"/index")!==FALSE) echo 'class="active"';
                // if (strpos ($s,"/index")!==FALSE) echo 'class="active"';
                // echo '><a href="/">События</a></li>';
                echo "><a href='/index'>{$main_point}</a></li>";
            }

            if((!isset($isGuest) && $ftt_access['group'] !== 'trainee' && db_isAdmin($memberId)) || (db_hasAdminFullAccess($memberId) && $ftt_access['group'] !== 'trainee')) {
                echo '<li';
                if (strpos ($s,"/reg")!==FALSE || strpos ($s,"/admin")!==FALSE) {echo " class='active'";}
                echo"><a href='/reg'>Регистрация</a></li>";
            }

            if(!isset($isGuest) && db_isAdmin($memberId) && $ftt_access['group'] !== 'trainee') {
                echo '<li';
                if (strpos ($s,"/members")!==FALSE || strpos($s,"/youth")!==FALSE || strpos($s,"/list")!==FALSE) {echo " class='active'";}
                echo"><a href='/members'>Списки</a></li>";
            }

            if (!isset($isGuest) && $ftt_access['group'] === 'staff') {
                echo '<li ';
                if (strpos($s,"/ftt_list")!==FALSE) {echo "class='active'";}
                echo'><a href="/ftt_list">ПВОМ</a></li>';
            }

            /*if(!isset($isGuest) && db_isAdmin($memberId) || db_hasAdminFullAccess($memberId)) {
                echo '<li';
                if (strpos ($s,"/youth")!==FALSE) {echo " class='active'";}
                echo"><a href='/youth'>Молодёжь</a></li>";
            }*/

            if((!isset($isGuest) && db_isAdmin($memberId) && $ftt_access['group'] !== 'trainee' && (!in_array('8', db_getUserSettings($memberId))))) {
                echo '<li';
                if (strpos ($s,"/meetings")!==FALSE || strpos ($s,"/visits")!==FALSE ) {echo " class='active'";}
                echo"><a href='/meetings'>Собрания</a></li>";
            }

            /*if((!isset($isGuest) && db_isAdmin($memberId)) || db_hasAdminFullAccess($memberId)) {
                echo '<li';
                if (strpos ($s,"/list")!==FALSE){echo " class='active'";}
                echo"><a href='/list'>Ответственные</a></li>";
            }*/
/*
            if(isset($memberId) && $isEventAdminNav && !isset($isGuest) && db_isAdmin($memberId)) {
                echo '<li';
                if (strpos ($s,"/archive")!==FALSE) {echo " class='active'";}
                echo"><a href='/statistic'>Архив</a></li>";
            }
*/
    /*        if(isset($memberId) && $memberId == '000005716' && !isset($isGuest) && db_isAdmin($memberId)) {
                echo '<li';
                if (strpos ($s,"/event")!==FALSE) {echo " class='active'";}
                echo"><a href='/event'>Мероприятия</a></li>";
            }
*/
            /*if((!isset($isGuest) && (in_array('9', db_getUserSettings($memberId)))) || (db_hasAdminFullAccess($memberId) && (in_array('9', db_getUserSettings($memberId)))) || (!isset($isGuest) && (in_array('12', db_getUserSettings($memberId)))) || (db_hasAdminFullAccess($memberId) && (in_array('10', db_getUserSettings($memberId))))) {
              if ($ftt_access['group'] !== 'trainee') {
                echo '<li';
                if (strpos ($s,"/practices")!==FALSE) {echo " class='active'";}
                echo"><a href='/practices'>Практики</a></li>";
              }
            }*/

        /*    if(isset($memberId) && ($memberId == '000005716' || $memberId == '000001679') && !isset($isGuest) && db_isAdmin($memberId)) {
                echo '<li';
                if (strpos ($s,"/statistic")!==FALSE) {echo " class='active'";}
                echo"><a href='/statistic'>Статистика</a></li>";
            }*/

            if(isset($memberId) && !isset($isGuest) && ((in_array('14', db_getUserSettings($memberId))) || db_getAnyActiveContactStr($memberId)) && $ftt_access['group'] !== 'trainee' && $ftt_access['group'] !== 'staff') {
                echo '<li  class="nav-item"';
                if (strpos ($s,"/contacts")!==FALSE) {echo " class='active'";}
                echo"><a class='nav-link' href='/contacts'>Контакты</a></li>";
            }

            if(isset($memberId) && $ftt_access['group'] !== 'trainee'){
                echo '<li';
                if (strpos ($s,"/links")!==FALSE) {echo " class='active'";}
                echo"><a href='/links'>Ссылки</a></li>";
            }

            if(!isset($isGuest) && $memberId && $ftt_access['group'] !== 'trainee'){
                echo '<li';
                if (strpos ($s,"/settings")!==FALSE) {echo " class='active'";}
                echo"><a href='/settings'>Настройки</a></li>";
            }

            if(isset($memberId) && ($memberId == '000001679' || $memberId == '000005716')){
              echo '<li class="btn-group">
                      <a class="user-name-field dropdown-toggle" data-toggle="dropdown"';
                          echo 'href="#"><span class="">Ещё</span>
                          <span class="caret"></span>
                      </a>';
                      echo '<ul class="dropdown-menu"><li';
                      if (strpos ($s,'/statistic')!==FALSE) echo ' class="active"';
                      echo '><a href="/statistic">Статистика</a></li>';
                      echo  '<li';
                      if (strpos ($s,'/reference')!==FALSE) echo ' class="active"';
                      echo '><a href="/reference">Справка</a></li>';
                      echo'</ul></li>';
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

                echo '<li';
                        if (strpos ($s,'/profile')!==FALSE) echo ' class="active"';
                        echo '><a href="/profile" title="'.$_name.'" style="margin-right:0px;">Профиль</a></li>';
                        echo'<li><a href="/" class="logout" title="Выйти"><i class="fa fa-sign-out" style="font-size: 18px; margin-top:2px;" aria-hidden="true"></i></a></li>';
                        //$access_areas = db_getAdminAccess ($memberId);
/*
                        if($memberId*//*$access_areas && count($access_areas) > 0*//*){
                            echo '<li';
                            if (strpos ($s,'/settings')!==FALSE) echo ' class="active"';
                            echo '><a href="/settings">Настройки</a></li>';
                        }*/
                        //echo'<li><a href="/" class="logout">Выйти</a></li>
                        //</ul>
                    //</li>';
            }
            else {
                echo '<li ';
                if (strpos ($s,"/index")!==FALSE) echo 'class="active"';
                echo '><a href="/index">Войти</a></li>';
                echo '<li ';
                if (strpos ($s,"/signup")!==FALSE) echo 'class="active"';
                echo '><a href="/signup">Создать аккаунт</a></li>';
            }
            ?>
            <i class="fa fa-bell bell-alarm cursor-pointer" style="color: gold; font-size: 18px; margin-top: 12px; margin-left: 10px; <?php echo db_checkNotice($memberId); ?>" aria-hidden="true" title="У вас есть новые карточки"></i>
            <!--<i class="fa fa-envelope cursor-pointer" title="Обратится в службу поддержки" aria-hidden="true" style="color: white; font-size: 18px; margin-top: 13px;"></i>-->
            <?php

            if ($memberId == '000001679' || $memberId == '000005716') {
            echo '<i class="fa fa-wrench cursor-pointer" style="color: silver; font-size: 20px; margin-top: 10px;"></i>';
            }
            ?>
        </ul>
      </div><!--/.nav-collapse -->
      <div class='notifications center'></div>
    </div>
  </div>
</div>
<script>
  if (window.location.pathname == '/login') {
    $('.nav li:first-child').addClass('active')
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
// Give me Admin Role 0   ver 5.1.8
    function setAdminRole_0(element1, element2) {
        var adminRole = parseInt('<?php echo db_getAdminRole($memberId); ?>');
        if (adminRole===0) {
          $ (element1).hide ();
          $ (element2).hide ();
        }
    }
    var glbRoleAdmin = parseInt('<?php echo db_getAdminRole($memberId); ?>');

    // notifications
    $('.bell-alarm').click(function () {
    	if (window.location != '/contacts') {
        document.cookie = "sort_new=sort_new";
    		window.location = '/contacts';
    	}
    });
    $('.bell-alarm-mbl').click(function () {
    	if (window.location != '/contacts') {
        document.cookie = "sort_new=sort_new";
    		window.location = '/contacts';
    	}
    });
    $('.fa-wrench').click(function () {
    	if (window.location != '/panel') {
    		window.location = '/panel';
    	}
    });
    if ($(window).width()>=769) {
      $('.bell-alarm-mbl').hide();
    } else {
      $('.bell-alarm').hide();
    }
    // STOP notifications
</script>
