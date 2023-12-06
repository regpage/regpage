<?php
// РАЗДЕЛ
// DB
//include_once 'db/ftt/ftt_list_db.php';
// Classes
//include_once 'db/classes/members.php';

// Списки
// $serving_ones_list_full = ftt_lists::serving_ones_full();
// $trainee_list_full = ftt_lists::trainee_full();

include_once "header.php";
include_once "nav.php";
include_once "db/statisticdb.php";

$hasMemberRightToSeePage = db_isAdmin($memberId);
if(!$hasMemberRightToSeePage){
    die();
}
$localityStatus = db_getLocalitiesStatus();
$localities = db_getAdminMeetingLocalities($memberId);
$isSingleCity = db_isSingleCityAdmin($memberId);
$adminLocality = db_getAdminLocality($memberId);
$periodActual = db_getPeriodActual();
$allPeriods = db_getAllPeriods();
$periodInterval = db_getPeriodInterval();
// COOKIES
//$selStatisticLocality = isset ($_COOKIE['selStatisticLocality']) ? $_COOKIE['selStatisticLocality'] : '_all_';
//$sort_field = isset ($_COOKIE['sort_field_statistic']) ? $_COOKIE['sort_field_statistic'] : 'id';
//$sort_type = isset ($_COOKIE['sort_type_statistic']) ? $_COOKIE['sort_type_statistic'] : 'desc';
$sort_field = 'id';
$sort_type = 'desc';
