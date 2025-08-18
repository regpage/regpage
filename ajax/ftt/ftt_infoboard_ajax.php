<?php
// подключаем запросы
include_once "db/ftt/ftt_infoboard_db.php";
/*require_once 'db/classes/ftt_lists.php';
include_once 'db/classes/emailing.php';
include_once 'db/classes/member.php';
include_once 'db/classes/short_name.php';
include_once 'db/classes/date_convert.php';
include_once 'db/classes/time_convert.php';*/

if (isset($_GET['type']) && $_GET['type'] === 'get_today') {
  // echo json_encode(["result"=>fttInfoboard::getToday()]);
  exit;
}

if (isset($_GET['type']) && $_GET['type'] === 'set_position') {
  echo json_encode(["result"=>fttInfoboard::setPosition($_GET['id'], $_POST['data'])]);
  exit;
}

if (isset($_GET['type']) && $_GET['type'] === 'get_position') {
  echo json_encode(["result"=>fttInfoboard::getPosition($_GET['id'])]);
  exit;
}

if (isset($_GET['type']) && $_GET['type'] === 'delete_position') {
  // echo json_encode(["result"=>fttInfoboard::getToday()]);
  exit;
}
