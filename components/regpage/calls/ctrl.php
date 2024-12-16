<?php
$callsUserData = Access::callsRole($memberId);
// право доступа
if (empty($callsUserData)) {
  header("Location: index");
}
// classes
require_once 'db/classes/localities.php';
// db
require_once 'db/regpage/calls_db.php';

if (isset($_COOKIE['tab-calls']) && !empty($_COOKIE['tab-calls'])) {
  $tabCalls = $_COOKIE['tab-calls'];
} else {
  $tabCalls = 'incomming';
}

// Sorting
$sort_fio_ico = '';
$sort_locality_ico = '';
$sort_birth_date_ico = '';
$sort_setting = array('name', 'ASC');

if (isset($_COOKIE['sorting-calls']) && !empty($_COOKIE['sorting-calls'])) {
  $sort_setting = explode('-', $_COOKIE['sorting-calls']);
  if ($_COOKIE['sorting-calls'] === 'm.name-desc') {
    $sort_fio_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting-calls'] === 'm.name-asc') {
    $sort_fio_ico = 'fa fa-sort-desc';
  } elseif ($_COOKIE['sorting-calls'] === 'c.locality-desc') {
    $sort_locality_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting-calls'] === 'c.locality-asc') {
    $sort_locality_ico = 'fa fa-sort-desc';
  } elseif ($_COOKIE['sorting-calls'] === 'c.status-desc') {
    $sort_status_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting-calls'] === 'c.status-asc') {
    $sort_status_ico = 'fa fa-sort-desc';
  } elseif ($_COOKIE['sorting-calls'] === 'operator_name-desc') {
    $sort_operator_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting-calls'] === 'operator_name-asc') {
    $sort_operator_ico = 'fa fa-sort-desc';
  } else {
    $sort_fio_ico = 'fa fa-sort-desc';
  }
} else {
  $sort_fio_ico = 'fa fa-sort-desc';
}

if (false) {
  // вкладка в работе

} elseif (false) {
  // вкладка завершённые

} elseif (false) {
  // вкладка статистика

} else {
  // вкладка входящие

}

$callsUsersList = CallsDB::getUsers();
$callsLocalityList = localities::get_localities();
$callsCountryList = localities::get_countries();
$callsCountryListQuick = localities::get_countries(true);
