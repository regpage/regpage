<?php
// подключаем запросы
include_once "db/ftt/ftt_infoboard_db.php";
require_once 'db/classes/ftt_lists.php';
include_once 'db/classes/emailing.php';
include_once 'db/classes/member.php';
include_once 'db/classes/short_name.php';
include_once 'db/classes/date_convert.php';
include_once 'db/classes/time_convert.php';

if (isset($_GET['condition']) && $_GET['condition'] = 'today') {
  // echo json_encode(["result"=>fttInfoboard::getToday()]);
  exit;
}

if (isset($_GET['condition']) && $_GET['condition'] = 'set') {
  // echo json_encode(["result"=>fttInfoboard::getToday()]);
  exit;
}

if (isset($_GET['condition']) && $_GET['condition'] = 'get') {
  // echo json_encode(["result"=>fttInfoboard::getToday()]);
  exit;
}

if (isset($_GET['condition']) && $_GET['condition'] = 'delete') {
  // echo json_encode(["result"=>fttInfoboard::getToday()]);
  exit;
}
