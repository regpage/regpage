<?php

  include_once 'db/ftt/ftt_extra_help_db.php';
  include_once 'db/classes/trainee_data.php';
  include_once 'db/classes/short_name.php';
  include_once 'db/classes/ftt_lists.php';
  include_once 'db/classes/date_convert.php';

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

// куки
if (isset($_GET['my']) && isset($_COOKIE['sevice_one_select'])) {
  $_COOKIE['sevice_one_select'] = $memberId;
}

if (isset($_GET['my']) && isset($_COOKIE['trainee_select'])) {
  $_COOKIE['trainee_select'] = '_all_';
}

if (isset($_GET['my']) && isset($_COOKIE['semesters_select'])) {
  $_COOKIE['semesters_select'] = '_all_';
}

if (isset($_GET['my']) && isset($_COOKIE['tasks_select'])) {
  $_COOKIE['tasks_select'] = '0';
}
$tab_main = 'active';
$tab_stat = '';

if (isset($_COOKIE['tab_stat']) && $_COOKIE['tab_stat'] === 'active') {
  $tab_main = '';
  $tab_stat = 'active';
}
//$days = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];

// ПОСЕЩАЕМОСТЬ СТОП
