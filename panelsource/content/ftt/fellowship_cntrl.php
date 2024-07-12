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
    echo db_dltFttFellowshipTmpl('_all_');
    exit;
  } elseif ($_GET['type'] === 'dlt') {
    echo db_dltFttFellowshipTmpl($_GET['member_key'], $_GET['day'], $_GET['time'], $_GET['duration']);
    exit;
  } elseif ($_GET['type'] === 'set') {
    echo db_updFttFellowshipTmpl($_GET['member_key'], $_GET['day'], $_GET['time'], $_GET['duration'], $_GET['cond_member_key'], $_GET['cond_day'], $_GET['cond_time'], $_GET['cond_duration']);
    exit;
  } elseif ($_GET['type'] === 'add') {
    echo db_addFttFellowshipTmpl($_GET['member_key'], $_GET['day'], $_GET['time'], $_GET['duration']);
    exit;
  }
}

// контроллер раздела
$fellowship_serving_one_list = ftt_lists::get_fellowship_list();
// получаем все шаблоны
$fttFellowshipTmpl = db_getFttFellowshipTmpl();
