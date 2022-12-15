<!-- Рекомендации, служащие и решения -->
<div class="row">
  <div class="col"><strong>
    <br>
    =================================================================================
    <br><br>
    <h2>Рекомендации соработников или ответственных братьев:</h2>
  </strong></div>
</div>
<div class="row recommendation_block">
  <div class="col"><span>Ответственный за рекомендацию: </span><input type="text" class="input-request" data-field="recommendation_name" data-value="<?php echo $request_data['recommendation_name']; ?>" value="<?php echo $recommendation_name; ?>"></div>
</div>
<div class="row recommendation_block">
  <div class="col"><span>Мы рекомендуем этого кандидата: </span>
  <select class="" name="" data-field="recommendation_status" data-value="<?php echo $request_data['recommendation_status']; ?>" value="<?php echo $request_data['recommendation_status']; ?>">
      <option value=""></option>
      <option value="no" <?php if ($request_data['recommendation_status'] === 'no') : echo 'selected'; endif; ?>>нет</option>
      <option value="yes" <?php if ($request_data['recommendation_status'] === 'yes') : echo 'selected'; endif; ?>>да</option>
    </select>
  </div>
</div>
<div class="row recommendation_block">
  <div class="col m-b-15px"><span>Обязательно прокомментируйте это несколькими предложениями: </span></div>
</div>
<div class="row recommendation_block">
  <div class="col"><textarea rows="4" cols="50" class="t-width-long" data-field="recommendation_info" data-value="<?php echo $request_data['recommendation_info']; ?>"><?php echo $request_data['recommendation_info']; ?></textarea></div>
</div>
<div class="row recommendation_block">
  <div class="col"><span> Подпись ответственного за рекомендацию (напишите ваши имя и фамилию)</span></div>
</div>
<div class="row recommendation_block">
  <div class="col"><span class="span-label-width-210">Подпись: </span><input type="text" class="input-request" data-field="recommendation_signature" data-value="<?php echo $request_data['recommendation_signature']; ?>" value="<?php echo $request_data['recommendation_signature']; ?>"></div>
</div>
<div class="row recommendation_block">
  <div class="col"><span class="span-label-width-210">Дата рекомендации: </span><input type="date" class="input-request b-width-125-px" data-field="recommendation_date" data-value="<?php echo $request_data['recommendation_date']; ?>" value="<?php echo $request_data['recommendation_date']; ?>"></div>
</div>

<!-- СДЕЛАТЬ ПОДСТАНОВКУ ДАННЫХ-->
<div class="row">
  <div class="col">
    <select class="" name="">
      <option value="1" <?php
      if ($request_data['stage'] === "1") { ?>
        selected
      <?php } ?>>черновик</option>
      <option value="2" <?php
      if ($request_data['stage'] === "2") { ?>
        selected
      <?php } ?>>на рассмотрении</option>
      <option value="3" <?php
      if ($request_data['stage'] === "3") { ?>
      selected
      <?php } ?>>на собеседовании</option>
      <option value="4" <?php
      if ($request_data['stage'] === "4") { ?>
        selected
      <?php } ?>>на согласовании</option>
      <option value="5" <?php
      if ($request_data['stage'] === "5") { ?>
        selected
      <?php } ?>>решение принято</option>
    </select>
    </div>
  </div>
  <!--<div class="col"><span>Статус заявления: </span><input type="text" class="input-request" data-field="stage" data-value="<?php echo $request_data['stage']; ?>" value="<?php echo $request_data['stage']; ?>"></div>
</div>-->
<?php if ($serviceone_role === 3): ?>
<h2>Служащие ПВОМ:</h2>
<div class="row serviceone_block">
  <div class="col"><span class="span-label-width-210">Решение служащих ПВОМ: </span>
    <select class="" data-field="decision" data-value="<?php echo $request_data['decision']; ?>">
      <option value=""></option>
      <option value="agree" <?php if ($request_data['decision'] === 'agree') : echo 'selected'; endif; ?>>принят(а)</option>
      <option value="deny" <?php if ($request_data['decision'] === 'deny') : echo 'selected'; endif; ?>>не принят(а)</option>
    </select>
  </div>
</div>
<div class="row serviceone_block">
  <div class="col m-b-15px"><span>Комментарий к принятому решению: </span></div>
</div>
<div class="row serviceone_block">
  <div class="col"><textarea rows="4" cols="50" class="t-width-long" data-field="decision_info" data-value="<?php echo $request_data['decision_info']; ?>"><?php echo $request_data['decision_info']; ?></textarea></div>
</div>
<div class="row serviceone_block" style="display: none;">
  <div class="col"><span>Дата принятия решения: </span><input type="date" class="input-request b-width-125-px" data-field="decision_date" data-value="<?php echo $request_data['decision_date']; ?>" value="<?php echo $request_data['decision_date']; ?>"></div>
</div>
<?php endif; ?>
