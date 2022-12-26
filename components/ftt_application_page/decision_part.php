<div id="decision_block" class="container">
  <!-- -->
  <div class="row serviceone_block text-white bg-info rounded mb-5">
    <h2 class="pl-3 mb-1">Решение</h2>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5"><span class="span-label-width-210">Решение служащих ПВОМ: </span></div>
      <div class="col-5">
        <?php
        if ($gl_gender_candidate) {
          $text_agree = 'принят';
          $text_deny = 'не принят';
        } else {
          $text_agree = 'принята';
          $text_deny = 'не принята';
        }

        ?>
        <select id="point_decision" class="i-width-280-px" data-table="ftt_request" data-field="decision" data-value="<?php echo $request_data['decision']; ?>">
          <option value="_none_"></option>
          <option value="approve" <?php if ($request_data['decision'] === 'approve') : echo 'selected'; endif; ?>><?php echo $text_agree; ?></option>
          <option value="deny" <?php if ($request_data['decision'] === 'deny') : echo 'selected'; endif; ?>><?php echo $text_deny; ?></option>
      </select>
    </div>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      <span>Дата принятия решения: </span>
    </div>
    <div class="col-5">
      <?php
      if (!$request_data['decision_date'] || $request_data['decision_date'] === '0000-00-00') {
        $date_decision_text = '';
      } else {
        $date_decision_text = date_convert::yyyymmdd_to_ddmmyyyy($request_data['decision_date']);
      }
      ?>
      <span data-date="<?php echo $request_data['decision_date']; ?>"><?php echo $date_decision_text; ?></span>
    </div>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5 m-b-15px"><span>Комментарий к принятому решению: </span></div>
    <div class="col-5">
      <textarea id="point_decision_info" rows="4" cols="50" class="input-request t-width-long" data-table="ftt_request" data-field="decision_info" data-value="<?php echo $request_data['decision_info']; ?>"><?php echo $request_data['decision_info']; ?></textarea>
    </div>
  </div>
  <div class="row serviceone_block">
    <div class="col-12">
      <?php if ($request_data['stage'] != 0 && $request_data['stage'] != 2 && $request_data['stage'] != 4 && $request_data['stage'] != 6): ?>
        <button id="send_decision_to" type="button" class="btn btn-success btn-sm mr-3 mb-4" data-toggle="modal" data-target="">Завершить</button>
      <?php endif; ?>
    </div>
  </div>
</div>
