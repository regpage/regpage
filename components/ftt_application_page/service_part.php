<?php if ($serviceone_role === 3): ?>
<div class="container">
<div class="row serviceone_block">
  <div class="col">
  <h2>Служащие ПВОМ:</h2>
  </div>
</div>
<div class="row serviceone_block">
  <div class="col">
  <select id="flt_service_ones" class="mr-2" data-table="ftt_request" data-field="decision_name" style="width: 180px;">
  <?php
  $decision_name = false;
  if (!empty($request_data['decision_name'])) {
    $decision_name = $request_data['decision_name'];
  }
   FTT_Select_fields::rendering($serviceones_pvom_brothers, $decision_name, '_none_') ?>
  </select>
  <span>Передано на собеседование хх.хх.хххх</span>
  <!-- СДЕЛАТЬ ПОДСТАНОВКУ ДАННЫХ-->
  <select class="" name="">
        <option value="1" <?php
        if ($request_data['request_status'] === "1") { ?>
          selected
        <?php } ?>>черновик</option>
        <option value="2" <?php
        if ($request_data['request_status'] === "2") { ?>
          selected
        <?php } ?>>на рассмотрении</option>
        <option value="3" <?php
        if ($request_data['request_status'] === "3") { ?>
        selected
        <?php } ?>>на собеседовании</option>
        <option value="4" <?php
        if ($request_data['request_status'] === "4") { ?>
          selected
        <?php } ?>>на согласовании</option>
        <option value="5" <?php
        if ($request_data['request_status'] === "5") { ?>
          selected
        <?php } ?>>решение принято</option>
      </select>
      </div>
    <!--<div class="col"><span>Статус заявления: </span><input type="text" class="input-request" data-field="request_status" data-value="<?php echo $request_data['request_status']; ?>" value="<?php echo $request_data['request_status']; ?>"></div>
  </div>-->
</div>
<div class="row serviceone_block">
  <div class="col"><span class="span-label-width-210">Решение служащих ПВОМ: </span>
    <select class="" data-field="decision" data-value="<?php echo $request_data['decision']; ?>">
      <option value=""></option>
      <option value="agree" <?php if ($request_data['decision'] === 'agree') : echo 'selected'; endif; ?>>принят(а)</option>
      <option value="deny" <?php if ($request_data['decision'] === 'deny') : echo 'selected'; endif; ?>>не принят(а)</option>
    </select>
    <span>Дата принятия решения: </span><input type="date" class="input-request b-width-125-px" data-field="decision_date" data-value="<?php echo $request_data['decision_date']; ?>" value="<?php echo $request_data['decision_date']; ?>">
  </div>
</div>
<div class="row serviceone_block">
  <div class="col m-b-15px"><span>Комментарий к принятому решению: </span></div>
</div>
<div class="row serviceone_block">
  <div class="col"><textarea rows="4" cols="50" class="t-width-long" data-field="decision_info" data-value="<?php echo $request_data['decision_info']; ?>"><?php echo $request_data['decision_info']; ?></textarea></div>
</div>
</div>
<?php endif; ?>
