<?php
// Classes
require_once 'db/classes/members.php';
// Sorting
$sort_fio_ico = '';
$sort_locality_ico = '';
$sort_setting = array('name', 'ASC');

if (isset($_COOKIE['sorting_attend'])) {
  $sort_setting = explode('-', $_COOKIE['sorting']);
  if ($_COOKIE['sorting_attend'] === 'name-desc') {
    $sort_fio_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting_attend'] === 'name-asc') {
    $sort_fio_ico = 'fa fa-sort-desc';
  } elseif ($_COOKIE['sorting_attend'] === 'locality-desc') {
    $sort_locality_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting_attend'] === 'locality-asc') {
    $sort_locality_ico = 'fa fa-sort-desc';
  } else {
    $sort_fio_ico = 'fa fa-sort-asc';
  }
} else {
  $sort_fio_ico = 'fa fa-sort-desc';
}

$membersList = Members::getListAttend($memberId, $sort_setting[0], $sort_setting[1]);
