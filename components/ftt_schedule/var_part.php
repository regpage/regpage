<?php

  include_once 'db/classes/trainee_data.php';
  include_once 'db/classes/extra_lists.php';

// РАСПИСАНИЕ
//$schedule = getSchedule(1);
// Возможен ??? вариант сортировки $schedule array_multisort($ar[0], SORT_ASC, SORT_STRING, $ar[1], SORT_NUMERIC, SORT_DESC);
// Смортри справочник
// Обучающиеся
if ($ftt_access['group'] === 'trainee') {
  // данные обучающегося
  $trainee_data = trainee_data::get_data($memberId);
  // расписание
  $schedule_day1 = getScheduleByDay($trainee_data['semester_range'], 'day1', $trainee_data['tz_id']);
  $schedule_day2 = getScheduleByDay($trainee_data['semester_range'], 'day2', $trainee_data['tz_id']);
  $schedule_day3 = getScheduleByDay($trainee_data['semester_range'], 'day3', $trainee_data['tz_id']);
  $schedule_day4 = getScheduleByDay($trainee_data['semester_range'], 'day4', $trainee_data['tz_id']);
  $schedule_day5 = getScheduleByDay($trainee_data['semester_range'], 'day5', $trainee_data['tz_id']);
  $schedule_day6 = getScheduleByDay($trainee_data['semester_range'], 'day6', $trainee_data['tz_id']);
  $schedule_day7 = getScheduleByDay($trainee_data['semester_range'], 'day7', $trainee_data['tz_id']);
} elseif ($ftt_access['group'] === 'staff') {
  $time_zone_list = $ftt_access['staff_time_zone'];
  if (isset($_COOKIE['time_zone_select']) && !empty($_COOKIE['time_zone_select'])) {
    $time_zone_list = $_COOKIE['time_zone_select'];
  }
  //Расписание для служащих
  // 1-4 семестр
  $schedule_day1 = getScheduleByDay(1, 'day1', $time_zone_list);
  $schedule_day2 = getScheduleByDay(1, 'day2', $time_zone_list);
  $schedule_day3 = getScheduleByDay(1, 'day3', $time_zone_list);
  $schedule_day4 = getScheduleByDay(1, 'day4', $time_zone_list);
  $schedule_day5 = getScheduleByDay(1, 'day5', $time_zone_list);
  $schedule_day6 = getScheduleByDay(1, 'day6', $time_zone_list);
  $schedule_day7 = getScheduleByDay(1, 'day7', $time_zone_list);
  // 5-6 семестр
  $schedule_day1_2 = getScheduleByDay(2, 'day1', $time_zone_list);
  $schedule_day2_2 = getScheduleByDay(2, 'day2', $time_zone_list);
  $schedule_day3_2 = getScheduleByDay(2, 'day3', $time_zone_list);
  $schedule_day4_2 = getScheduleByDay(2, 'day4', $time_zone_list);
  $schedule_day5_2 = getScheduleByDay(2, 'day5', $time_zone_list);
  $schedule_day6_2 = getScheduleByDay(2, 'day6', $time_zone_list);
  $schedule_day7_2 = getScheduleByDay(2, 'day7', $time_zone_list);
  $correction_2 = getCorrectionSchedule();
}

// корректировки
$correction = getCorrectionSchedule();
$days = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];
$ftt_schedule_start = getValueFttParamByName('schedule_start');
$ftt_schedule_end = getValueFttParamByName('schedule_end');
$ftt_attendance_start = getValueFttParamByName('attendance_start');
$ftt_attendance_end = getValueFttParamByName('attendance_end');
// РАСПИСАНИЕ СТОП
?>
