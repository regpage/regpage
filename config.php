<?php
    date_default_timezone_set ("Europe/Moscow");
    //include_once 'logWriter.php';

    // establish mySQLi connection & database selection
    $host = $_SERVER['HTTP_HOST'];
    $db = new mysqli('localhost', "regpager_admin", "inChrist365", (substr($host, 0,3) === 'dev' ? "regpager_dev" : "regpager_main"));
    // Ниже хостинг разработчика
    //$db = new mysqli('localhost', "u0654_admin", "K9z?n0c1", "u0654376_regpage");

    // host selection
     $appRootPath = substr($host, 0,3) === 'dev' ? 'https://dev.reg-page.ru/' : 'https://reg-page.ru/';
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
