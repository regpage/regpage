<?php
/*
// фильтры по умолчанию
$cookieFltListTrainee = '_all_';
$cookieFltListServingone = $memberId;
$cookieFltListCurrents = 0;
$listTraneesByStaff = [];
$listTraneesByStaffForFlt = $trainee_list;
$sortName = '';
$sortDate = "fa-sort-desc";
$sortField = 'date';
$sortType = 'desc';
if (!empty($_COOKIE['prophecy-staff_sort'])) {
  $temp = explode('-', $_COOKIE['prophecy-staff_sort']);
  if ($temp[0] === 'date') {
    $sortDate = "fa-sort-{$temp[1]}";
    $sortType = $temp[1];
  } elseif ($temp[0] === 'name') {
    $sortDate = '';
    $sortName = "fa-sort-{$temp[1]}";
    $sortField = 'name';
    $sortType = $temp[1];
  }
}
// фильтры сохранённые в куки
// фильтр обучающиеся
if (!empty($_COOKIE['prophecy_staff-flt_list_trainees'])) {
  $cookieFltListTrainee = $_COOKIE['prophecy_staff-flt_list_trainees'];
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
*/
