<div id="decision_block" class="container">
  <!-- -->
  <div class="row serviceone_block text-white bg-info rounded mb-5">
    <h2 class="pl-3 mb-1">Решение</h2>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5"><span class="span-label-width-210">Решение служащих ПВОМ: </span></div>
      <div class="col-5">
        <select class="i-width-280-px" data-table="ftt_request" data-table="ftt_request" data-field="decision" data-value="<?php echo $request_data['decision']; ?>">
          <option value=""></option>
          <option value="agree" <?php if ($request_data['decision'] === 'agree') : echo 'selected'; endif; ?>>принят(а)</option>
          <option value="deny" <?php if ($request_data['decision'] === 'deny') : echo 'selected'; endif; ?>>не принят(а)</option>
      </select>
    </div>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      <span>Дата принятия решения: </span>
    </div>
    <div class="col-5">
      <!--<input type="date" class="input-request b-width-125-px" data-table="ftt_request" data-field="decision_date" data-value="<?php echo $request_data['decision_date']; ?>" value="<?php echo $request_data['decision_date']; ?>">-->
      <span><?php echo date_convert::yyyymmdd_to_ddmmyyyy($request_data['decision_date']); ?></span>
    </div>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5 m-b-15px"><span>Комментарий к принятому решению: </span></div>
    <div class="col-5 ">
      <textarea rows="4" cols="50" class="input-request t-width-long" data-table="ftt_request" data-field="decision_info" data-value="<?php echo $request_data['decision_info']; ?>"><?php echo $request_data['decision_info']; ?></textarea>
    </div>
  </div>
</div>
