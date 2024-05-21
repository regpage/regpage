<?php require_once 'components/ftt_main/ctrl_menu_nav_ftt.php'; ?>
<div id="menu_nav_ftt" class="container-xl" style="margin-top: 60px; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; background-color: white; max-width: 1170px; border: 1px solid #ddd; border-top: none;">
  <div class="row">
    <div id="ftt_navs" class="col">
      <!-- Меню разделов -->
      <ul id="menu_nav_ftt_ul" class="nav" role="tablist" style="margin: 0px;">
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
      <ul id="menu_nav_ftt_ul_mbl" class="nav" role="tablist" style="margin: 0px; display:none;">
        <?php
        $count = 0;
        foreach ($ftt_devisions as $key => $value):
          if ($_SERVER['REQUEST_URI'] === '/'.$key || $_SERVER['PHP_SELF'] === '/'.$key.'.php') {
            $class_btn = 'active mark_menu_item';
          } else {
            $class_btn = '';
          }
          ?>
          <?php if ($count <= 5): ?>
            <li class="nav-item">
              <a class="nav-link <?php echo $class_btn ?>" href="<?php echo '/'.$key ?>"><?php echo $value ?></a>
            </li>
          <?php endif; ?>
          <?php if ($count === 6): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">Ещё<?php echo $other_count; ?></a>
              <div class="dropdown-menu dropdown-menu-right">
              <a class="nav-link ml-3 <?php echo $class_btn ?>" href="<?php echo '/'.$key ?>"><?php echo $value ?></a>
          <?php endif; ?>
          <?php if ($count > 6): ?>
            <a class="nav-link  ml-3 dropdown-toggle <?php echo $class_btn ?>" href="<?php echo '/'.$key ?>"><?php echo $value ?></a>
          <?php endif; ?>
        <?php
        $count++;
        endforeach; ?>
          </div>
        </li>
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
  // уведомление если 3 или более доп. помощи
  if (!empty($warning_extra_help_text)) {
    echo $warning_extra_help_text;
  }
  // уведомление если 3 или более проп. занятиях
  if (!empty($warning_missed_class_text)) {
    echo $warning_missed_class_text;
  }
  ?>
</div>
<script>
// переход в раздел общение из меню
$(".fellowship_link").click(function () {
  window.location = 'ftt_fellowship';
});
// ftt menu
if ($(window).width()<=769) {
  $('#menu_nav_ftt_ul').hide();
  $('#menu_nav_ftt_ul_mbl').show();
  $('#menu_nav_ftt_ul_mbl .nav-item').css("width", "auto");
}
</script>

<script src="js/ftt/menu_ftt_desing.js?v2"></script>
<link href="css/ftt/menu_nav_ftt.css" rel="stylesheet">
