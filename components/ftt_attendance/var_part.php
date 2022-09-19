<?php

  include_once 'db/classes/trainee_data.php';
  include_once 'db/classes/short_name.php';
  include_once 'db/classes/ftt_lists.php';
  include_once 'db/classes/date_convert.php';
  include_once 'db/classes/ftt_permissions.php';
  include_once 'db/ftt/ftt_attendance_db.php';

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
if (isset($_COOKIE['flt_serving_one_permissions']) && !empty($_COOKIE['flt_serving_one_permissions'])) {
  $serving_one_permissions = $_COOKIE['flt_serving_one_permissions'];
}
$trainee_permissions = $memberId;

if (isset($_COOKIE['flt_trainee']) && !empty($_COOKIE['flt_trainee'])) {
  $trainee_permissions = $_COOKIE['flt_trainee'];
}

$flt_permission_active = "_all_";
if (isset($_COOKIE['flt_permission_active']) && (!empty($_COOKIE['flt_permission_active']) || $_COOKIE['flt_permission_active'] === '0')) {
  $flt_permission_active = $_COOKIE['flt_permission_active'];
}
?>
