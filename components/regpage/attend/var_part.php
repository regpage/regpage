<?php
// Classes
// components
// db
require_once 'db/classes/members.php';
require_once 'db/classes/member.php';
require_once 'db/classes/localities.php';
require_once 'db/classes/settings.php';
require_once 'db/classes/short_name.php';

// Sorting
$sort_fio_ico = '';
$sort_locality_ico = '';
$sort_birth_date_ico = '';
$sort_setting = array('name', 'ASC');

if (isset($_COOKIE['sorting-attend']) && !empty($_COOKIE['sorting-attend'])) {
  $sort_setting = explode('-', $_COOKIE['sorting-attend']);
  if ($_COOKIE['sorting-attend'] === 'name-desc') {
    $sort_fio_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting-attend'] === 'name-asc') {
    $sort_fio_ico = 'fa fa-sort-desc';
  } elseif ($_COOKIE['sorting-attend'] === 'locality-desc') {
    $sort_locality_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting-attend'] === 'locality-asc') {
    $sort_locality_ico = 'fa fa-sort-desc';
  } elseif ($_COOKIE['sorting-attend'] === 'age-desc') {
    $sort_birth_date_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting-attend'] === 'age-asc') {
    $sort_birth_date_ico = 'fa fa-sort-desc';
  } else {
    $sort_fio_ico = 'fa fa-sort-desc';
  }
} else {
  $sort_fio_ico = 'fa fa-sort-desc';
}

$membersList = Members::getListAttend($memberId, $sort_setting[0], $sort_setting[1]);
$adminLocalitiesList = localities::getAdminLocalities($memberId);
$singleCity = localities::isSingleCityAdmin($memberId);

$userSettings = Settings::getUserSettings($memberId);
