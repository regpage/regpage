<?php
$extra_help_text = 'Доп. задания';
include_once 'db/classes/statistics.php';
include_once 'db/classes/ftt_lists.php';
if ($ftt_access['group'] === 'trainee'):
  $extra_help_count = statistics::extra_help_count($memberId);
  if ($extra_help_count == 0) {
    $extra_help_count = '';
  }
  $extra_help_text .= "<sup style='color: red;'> <b> {$extra_help_count}</b></sup>";
endif;
$permission_stat_count_main_text = 'Посещаемость';
if ($ftt_access['group'] === 'staff') {
  $permission_stat_count_main = statistics::permission_count(ftt_lists::get_trainees_by_staff($memberId));
} else {
  $permission_stat_count_main = statistics::permission_count($memberId);
}
if ($permission_stat_count_main == 0) {
  $permission_stat_count_main = '';
}
$permission_stat_count_main_text .= "<sup style='color: red;'> <b> {$permission_stat_count_main}</b></sup>";

$ftt_devisions = array('ftt_schedule' => 'Расписание', 'ftt_announcement' => 'Объявления',
'ftt_attendance' => $permission_stat_count_main_text, 'ftt_service' => 'Служение','ftt_gospel' => 'Благовестие', 'contacts' => 'Контакты', 'ftt_extrahelp' => $extra_help_text,'ftt_application' => 'Заявления'); //'ftt_absence' => 'Отсутствие',
if ($ftt_access['group'] === 'staff') { //

}
//$_SERVER['PHP_SELF'];
if ($ftt_access['group'] === 'trainee') {
  unset($ftt_devisions['ftt_application']);
}
?>
<div id="menu_nav_ftt" class="container-xl" style="margin-top: 60px; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; background-color: white; max-width: 1170px; border: 1px solid #ddd; border-top: none;">
  <div class="row">
    <div id="ftt_navs" class="col">
      <!-- Меню разделов -->
      <ul class="nav" role="tablist" style="margin: 0px;">
        <?php foreach ($ftt_devisions as $key => $value):
          if ($_SERVER['REQUEST_URI'] === '/'.$key) {
            $class_btn = 'active mark_menu_item';
          } else {
            $class_btn = '';
          }
          ?>
          <li class="nav-item">
            <a class="nav-link <?php echo $class_btn ?>" href="<?php echo $key ?>"><?php echo $value ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
<script src="js/ftt/menu_ftt_desing.js"></script>
<link href="css/ftt/menu_nav_ftt.css" rel="stylesheet">
