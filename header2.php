<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-144838221-1"></script>-->
<script>
  /*window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-144838221-1');*/
</script>
    <meta charset="utf-8">
    <title>
    <?php if ($ftt_access['group'] === 'trainee'): ?>
      ПВОМ
    <?php else: ?>
      Страница регистрации
    <?php endif; ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Expires" content="Wed, 06 Sep 2017 16:35:12 GMT">
    <meta http-equiv="Pragma" content="no-cache">
    <meta name="mailru-domain" content="z83V20hFDKLekMbc">
    <link href="favicon.ico" rel="shortcut icon">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/style2.css?v18" rel="stylesheet">
    <!--  <link href="css/style_slide.css?v2" rel="stylesheet">-->

<?php if (IS_FTT) { ?>
    <!-- Основные стили ПВОМ -->
    <link href="css/ftt/ftt.css?v4" rel="stylesheet">
<?php } ?>


<?php if ($_SERVER['PHP_SELF'] === '/contacts.php') { ?>
    <link href="css/contacts.css?v10" rel="stylesheet">
<?php } elseif ($_SERVER['PHP_SELF'] === '/ftt_application.php') { ?>
    <link href="css/ftt/ftt_application.css?v2" rel="stylesheet">
<?php } elseif ($_SERVER['PHP_SELF'] === '/application.php') { ?>
    <link href="css/ftt/ftt_request.css?v2" rel="stylesheet">
<?php } elseif ($_SERVER['PHP_SELF'] === '/ftt_schedule.php') { ?>
    <link href="css/ftt/ftt_schedule.css?v3" rel="stylesheet">
<?php } elseif ($_SERVER['PHP_SELF'] === '/ftt_extrahelp.php') { ?>
    <link href="css/ftt/ftt_extra_help.css?v3" rel="stylesheet">
<?php } elseif ($_SERVER['PHP_SELF'] === '/ftt_gospel.php') { ?>
    <link href="css/ftt/ftt_gospel.css?v10" rel="stylesheet">
<?php } elseif ($_SERVER['PHP_SELF'] === '/ftt_gospel_statistic.php') { ?>
    <link href="css/ftt/diagrams.css?v1" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
<?php } elseif ($_SERVER['PHP_SELF'] === '/ftt_attendance.php') { ?>
    <link href="css/ftt/ftt_attendance.css?v20" rel="stylesheet">
<?php } elseif ($_SERVER['PHP_SELF'] === '/ftt_list.php') { ?>
    <link href="css/ftt/ftt_list.css?v5" rel="stylesheet">
<?php } elseif ($_SERVER['PHP_SELF'] === '/ftt_announcement.php') { ?>
    <link href="css/ftt/ftt_announcement.css?v2" rel="stylesheet">
<?php } elseif ($_SERVER['PHP_SELF'] === '/attend.php') { ?>
    <link href="css/regpage/attend.css?v2" rel="stylesheet">
<?php } elseif ($_SERVER['PHP_SELF'] === '/ftt_fellowship.php') { ?>
    <link href="css/ftt/ftt_fellowship.css?v2" rel="stylesheet">
<?php } elseif ($_SERVER['PHP_SELF'] === '/ftt_reading.php') { ?>
    <link href="css/ftt/ftt_reading.css?v2" rel="stylesheet">
<?php } ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!--<script src="js/script.js?v182" type="text/javascript"></script>-->
    <script src="js/script2.js?v18" type="text/javascript"></script>
    <script src="js/modules/footer_btm.js?v2"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <?php if ($_SERVER['PHP_SELF'] === '/index.php' || $_SERVER['PHP_SELF'] === '/members.php') { ?>

    <!-- ЧАТ -->
    <!--<link rel="stylesheet" href="https://cdn.envybox.io/widget/cbk.css">
    <script type="text/javascript" src="https://cdn.envybox.io/widget/cbk.js?wcb_code=27de0b86fa9a7c4373ae996711b6f549" charset="UTF-8" async></script>-->
    <!-- Begin Verbox {literal} -->
    <script type='text/javascript'>
      (function(d, w, m) {
        window.supportAPIMethod = m;
        var s = d.createElement('script');
        s.type ='text/javascript'; s.id = 'supportScript'; s.charset = 'utf-8';
        s.async = true;
        var id = '12a4768add017e0b93df6aa118482906';
        s.src = 'https://admin.verbox.ru/support/support.js?h='+id;
        var sc = d.getElementsByTagName('script')[0];
        w[m] = w[m] || function() { (w[m].q = w[m].q || []).push(arguments); };
        if (sc) sc.parentNode.insertBefore(s, sc);
        else d.documentElement.firstChild.appendChild(s);
      })(document, window, 'Verbox');
    </script>
    <!-- {/literal} End Verbox -->
  <?php } ?>
</head>

<body>
    <script>window.adminId=<?php echo isset ($memberId) ? "'$memberId'" : 'null'; ?>;</script>
    <div id="globalError" class="alert alert-error above-modal" style="display: none"><a class="close close-alert" href="#">&times;</a><span>AJAX ERROR</span></div>
    <div id="globalHint" class="alert alert-success above-modal" style="display: none"><a class="close close-alert" href="#">&times;</a><span>GLOBAL HINT</span></div>
    <div id="globalHelp" class="alert alert-primary above-modal" style="display: none"><a class="close close-alert" href="#">&times;</a><span>GLOBAL HELP</span></div>
    <div id="ajaxLoading" style="display: none"><img src="img/ajax_loader.gif"></div>
    <div><i class="fa fa-arrow-up fa-3x scroll-up" aria-hidden="true"></i></div>
