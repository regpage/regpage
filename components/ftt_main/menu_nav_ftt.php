<?php
include_once 'db/classes/statistics.php';
include_once 'db/classes/ftt_lists.php';
include_once 'db/classes/ftt_attendance/fellowship.php';

// получаем обучающихся служащего
$gl_trainees_by_staff = [];
if ($ftt_access['group'] === 'staff') {
  $gl_trainees_by_staff = ftt_lists::get_trainees_by_staff($memberId);
}

// счётчик доп заданий в меню
$extra_help_text = 'Доп. задания';
if ($ftt_access['group'] === 'trainee'){
  $extra_help_count = statistics::extra_help_count($memberId);
} elseif ($ftt_access['group'] === 'staff'){
  $extra_help_count = statistics::extra_help_count($gl_trainees_by_staff);
}
if ($extra_help_count == 0) {
  $extra_help_count = '';
}
$extra_help_text .= "<sup style='color: red;'> <b> {$extra_help_count}</b></sup>";

// счётчик разрешений в меню
$permission_stat_count_main_text = 'Посещаемость';
if ($ftt_access['group'] === 'staff') {
  $permission_stat_count_main = statistics::permission_count($gl_trainees_by_staff);
} else {
  $permission_stat_count_main = statistics::permission_count($memberId);
}
if ($permission_stat_count_main == 0) {
  $permission_stat_count_main = '';
}
$permission_stat_count_main_text .= "<sup style='color: red;'> <b> {$permission_stat_count_main}</b></sup>";

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
}
$requests_for_application_text .= "<sup style='color: red;'> <b> {$requests_for_application_count}</b></sup>";

$ftt_devisions = array('ftt_schedule' => 'Расписание', 'ftt_announcement' => $announcement_unread_count_text,
'ftt_attendance' => $permission_stat_count_main_text, 'ftt_fellowship' => 'Общение', 'ftt_service' => 'Служение', 'ftt_gospel' => 'Благовестие', 'contacts' => 'Контакты', 'ftt_extrahelp' => $extra_help_text, 'ftt_reading' => 'Чтение','ftt_application' => $requests_for_application_text);
if ($ftt_access['group'] === 'staff') { //

}
//$_SERVER['PHP_SELF'];
if ($ftt_access['group'] === 'trainee') {
  unset($ftt_devisions['ftt_application']);
  // Общение на сегодня
  $fellowship_today = Fellowship::now_trainee($memberId);
  $fellowship_text = '';
  $fellowship_text_name = '';
  $fellowship_link = "<span class='link_custom fellowship_link' href='https://churchinspb.online/ftt_attendance.php?meet=1' style='display: inline-block; font-weight: normal;'> перейти в раздел</span>";
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
    $fellowship_text = "<strong class='fellowship_today' style='color: red; padding-left: 16px; padding-bottom: 10px; padding-right: 10px; display: inline-block;'>Сегодня общение:  {$fellowship_text_name} </strong>";
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
    $fellowship_cancel_text = "<strong class='fellowship_today' style='color: red; padding-bottom: 10px; padding-left: 16px; padding-right: 10px; display: inline-block;'>Отменено общение:  {$fellowship_cancel_text_name} </strong>";
  }
}
?>
<div id="menu_nav_ftt" class="container-xl" style="margin-top: 60px; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; background-color: white; max-width: 1170px; border: 1px solid #ddd; border-top: none;">
  <div class="row">
    <div id="ftt_navs" class="col">
      <!-- Меню разделов -->
      <ul class="nav" role="tablist" style="margin: 0px;">
        <?php foreach ($ftt_devisions as $key => $value):
          if ($_SERVER['REQUEST_URI'] === '/'.$key || $_SERVER['PHP_SELF'] === '/'.$key.'.php') {
            $class_btn = 'active mark_menu_item';
          } else {
            $class_btn = '';
          }
          ?>
          <li class="nav-item">
            <a class="nav-link <?php echo $class_btn ?>" href="<?php echo '/'.$key ?>"><?php echo $value ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <?php
  if (!empty($fellowship_text)) {
    echo $fellowship_text;
  }

  if (!empty($fellowship_cancel_text)) {
    if (!empty($fellowship_text)) {
      echo '<br>';
    }
    echo $fellowship_cancel_text;
  }
  if (!empty($fellowship_cancel_text) || !empty($fellowship_text)) {
    echo $fellowship_link;
  }
  ?>
</div>
<script>
// переход в раздел общение из меню
$(".fellowship_link").click(function () {
  setCookie("tab_active", "meet");
  setTimeout(function () {
    window.location = 'ftt_attendance';
  }, 30);
});
</script>

<script src="js/ftt/menu_ftt_desing.js"></script>
<link href="css/ftt/menu_nav_ftt.css" rel="stylesheet">
