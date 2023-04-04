<div id="decision_block" class="container">
  <!-- -->
  <div class="row serviceone_block text-white bg-info rounded mb-5">
    <h4 class="pl-3 mb-1 mt-1">Решение</h4>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5 title_point">Этап заявления</div>
    <div class="col-5 decision_service_point"><?php
        $swith_status = '';
        switch ($request_data['stage']) {
          case '1':
            echo 'рассмотрения заявления служащими';
            break;
          case '2':
            echo 'этап рекомендации';
            break;
          case '3':
            echo 'рассмотрения рекомендации служащими';
            break;
          case '4':
            echo 'на собеседовании';
            break;
          case '5':
            echo 'принятие решения';
            break;
          case '6':
            echo 'решение принято';
            break;
          default:
          echo 'черновик';
            break;
        }
      ?></div>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5 title_point">требуется рекомендация</div>
    <div class="col-5">
      <input type="checkbox" id="point_need_recommend" class="form-check-input input-request ml-1" data-table="ftt_request" data-field="need_recommend" <?php oneToChecked($request_data['need_recommend']); ?>>
    </div>
  </div>
  <div class="row serviceone_block">
    <div class="col-5 title_point">
      требуется собеседование
    </div>
    <div class="col-5">
      <input type="checkbox" id="point_need_interview" class="form-check-input input-request ml-1" data-table="ftt_request" data-field="need_interview" <?php oneToChecked($request_data['need_interview']); ?>>
    </div>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5"><span class="span-label-width-210 title_point">Решение служащих ПВОМ: </span></div>
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
      <span class="title_point">Дата принятия решения: </span>
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
    <div class="col-5 m-b-15px"><span class="title_point">Комментарий к принятому решению (виден только служащим): </span></div>
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
