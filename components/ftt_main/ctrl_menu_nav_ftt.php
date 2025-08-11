<?php
include_once 'db/classes/statistics.php';
include_once 'db/classes/ftt_lists.php';
include_once 'db/classes/ftt_fellowship/fellowship.php';

// получаем обучающихся служащего
$gl_trainees_by_staff = [];
if ($ftt_access['group'] === 'staff') {
  $gl_trainees_by_staff = ftt_lists::get_trainees_by_staff($memberId);
}

// счётчик доп заданий в меню
$other_count = 0;
$extra_help_text = 'Доп. задания';
if ($ftt_access['group'] === 'trainee'){
  $extra_help_count = statistics::extra_help_count($memberId);
} elseif ($ftt_access['group'] === 'staff'){
  $extra_help_count = statistics::extra_help_count($gl_trainees_by_staff);
}
if ($extra_help_count == 0) {
  $extra_help_count = '';
} else {
  $other_count = $extra_help_count;
}
$extra_help_text .= "<sup style='color: red;'> <b> {$extra_help_count}</b></sup>";
// уведомление если 3 или более доп. помощи
$warning_extra_help_text = '';
if ($extra_help_count >= 3 && $ftt_access['group'] === 'trainee') {
  $warning_extra_help_text = "<strong class='warning_notice' style='color: red; padding: 7px 10px 10px 16px; display: inline-block;'>Дополнительных заданий — {$extra_help_count} </strong>";
}

// счётчик разрешений в меню
// счётчик проп. занятий в меню (в одном индексе с разрешениями)
$permission_stat_count_main_text = 'Посещаемость';
if ($ftt_access['group'] === 'staff') {
  $permission_stat_count_main = statistics::permission_count($gl_trainees_by_staff);
  $missed_class_count_menu = statistics::missed_class_count(ftt_lists::get_trainees_by_staff($memberId));
} else {
  $permission_stat_count_main = statistics::permission_count($memberId);
  $missed_class_count_menu = statistics::missed_class_count($memberId);
}
$permission_stat_count_main += $missed_class_count_menu;
if ($permission_stat_count_main == 0) {
  $permission_stat_count_main = '';
}

$permission_stat_count_main_text .= "<sup style='color: red;'> <b> {$permission_stat_count_main}</b></sup>";
// уведомление если 3 или более проп. занятиях
$warning_missed_class_text = '';
if ($missed_class_count_menu >= 3 && $ftt_access['group'] === 'trainee') {
  $warning_missed_class_text = "<strong class='warning_notice' style='color: red; padding: 7px 10px 10px 16px; display: inline-block;'>Пропущенных занятий — {$missed_class_count_menu} </strong>";
}
// счётчик объявлений в меню
$announcement_unread_count_text = 'Объявления';
$announcement_unread_count = statistics::announcement_unread($memberId);
if ($announcement_unread_count == 0) {
  $announcement_unread_count = '';
}
$announcement_unread_count_text .= "<sup style='color: red;'> <b> {$announcement_unread_count}</b></sup>";

// счётчик запросов заявлений на ПВОМ
$requests_for_application_text = 'Заявления';
$requests_for_application_count = statistics::requests();
if ($requests_for_application_count == 0) {
  $requests_for_application_count = '';
} else {
  if ($ftt_access['group'] === 'staff') {
    $other_count += $requests_for_application_count;
  }
}
if (!$other_count) {
  $other_count = '';
} else {
  $other_count = "<sup style='color: red;'> <b> {$other_count}</b></sup>";
}
$requests_for_application_text .= "<sup style='color: red;'> <b> {$requests_for_application_count}</b></sup>";

// Общение индекс для пункта в меню
$indexStaffFellowshipText = 'Общение';
if ($ftt_access['group'] === 'staff') { // Индекс будущих и текущих общение для служащих
  $indexStaffFellowship = Fellowship::get_all_fellowship_today_future($memberId);
} elseif ($ftt_access['group'] === 'trainee') { // Индекс будущих и текущих общение для обучающихся
  $indexStaffFellowship = Fellowship::get_all_fellowship_today_future_trainee($memberId);
}
if ($indexStaffFellowship > 0) {
  $indexStaffFellowshipText .= "<sup style='color: red;'> <b> {$indexStaffFellowship}</b></sup>";
}
$ftt_devisions = array('ftt_schedule' => 'Расписание', 'ftt_announcement' => $announcement_unread_count_text,
'ftt_attendance' => $permission_stat_count_main_text, 'ftt_prophecy' => 'Пророчество', 'ftt_fellowship' => $indexStaffFellowshipText, 'ftt_service' => 'Служение', 'ftt_gospel' => 'Благовестие', 'ftt_extrahelp' => $extra_help_text, 'ftt_reading' => 'Чтение','ftt_application' => $requests_for_application_text,'ftt_infoboard' => 'Информационный экран'); // 'contacts' => 'Контакты',
if ($ftt_access['group'] === 'staff') { //

}
//$_SERVER['PHP_SELF'];
if ($ftt_access['group'] === 'trainee') {
  unset($ftt_devisions['ftt_application']);
  unset($ftt_devisions['ftt_infoboard']);
  // Общение на сегодня
  $fellowship_today = Fellowship::now_trainee($memberId);
  $fellowship_text = '';
  $fellowship_text_name = '';
  $fellowship_link = "<span class='link_custom fellowship_link' style='display: inline-block; font-weight: normal;'> перейти в раздел</span><br>";
  // Добавить отменённые, добавить для служащих. Продублировать в меню раздела пвом
  foreach ($fellowship_today as $key => $value) {
    $name_f = short_name::short($value['name']);
    if (empty($fellowship_text_name)) {
      $fellowship_text_name .= $name_f;
    } else {
      $fellowship_text_name .= ', ' . $name_f;
    }
  }
  if (count($fellowship_today) > 0) {
    $fellowship_text = "<strong class='fellowship_today' style='color: red; padding: 7px 10px 0px 16px; display: inline-block;'>Сегодня общение:  {$fellowship_text_name} </strong>";
  }

  $fellowship_cancel_today = Fellowship::canceled_trainee($memberId);
  $fellowship_cancel_text = '';
  $fellowship_cancel_text_name = '';

  foreach ($fellowship_cancel_today as $key => $value) {
    $name_c = short_name::short($value['name']);
    if (empty($fellowship_cancel_text_name)) {
      $fellowship_cancel_text_name .= $name_c;
    } else {
      $fellowship_cancel_text_name .= ', ' . $name_c;
    }
  }
  if (count($fellowship_cancel_today) > 0) {
    $fellowship_cancel_text = "<strong class='fellowship_today' style='color: red; padding: 7px 10px 10px 16px; display: inline-block;'>Отменено общение:  {$fellowship_cancel_text_name} </strong>";
  }
}
