<?php
    date_default_timezone_set ('Europe/Moscow');
    //include_once 'logWriter.php';

    // establish mySQLi connection & database selection for realized
    $host = $_SERVER['HTTP_HOST'];
    $gl_db_user = 'regpager_admin';
    $gl_db_pass = 'inChrist365';
    // host selection
    $appRootPath = 'https://reg-page.ru/';
    if (empty($_SERVER['HTTP_HOST'])) {  // Вызов с сервера CRON
      if (dirname($_SERVER['SCRIPT_FILENAME']) === 'new-constellation.ru') {
        $gl_db_name = 'p518584_regpage';
        $gl_db_user = 'p518584_dev';
        $gl_db_pass = 'Qg8LAt3yS4';
      } elseif (dirname($_SERVER['SCRIPT_FILENAME']) === '/home/regpager/domains/reg-page.ru/public_html/dev') {
        $gl_db_name = 'regpager_dev';
      }
    } else { // вызов из браузера
      if (substr($host, 0,3) === 'dev') {
        $gl_db_name = 'regpager_dev';
        $appRootPath = 'https://dev.reg-page.ru/';
      } elseif (substr($host, 0,3) === 'reg') {
        $gl_db_name = 'regpager_main';
      } elseif (substr($host, 0,3) === 'new') {
        $gl_db_name = 'p518584_regpage';
        $gl_db_user = 'p518584_dev';
        $gl_db_pass = 'Qg8LAt3yS4';
        $appRootPath = 'https://new-constellation.ru/';
      } elseif (substr($host, 0,3) === 'tes') {
        $gl_db_name = 'ch59248_regpage';
        $gl_db_user = 'ch59248_regpage';
        $gl_db_pass = 'dCKY46xu';
        $appRootPath = 'https://test.zhichkinroman.ru/';
      } elseif (substr($host, 0,3) !== 'reg') {
        $gl_db_name = 'ch59248_regpage';
        $gl_db_user = 'ch59248_regpage';
        $gl_db_pass = 'dCKY46xu';
        $appRootPath = 'https://test.zhichkinroman.ru/';
      }
    }
    $db = new mysqli('localhost', $gl_db_user, $gl_db_pass, $gl_db_name);

    // db query settings
    $db->set_charset('utf8');
    if ($db->connect_errno) die('Could not connect: '.$mysqli->connect_error);

    // make a query to the database
    function db_query ($query) {
      global $db;
      $res=$db->query ($query);
      if (!$res) throw new Exception ($db->error);
      return $res;
    }

    function db_multiQuery ($query) {
        global $db;
        $res=$db->multi_query ($query);
        if (!$res) throw new Exception ($db->error);
        return $res;
    }
