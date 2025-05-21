<?php
// фильтры по умолчанию
$cookieFltListTrainee = '_all_';
$cookieFltListWeeks = '_all_';
// фильтры сохранённые в куки
if (!empty($_COOKIE['prophecy_staff-flt_list_trainees'])) {
  $cookieFltListTrainee = $_COOKIE['prophecy_staff-flt_list_trainees'];
}
if (!empty($_COOKIE['prophecy_staff-flt_list_weeks'])) {
  $cookieFltListWeeks = $_COOKIE['prophecy_staff-flt_list_weeks'];
}
// список недель
$weeks = [];
for ($i = 1; $i <= 24 ; $i++) {
  $weeks[$i] = "Неделя {$i}";
}
