<?php

include_once "preheader.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-144838221-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-144838221-1');
</script>
    <meta charset="utf-8">
    <title>Страница регистрации</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Expires" content="Wed, 06 Sep 2017 16:35:12 GMT">
    <meta http-equiv="Pragma" content="no-cache">
    <!--<meta name="yandex-verification" content="56dd8d3e07b017d1" />-->
    <meta name="mailru-domain" content="z83V20hFDKLekMbc" />

    <link href="favicon.ico" rel="shortcut icon" />

    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="css/bootstrap-modal.css" rel="stylesheet" />
    <link href="css/bootstrap-datepicker.min.css" rel="stylesheet" />
    <link href="css/style.css?v76" rel="stylesheet" />
    <link href="css/style_slide.css?v2" rel="stylesheet" />

    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="js/bootstrap-modal.js" type="text/javascript"></script>
    <script src="js/jquery.mockjax.js" type="text/javascript"></script>
    <script src="js/jquery.autocomplete.js" type="text/javascript"></script> <!-- https://github.com/devbridge/jQuery-Autocomplete -->
    <script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
    <script src="js/script.js?v203" type="text/javascript"></script>
    <script src="js/jquery-textrange.js" type="text/javascript"></script>
    <script src="js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="js/bootstrap-datepicker.ru.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <?php if ($_SERVER['PHP_SELF'] === '/index.php' || $_SERVER['PHP_SELF'] === '/members.php' || $_SERVER['PHP_SELF'] === '/reg.php' || $_SERVER['PHP_SELF'] === '/meetings.php' || $_SERVER['PHP_SELF'] === '/profile.php' || $_SERVER['PHP_SELF'] === '/youth.php') { ?>
  <!--  <link rel="stylesheet" href="https://cdn.envybox.io/widget/cbk.css">
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

<body style="padding-left: 5px; padding-right: 5px;">
    <script>
    window.adminId=<?php echo isset ($memberId) ? "'$memberId'" : 'null'; ?>;
    </script>
    <div id="globalError" class="alert alert-error above-modal" style="display: none"><a class="close close-alert" href="#">&times;</a><span>AJAX ERROR</span></div>
    <div id="globalHint" class="alert alert-success above-modal" style="display: none"><a class="close close-alert" href="#">&times;</a><span>GLOBAL HINT</span></div>
    <div id="ajaxLoading" style="display: none"><img src="img/ajax_loader.gif"></div>
    <div><i class="fa fa-arrow-up fa-3x scroll-up" aria-hidden="true"></i></div>
