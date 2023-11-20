<?php
$trainee_list = ftt_lists::trainee();
$service_one_list = ftt_lists::serving_ones();
?>
<hr>
<div class="row">
  <div class="col-12">
    <h4>Пользователи ПВОМ</h4>
    <br>
    <h5>Обучающиеся</h5>
  </div>
</div>
<div class="row">
  <?php foreach ($trainee_list as $key => $value): ?>
    <div class="col-3">
      <?php echo $value; ?>
    </div>
    <div class="col-3">
      <span class="text-primary cursor-pointer auth_link" data-member_key="<?php echo $key; ?>">авторизоваться</span>
    </div>
    <hr>
  <?php endforeach; ?>
</div>
<hr>
<div class="row">
  <div class="col-12">
    <h5>Служащие</h5>
    <br>
  </div>
</div>
<div class="row">
  <?php foreach ($service_one_list as $key => $value): ?>
    <div class="col-3">
      <?php echo $value; ?>
    </div>
    <div class="col-3">
      <span class="text-primary cursor-pointer auth_link" data-member_key="<?php echo $key; ?>">авторизоваться</span>
    </div>
    <hr>
  <?php endforeach; ?>
</div>
