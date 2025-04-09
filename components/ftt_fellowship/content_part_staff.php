<!-- РАЗДЕЛ ОБЩЕНИЕ -->
<br>
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link <?php echo $fellowship_tab_active; ?>" data-toggle="tab" href="#fellowship_tab_main">
      Служащие ПВОМ
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo $fellowship_bbd_tab_active; ?>" data-toggle="tab" href="#fellowship_tab_bbd">
      Братья КБК
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo $fellowship_activity_tab_active; ?>" data-toggle="tab" href="#fellowship_tab_activity">
      Активность
    </a>
  </li>
</ul>
<div id="" class="tab-content">
  <!-- ПОДРАЗДЕЛ ОБЩЕНИЕ-->
  <?php if ($fellowship_tab_active === 'active'): ?>
    <div id="fellowship_tab_main" class="tab-pane <?php echo $fellowship_tab_active; ?>">
      <?php include_once 'components/ftt_fellowship/content_staff_fellowship.php';  ?>
    </div>
  <?php endif; ?>
  <!-- ПОДРАЗДЕЛ БРАТЬЯ КБК-->
  <?php if ($fellowship_bbd_tab_active === 'active'): ?>
    <div id="fellowship_tab_bbd" class="tab-pane <?php echo $fellowship_bbd_tab_active; ?>">
      <?php include_once 'components/ftt_fellowship/content_staff_bbd.php';  ?>
    </div>
  <?php endif; ?>
  <!-- ПОДРАЗДЕЛ АКТИВНОСТЬ-->
  <?php if ($fellowship_activity_tab_active === 'active'): ?>
    <div id="fellowship_tab_activity" class="tab-pane <?php echo $fellowship_activity_tab_active; ?>">
      <?php include_once 'components/ftt_fellowship/content_staff_activity.php';  ?>
    </div>
  <?php endif; ?>
</div>
