<?php
    date_default_timezone_set ('Europe/Moscow');
    //include_once 'logWriter.php';

    // establish mySQLi connection & database selection for realized
    $host = $_SERVER['HTTP_HOST'];
    $gl_db_name = 'regpager_main';
    $gl_db_user = 'regpager_admin';
    $gl_db_pass = 'inChrist365';
    // host selection
    $appRootPath = 'https://reg-page.ru/';
    if (empty($_SERVER['HTTP_HOST'])) {  // Вызов с сервера CRON
      if (dirname($_SERVER['SCRIPT_FILENAME']) === 'test.new-constellation.ru') {
        $gl_db_name = 'u0654376_regpage';
        $gl_db_user = 'u0654_admin';
        $gl_db_pass = 'K9z?n0c1';
      } elseif (dirname($_SERVER['SCRIPT_FILENAME']) === '/home/regpager/domains/reg-page.ru/public_html/dev') {
        $gl_db_name = 'regpager_dev';
      }
    } else { // вызов из браузера      
      if (substr($host, 0,3) === 'dev') {
        $gl_db_name = 'regpager_dev';
        $appRootPath = 'https://dev.reg-page.ru/';
      } elseif (substr($host, 0,4) === 'test') {
        $gl_db_name = 'u0654376_regpage';
        $gl_db_user = 'u0654_admin';
        $gl_db_pass = 'K9z?n0c1';
        $appRootPath = 'https://test.new-constellation.ru/';
      }
    }
    $db = new mysqli('localhost', $gl_db_user, $gl_db_pass, $gl_db_name);
    // Ниже хостинг разработчика
    //$db = new mysqli('localhost', "u0654_admin", "K9z?n0c1", "u0654376_regpage");

    // Ниже хостинг разработчика
    //$appRootPath = 'https://test.new-constellation.ru/';

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
