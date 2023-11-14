<div id="vtraining_main" class="container">
  <!-- Tab panes -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_one_active; ?>" data-toggle="tab" href="#vtraining_tab">Анкеты</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_two_active; ?>" data-toggle="tab" href="#tab_content_vtraining_blanks">Бланки</a>
    </li>
  </ul>
  <!-- Nav tabs -->
  <div id="tab_content_vtraining" class="tab-content">
    <div id="vtraining_tab" class="container tab-pane <?php echo $tab_one_active; ?>"><br>
      <h3>Видеообучение | Коллектор библейской книги</h3>
      <hr>
      <?php echo $vTSpring; ?>
      <hr>
      <br>
      <?php echo $vTFall; ?>
    </div>
    <?php require_once 'components/regpage/vtraining/content_part_blanks.php'; ?>
  </div>
</div>
