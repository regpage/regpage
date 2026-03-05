<?php
// файл для гитхаба
echo "wrong config";
exit;
    date_default_timezone_set ('Europe/Moscow');
    //include_once 'logWriter.php';

    // establish mySQLi connection & database selection for realized
    $host = $_SERVER['HTTP_HOST'];
    $gl_db_name = '';
    $gl_db_user = '';
    $gl_db_pass = '';
    // host selection
    $appRootPath = 'https://reg-page.ru/';
    if (empty($_SERVER['HTTP_HOST'])) {  // Вызов с сервера CRON
      if (dirname($_SERVER['SCRIPT_FILENAME']) === '') {
        $gl_db_name = '';
        $gl_db_user = '';
        $gl_db_pass = '';
      } elseif (dirname($_SERVER['SCRIPT_FILENAME']) === '') {
        $gl_db_name = '';
      }
    } else { // вызов из браузера
      if (substr($host, 0,3) === '') {
        $gl_db_name = '';
        $appRootPath = '';
      } elseif (substr($host, 0,3) === '') {
        $gl_db_name = '';
      } elseif (substr($host, 0,3) === '') {
        $gl_db_name = '';
        $gl_db_user = '';
        $gl_db_pass = '';
        $appRootPath = '';
      }
    }

    // Подключение.
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

    function db_queryKeyValue ($query, $keyField, $valueField) {
      // , hundler можно передавать имя функции, метода обработчика $valueField например 'short_name::no_middle'
      // или использовать встренную MySQL функцию для этого
      $res = db_query($query);

      while ($row = $res->fetch_assoc()) $result[$row[$keyField]]=$row[$valueField];
      return $result;
    }

    function db_multiQuery ($query) {
        global $db;
        $res=$db->multi_query ($query);
        if (!$res) throw new Exception ($db->error);
        return $res;
    }

    // Обезвреживание содержимого переданного аргумента.
    function db_real_escape_string($data) {
      /*if ($data === null) {
        $data = '';
      }*/
      global $db;
      return $db->real_escape_string($data);
    }

// mail
$mailCnfg = [
  'host' => '',
  'username' => '',
  'password' => '',
  'port' =>
];
