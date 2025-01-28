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
// активная вкладка
if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['tab']) && !empty($_GET['tab'])) {
  $tabCalls = $_GET['tab'];
} else {
  if (isset($_COOKIE['tab-calls']) && !empty($_COOKIE['tab-calls'])) {
    $tabCalls = $_COOKIE['tab-calls'];
  } else {
    $tabCalls = 'incomming';
  }
}

// fitres
if ($callsUserData['male'] === '0' || $callsUserData['male'] === '1') {
  $fltGender = $callsUserData['male'];
} else {
  $fltGender = '_all_';
}

$fltSearch = '';

if ($callsUserData['role'] === '0') {
  $fltAuthor = MEMBER_ID;
} else {
  $fltAuthor = '_all_';
}
// статистика
if (isset($_COOKIE['tab-calls']) && $_COOKIE['tab-calls'] === 'statistics') {
  require_once 'db/classes/member.php';
  $tabCalls = $_COOKIE['tab-calls'];
  // фильтр дата начала
  if (isset($_COOKIE['calls-flt_date_begin']) && !empty($_COOKIE['calls-flt_date_begin'])) {
    $dateBegin = $_COOKIE['calls-flt_date_begin'];
  } else {
    $dateBegin = date_format(date_sub(date_create(date('Y-m-d')), date_interval_create_from_date_string("7 days")), 'Y-m-d');
  }
  // фильтр дата конца
  if (isset($_COOKIE['calls-flt_date_end']) && !empty($_COOKIE['calls-flt_date_end'])) {
    $dateEnd = $_COOKIE['calls-flt_date_end'];
  } else {
    $dateEnd = date('Y-m-d');
  }
  // фильтр пользователей
  if (isset($_COOKIE['calls-flt_all_users']) && !empty($_COOKIE['calls-flt_all_users'])) {
    $fltAllUsers = $_COOKIE['calls-flt_all_users'];
  } else {
    $fltAllUsers = '_all_';
  }
}

// количество записией в списке
$countStrings = 50;
if (isset($_COOKIE['calls-count']) && $_COOKIE['calls-count'] > 1) {
  $countStrings = $_COOKIE['calls-count'];
}

if (isset($_COOKIE['calls-flt_author']) && !empty($_COOKIE['calls-flt_author'])) {
  $fltAuthor = $_COOKIE['calls-flt_author'];
}

if (isset($_COOKIE['calls-flt_gender']) && ($_COOKIE['calls-flt_gender'] === "0" || $_COOKIE['calls-flt_gender'] === "1")) { //!empty($_COOKIE['calls-flt_gender']) &&
  $fltGender = $_COOKIE['calls-flt_gender'];
}

if (isset($_COOKIE['calls-flt_operator']) && !empty($_COOKIE['calls-flt_operator'])) {
  $fltOperator = $_COOKIE['calls-flt_operator'];
}

if (isset($_COOKIE['calls-flt_search']) && mb_strlen($_COOKIE['calls-flt_search']) > 2) {
  $fltSearch = $_COOKIE['calls-flt_search'];
}

// Sorting
$sort_fio_ico = '';
$sort_created_date_ico = '';
$sort_birth_date_ico = '';
$sort_setting = array('created_date', 'DESC');

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
    $sort_created_date_ico = 'fa fa-sort-desc';
  }
} else {
  $sort_created_date_ico = 'fa fa-sort-desc';
}

// вкладки
$tab_currents_active = '';
$tab_finished_active = '';
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
$callsLocalityList = localities::get_localities();
$callsCountryList = localities::get_countries();
$callsCountryListQuick = localities::get_countries(true);

// индексы для вкладок
$indexTabIncomming = CallsDB::getCountCalls();
$indexTabInWork = CallsDB::getCountCalls(MEMBER_ID);
