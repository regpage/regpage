<div id="main_container_reg" class="container">
  <?php
  if ($_SERVER['REQUEST_URI'] === '/attend') {
    include_once 'components/regpage/attend/content_part.php';
    include_once 'components/regpage/attend/modals.php';
  } elseif ($_SERVER['REQUEST_URI'] === '/vtraining') {
    include_once 'components/regpage/vtraining/content_part.php';
    include_once 'components/regpage/vtraining/modals.php';
  }
  ?>
</div>
