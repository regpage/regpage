<?php
// фильтры по умолчанию
$cookieFltListTrainee = '_all_';
$cookieFltListWeeks = '_all_';
$cookieFltListServingone = $memberId;
$cookieFltListCurrents = 0;
$listTraneesByStaff = [];
$listTraneesByStaffForFlt = $trainee_list;
// фильтры сохранённые в куки
// фильтр обучающиеся
if (!empty($_COOKIE['prophecy_staff-flt_list_trainees'])) {
  $cookieFltListTrainee = $_COOKIE['prophecy_staff-flt_list_trainees'];
}
// фильтр недели
if (!empty($_COOKIE['prophecy_staff-flt_list_weeks'])) {
  $cookieFltListWeeks = $_COOKIE['prophecy_staff-flt_list_weeks'];
}
// фильтр служащие
if (!empty($_COOKIE['prophecy_staff-flt_list_servingone'])) {
  $cookieFltListServingone = $_COOKIE['prophecy_staff-flt_list_servingone'];
  if ($cookieFltListServingone !== '_all_') {
    $listTraneesByStaff = ftt_lists::get_trainees_by_staff($cookieFltListServingone);
    $listTraneesByStaffForFlt = $listTraneesByStaff;
  }
} else {
  $listTraneesByStaff = ftt_lists::get_trainees_by_staff($cookieFltListServingone);
  $listTraneesByStaffForFlt = $listTraneesByStaff;
}
// фильтр текущие
if (!empty($_COOKIE['prophecy_staff-flt_list_currents'])) {
  $cookieFltListCurrents = $_COOKIE['prophecy_staff-flt_list_currents'];
}

// список недель
$weeks = [];
for ($i = 1; $i <= 24 ; $i++) {
  $weeks[$i] = "Неделя {$i}";
}
