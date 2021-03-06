<?php
$extra_help_text = 'Доп. задания';
if ($ftt_access['group'] === 'trainee'):
  include_once 'db/classes/statistics.php';
  $extra_help_count = statistics::extra_help_count($memberId);
  if ($extra_help_count == 0) {
    $extra_help_count = '';
  }
  $extra_help_text .= "<sup style='color: red;'> <b> {$extra_help_count}</b></sup>";
endif;

$ftt_devisions = array('ftt_schedule' => 'Расписание', 'ftt_announcement' => 'Объявления', 'ftt_attendance' => 'Посещаемость', 'ftt_service' => 'Служение','ftt_gospel' => 'Благовестие', 'contacts' => 'Контакты', 'ftt_extrahelp' => $extra_help_text,'ftt_application' => 'Заявления'); //'ftt_absence' => 'Отсутствие',
//$_SERVER['PHP_SELF'];
if ($admin_data['locality_key'] === '001192') {
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
