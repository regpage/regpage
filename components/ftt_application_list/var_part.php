<?php
require_once "preheader.php";
include_once "header2.php";
include_once "nav2.php";
include_once "db/ftt/ftt_db.php";
include_once 'db/classes/ftt_applications/ftt_candidates.php';
// Classes components
include_once 'components/ftt_blocks/RenderList.php';

// Проверка прав пользователя.
// служащий ПВОМ
$accessToPage = 0;
// Права
include_once "db/modules/ftt_page_access.php";
// sort cookie

$sort_fio_ico = 'hide_element';
$sort_locality_ico = 'hide_element';

$sort_fio_g_ico = 'hide_element';
$sort_locality_g_ico = 'hide_element';

if (isset($_COOKIE['sorting'])) {
  if ($_COOKIE['sorting'] === 'sort_fio-desc') {
    $sort_fio_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting'] === 'sort_fio-asc') {
    $sort_fio_ico = 'fa fa-sort-desc';
  } elseif ($_COOKIE['sorting'] === 'sort_locality-desc') {
    $sort_locality_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting'] === 'sort_locality-asc') {
    $sort_locality_ico = 'fa fa-sort-desc';
  } else {
    $sort_fio_ico = 'fa fa-sort-asc';
  }
} else {
  $sort_fio_ico = 'fa fa-sort-desc';
}

if (isset($_COOKIE['sorting_g'])) {
  if ($_COOKIE['sorting_g'] === 'sort_fio-desc') {
    $sort_fio_g_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting_g'] === 'sort_fio-asc') {
    $sort_fio_g_ico = 'fa fa-sort-desc';
  } elseif ($_COOKIE['sorting_g'] === 'sort_locality-desc') {
    $sort_locality_g_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['sorting_g'] === 'sort_locality-asc') {
    $sort_locality_g_ico = 'fa fa-sort-desc';
  } else {
    $sort_fio_g_ico = 'fa fa-sort-asc';
  }
} else {
  $sort_fio_g_ico = 'fa fa-sort-desc';
}
