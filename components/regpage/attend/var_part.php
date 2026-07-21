<?php
// КОНТРОЛЛЕР СТРАНИЦЫ РАЗДЕЛА ПОСЕЩАЕМОСТЬ
// право доступа
if (THIS_PAGE === 'attend' && !IS_ZONE_ADMIN) {
  header("Location: index");
}
// Classes
// components
// db
require_once 'db/classes/members.php';
require_once 'db/classes/member.php';
require_once 'db/classes/localities.php';
require_once 'db/classes/settings.php';
include_once 'db/classes/member_properties.php';

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
$categories_list = MemberProperties::get_categories();
if (!empty($_COOKIE['flt_members_localities']) && $_COOKIE['flt_members_localities'] === '_all_') {
  $membersList = Members::getListAttend($memberId, $sort_setting[0], $sort_setting[1]);
} elseif (!empty($_COOKIE['flt_members_localities'])) {
  $membersList = Members::getListAttendByLocality($_COOKIE['flt_members_localities'], $sort_setting[0], $sort_setting[1]);
} else {
  $membersList = [];
}

$adminLocalitiesList = localities::getAdminLocalitiesWithRegMemberFilters($memberId);
$singleCity = localities::isSingleCityAdmin($memberId);

$userSettings = Settings::getUserSettings($memberId);
// Фильтр посещаемость
$flt_members_attend_array = ['Не посещают собрания', 'Посещают Господню трапезу', 'Посещают молитвенные собрания', 'Посещают групповые собрания', 'Посещают другие собрания', 'Посещают какие-либо собрания', 'Участвуют в видеообучении'];
$flt_members_attend = '_all_';
if (isset($_COOKIE['flt_members_attend']) && (!empty($_COOKIE['flt_members_attend']) || $_COOKIE['flt_members_attend'] === '0')) {
  $flt_members_attend = $_COOKIE['flt_members_attend'];
}
// Фильтр категории
$memberCategoriesFilter = [];
foreach (MemberProperties::get_categories() as $key => $value) {
  $memberCategoriesFilter[$key] = $value;
  if ($key === 'FT') {
    $memberCategoriesFilter['NF'] = 'Без обучающихся ПВОМ';
    break;
  }
}
$flt_members_category = '_all_';
if (isset($_COOKIE['flt_members_category']) && !empty($_COOKIE['flt_members_category'])) {
  $flt_members_category = $_COOKIE['flt_members_category'];
}
// Фильтр местности
$flt_members_localities = '_all_';
if (isset($_COOKIE['flt_members_localities']) && !empty($_COOKIE['flt_members_localities'])) {
  $flt_members_localities = $_COOKIE['flt_members_localities'];
}
// готовим текст для поля редакторы
function prepareDataEditors($value='')
{
  if (!empty($value->editors) && strlen($value->editors) > 9) {
    $editorsKeys = explode(',',$value->editors);
    if (isset($editorsKeys[1])) {
      $editorsText = 'Редакторы — ' . short_name::short(Member::get_name($editorsKeys[0])) . ', ' . short_name::short(Member::get_name($editorsKeys[1]));
    } else {
      $editorsText = 'Редактор — ' . short_name::short(Member::get_name($editorsKeys[0]));
    }
  } elseif(!empty($value->editors)) {
    $editorsText = 'Редактор — '. short_name::short(Member::get_name($value->editors));
  } else {
    $editorsText = '';
  }
  return $editorsText;
}
