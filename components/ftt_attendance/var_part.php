<?php

  include_once 'db/classes/trainee_data.php';
  include_once 'db/classes/short_name.php';
  include_once 'db/classes/ftt_lists.php';
  include_once 'db/classes/date_convert.php';
  include_once 'db/classes/ftt_permissions.php';
  include_once 'db/classes/statistics.php';
  include_once 'db/ftt/ftt_attendance_db.php';
  include_once 'db/ftt/ftt_attendance_skip_db.php';
  include_once 'db/ftt/ftt_attendance_meet_db.php';

// ПОСЕЩАЕМОСТЬ
// access
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

//Это МОЖНО ВЫНЕСТИ В ОБЩИЙ СКРИПТ ДЛЯ ВСЕХ РАЗДЕЛОВ
if ($ftt_access['group'] === 'staff' || $serving_trainee) {
  $serving_ones_list_full = ftt_lists::serving_ones_full();
  $trainee_list_full = ftt_lists::trainee_full();
  $serving_ones_list = ftt_lists::serving_ones();
  $trainee_list = ftt_lists::trainee();

} elseif ($ftt_access['group'] === 'trainee') {
  // СЛУЖАЩИЕ
  $serving_ones_list = ftt_lists::serving_ones();
  $trainee_list = ftt_lists::trainee();
  $serving_ones_list_full = ftt_lists::serving_ones_full();
  $trainee_list_full = ftt_lists::trainee_full();
  // ОБУЧАЮЩИЕСЯ
}

$serving_trainee_disabled = '';
$serving_trainee_hide = '';
$serving_trainee_selected = '';
if ($serving_trainee) {
  $serving_trainee_disabled = 'disabled';
  $serving_trainee_checked = 'checked';
  $serving_trainee_selected = 'selected';
}
// корректировки

//$days = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];

// ПОСЕЩАЕМОСТЬ СТОП

// ЛИСТЫ ОТСУТСТВИЯ СТАРТ
$serving_one_permissions = $memberId;
if (isset($_COOKIE['flt_sevice_one_permissions']) && !empty($_COOKIE['flt_sevice_one_permissions'])) {
  $serving_one_permissions = $_COOKIE['flt_sevice_one_permissions'];
}
$trainee_permissions = $memberId;

if (isset($_GET['pb'])) {
  $serving_one_permissions = '_all_';
}

if (isset($_COOKIE['flt_trainee']) && !empty($_COOKIE['flt_trainee'])) {
  $trainee_permissions = $_COOKIE['flt_trainee'];
}

$flt_permission_active = "1";
if (isset($_COOKIE['flt_permission_active']) && (!empty($_COOKIE['flt_permission_active']) || $_COOKIE['flt_permission_active'] === '0')) {
  $flt_permission_active = $_COOKIE['flt_permission_active'];
}

$tab_attendance_active = 'active';
$tab_permission_active = '';
$tab_missed_class_active = '';
$tab_meet_active = '';
if (isset($_COOKIE['tab_active']) && $_COOKIE['tab_active'] === 'permission') {
  $tab_attendance_active = '';
  $tab_permission_active = 'active';
  $tab_missed_class_active = '';
  $tab_meet_active = '';
} elseif (isset($_COOKIE['tab_active']) && $_COOKIE['tab_active'] === 'missed_class') {
  $tab_attendance_active = '';
  $tab_permission_active = '';
  $tab_missed_class_active = 'active';
  $tab_meet_active = '';
} elseif (isset($_COOKIE['tab_active']) && $_COOKIE['tab_active'] === 'meet') {
  $tab_attendance_active = '';
  $tab_permission_active = '';
  $tab_missed_class_active = '';
  $tab_meet_active = 'active';
}

if (isset($_GET['pb'])) {
  $tab_attendance_active = '';
  $tab_permission_active = 'active';
  $tab_missed_class_active = '';
  $tab_meet_active = '';
} elseif (isset($_GET['mc'])) {
  $tab_attendance_active = '';
  $tab_permission_active = '';
  $tab_missed_class_active = 'active';
  $tab_meet_active = '';
}

$serving_one_selected = $memberId;
if (isset($_COOKIE['filter_serving_one']) && $_COOKIE['filter_serving_one']) {
  $serving_one_selected = $_COOKIE['filter_serving_one'];
}

if (isset($_GET['my'])) {
  $tab_attendance_active = 'active';
  $tab_permission_active = '';
  $tab_missed_class_active = '';
  $tab_meet_active = '';
  $serving_one_selected = $memberId;
}

// statistics
$permission_stat_count;
$permission_statistics = '';
$missed_class_statistics = '';
if ($ftt_access['group'] === 'staff') {
  $permission_stat_count = statistics::permission_count(ftt_lists::get_trainees_by_staff($serving_one_permissions));
  $missed_class_count = statistics::missed_class_count(ftt_lists::get_trainees_by_staff($memberId));
} else {
  $permission_stat_count = statistics::permission_count($memberId);
  $missed_class_count = statistics::missed_class_count($memberId);
}
if ($permission_stat_count > 0) {
  $permission_statistics = "<sup style='color: red;'> <b> {$permission_stat_count}</b></sup>";
}

if ($missed_class_count > 0) {
  $missed_class_statistics = "<sup style='color: red;'> <b> {$missed_class_count}</b></sup>";
}

$status_list = array(0 => ['secondary','не отправлен'], 1 => ['warning','на рассмотрении'], 2 => ['success','одобрен'], 3 => ['danger','отклонён']);
$skip_status_list = array(0 => ['secondary','не отправлен'], 1 => ['warning','на рассмотрении'], 2 => ['success','выполнено'], 3 => ['danger','отклонён']);
?>
