<?php
// подключаем запросы
include_once "db/ftt/ftt_prophecy_db.php";
include_once "db/classes/db_operations.php";
require_once 'db/classes/ftt_lists.php';
include_once 'db/classes/emailing.php';
include_once 'db/classes/member.php';
include_once 'db/classes/short_name.php';
include_once 'db/classes/date_convert.php';
include_once 'db/classes/time_convert.php';

// set line
if (isset($_GET['type']) && $_GET['type'] === 'set_line') {
  echo json_encode(["result"=>ProphecyDB::setLine(json_decode($_POST['data']))]);
  exit();
}
// get line
if (isset($_GET['type']) && $_GET['type'] === 'get_line') {
  echo json_encode(["result"=>ProphecyDB::getLine($_GET['id'])]);
  exit();
}
// remove line
if (isset($_GET['type']) && $_GET['type'] === 'dlt_line') {
  echo json_encode(["result"=>ProphecyDB::dltLine($_GET['id'])]);
  exit();
}
