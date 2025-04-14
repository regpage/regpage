<div id="main_container_reg" class="container">
  <?php
  // подставляем контент
  if (THIS_PAGE === 'attend') {
    include_once 'components/regpage/attend/content_part.php';
    include_once 'components/regpage/attend/modals.php';
  } elseif (THIS_PAGE === 'vtraining') {
    include_once 'components/regpage/vtraining/content_part.php';
    include_once 'components/regpage/vtraining/modals.php';
  } elseif (THIS_PAGE === 'ch_statistic') {
    include_once 'components/regpage/ch_statistic/content_part.php';
    include_once 'components/regpage/ch_statistic/modals.php';
  } elseif (THIS_PAGE === 'arrdep') {
    include_once 'components/regpage/home/arrdep/content.php';
  } elseif (THIS_PAGE === 'calls') {
    include_once 'components/regpage/calls/content.php';
  } elseif (THIS_PAGE === 'itero_2025_w') {
    include_once 'components/regpage/itero_2025_w/ctrl_content.php';
  }
  ?>
</div>
