<?php
  // СПИСОК ПВОМ
  // DB
  include_once 'db/ftt/ftt_list_db.php';
  // Classes
  include_once 'db/classes/localities.php';
  include_once 'db/classes/member_properties.php';
  include_once 'db/classes/members.php';
  //include_once 'db/classes/ftt_info.php';

// access
if ($ftt_access['group'] !== 'staff' && $ftt_access['group'] !== 'trainee') {
  exit();
}

// данные обучающегося
$trainee_data = trainee_data::get_data($memberId);
$serving_trainee = '';
// служащие из обучающихся
if (isset($ftt_access['ftt_service']) && $ftt_access['ftt_service'] === '06') {
  $serving_trainee = 1;
}

// Координатор
if (isset($trainee_data['coordinator']) && $trainee_data['coordinator'] === '1' && $ftt_access['ftt_service'] !== '06') {
  $serving_trainee = 1;
}


$serving_ones_list = ftt_lists::serving_ones();
// $serving_ones_list_full = ftt_lists::serving_ones_full();
$serving_ones_list_list = ftt_lists::serving_ones_list();

$trainee_list = ftt_lists::trainee();
// $trainee_list_full = ftt_lists::trainee_full();
$trainee_list_list = ftt_lists::trainee_list();

$categories_list = MemberProperties::get_categories();
// список из зоны ответственности админа
// Ислючить при запросе тех кто в списке обучающихся
// Members::db_get_members_by_admin('000001679');
$localities = [];
$localities_staff = [];

foreach ($trainee_list_list as $key => $value) {
  $localities[$value['locality_key']] = $value['locality_name'];
}

foreach ($serving_ones_list_list as $key => $value) {
  $localities_staff[$value['locality_key']] = $value['locality_name'];
}

// СОРТИРОВКИ
// Местности
asort($localities);
asort($localities_staff);

// Списки
// Обучающиеся
$sort_icon = "<i class='fa fa-caret-down'></i>";
$sort_field = "name";
if (isset($_COOKIE['sorting']) && isset($_COOKIE['desc']) && $_COOKIE['desc'] === "1") {
  $sort_field = $_COOKIE['sorting'];
  usort($trainee_list_list, function ($item1, $item2) {
      return $item1[$_COOKIE['sorting']] <=> $item2[$_COOKIE['sorting']];
  });
} else if (isset($_COOKIE['sorting']) && isset($_COOKIE['desc']) && $_COOKIE['desc'] === "0") {
  $sort_field = $_COOKIE['sorting'];
  $sort_icon = "<i class='fa fa-caret-up'></i>";
  usort($trainee_list_list, function ($item1, $item2) {
      return $item2[$_COOKIE['sorting']] <=> $item1[$_COOKIE['sorting']];
  });
}

// Служащие
$sort_icon_staff = "<i class='fa fa-caret-down'></i>";
$sort_field_staff = "name";
if (isset($_COOKIE['sorting_staff']) && isset($_COOKIE['desc_staff']) && $_COOKIE['desc_staff'] === "1") {
  $sort_field_staff = $_COOKIE['sorting_staff'];
  usort($serving_ones_list_list, function ($item1, $item2) {
      return $item1[$_COOKIE['sorting_staff']] <=> $item2[$_COOKIE['sorting_staff']];
  });
} else if (isset($_COOKIE['sorting_staff']) && isset($_COOKIE['desc_staff']) && $_COOKIE['desc_staff'] === "0") {
  $sort_field_staff = $_COOKIE['sorting_staff'];
  $sort_icon_staff = "<i class='fa fa-caret-up'></i>";
  usort($serving_ones_list_list, function ($item1, $item2) {
      return $item2[$_COOKIE['sorting_staff']] <=> $item1[$_COOKIE['sorting_staff']];
  });
}

$tab_active = "tab_trainee";

if (isset($_COOKIE['tab_selected'])) {
  $tab_active = $_COOKIE['tab_selected'];
}

?>
