<?php
// подключаем модель подраздела
if (isset($GLOBALS['global_root_path'])) {
  include_once 'panelsource/content/ftt/fellowship_db.php';
} else {
  include_once '../../../config.php';
  include_once 'fellowship_db.php';
  include_once '../../../ajax/ajax_2.php';
}
// ajax запросы раздела
if (isset($_GET['type'])) {
  if ($_GET['type'] === 'dlt_all') {
    $result = db_dltFttFellowshipTmpl('_all_');
    echo $result;
    exit;
  } elseif ($_GET['type'] === 'dlt') {
    $result = db_dltFttFellowshipTmpl($_GET['member_key'], $_GET['day'], $_GET['time'], $_GET['duration']);
    echo $result;
    exit;
  } elseif ($_GET['type'] === 'set') {

    exit;
  } elseif ($_GET['type'] === 'add') {

    exit;
  }
}

// контроллер раздела
// получаем все шаблоны
$fttFellowshipTmpl = db_getFttFellowshipTmpl();
