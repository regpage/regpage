<?php
$callsUserData = Access::callsRole($memberId);
// право доступа
if (empty($callsUserData)) {
  header("Location: index");
}
// classes
require_once 'db/classes/localities.php';
require_once 'db/classes/CutString.php';

// db
require_once 'db/regpage/calls_db.php';

if (isset($_COOKIE['tab-calls']) && !empty($_COOKIE['tab-calls'])) {
  $tabCalls = $_COOKIE['tab-calls'];
} else {
  $tabCalls = 'incomming';
}

// fitres
$fltGender = '_all_';
$fltSearch = '';

if ($callsUserData['role'] === '1') {
  $fltAuthor = MEMBER_ID;
} else {
  $fltAuthor = '_all_';
}

if (isset($_COOKIE['calls-flt_author']) && !empty($_COOKIE['calls-flt_author'])) {
  $fltAuthor = $_COOKIE['calls-flt_author'];
}

if (isset($_COOKIE['calls-flt_gender']) && $callsUserData['male'] === '1') {
  $fltGender = $_COOKIE['calls-flt_gender'];
}

if (isset($_COOKIE['calls-flt_search']) && mb_strlen($_COOKIE['calls-flt_search']) > 2) {
  $fltSearch = $_COOKIE['calls-flt_search'];
}

// Sorting
$sort_fio_ico = '';
$sort_created_date_ico = '';
$sort_birth_date_ico = '';
$sort_setting = array('name', 'ASC');

if (isset($_COOKIE['sorting-calls']) && !empty($_COOKIE['sorting-calls'])) {
  $sort_setting = explode('-', $_COOKIE['sorting-calls']);
  if ($_COOKIE['sorting-calls'] === 'c.name-desc') {
    $sort_fio_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting-calls'] === 'c.name-asc') {
    $sort_fio_ico = 'fa fa-sort-desc';
  } elseif ($_COOKIE['sorting-calls'] === 'c.created_date-desc') {
    $sort_created_date_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting-calls'] === 'c.created_date-asc') {
    $sort_created_date_ico = 'fa fa-sort-desc';
  }/* elseif ($_COOKIE['sorting-calls'] === 'c.status-desc') {
    $sort_status_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting-calls'] === 'c.status-asc') {
    $sort_status_ico = 'fa fa-sort-desc';
  } elseif ($_COOKIE['sorting-calls'] === 'operator_name-desc') {
    $sort_operator_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting-calls'] === 'operator_name-asc') {
    $sort_operator_ico = 'fa fa-sort-desc';
  } */else {
    $sort_fio_ico = 'fa fa-sort-desc';
  }
} else {
  $sort_fio_ico = 'fa fa-sort-desc';
}

// вкладки
$tab_currents_active = '';
$tab_finfshed_active = '';
$tab_statistics_active = '';
$tab_incomming_active = '';

if ($tabCalls === 'currents') { // вкладка в работе
  $tab_currents_active = 'active';
} elseif ($tabCalls === 'finished') { // вкладка завершённые
  $tab_finished_active = 'active';
} elseif ($tabCalls === 'statistics') { // вкладка статистика
  $tab_statistics_active = 'active';
} else { // вкладка входящие
  $tab_incomming_active = 'active';
}

$callsUsersList = CallsDB::getUsers();
//$callsLocalityList = localities::get_localities();
//$callsCountryList = localities::get_countries();
//$callsCountryListQuick = localities::get_countries(true);
