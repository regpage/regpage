<div id="interview_block" class="container">

  <!-- -->
  <div class="row serviceone_block text-white bg-info rounded mb-5">
    <h4 class="pl-3 mb-1 mt-1">Собеседование</h4>
  </div>

  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5 title_point">
      <span>Ответственный за собеседование</span>
    </div>
    <div class="col-5">
      <select id="service_interview_name" class="i-width-280-px mr-2" data-table="ftt_request" data-field="interview_name" value="<?php echo $request_data['interview_name']; ?>" required>
      <?php
        $interview_name = false;
        if (!empty($request_data['interview_name'])) {
          $interview_name = $request_data['interview_name'];
        }
        FTT_Select_fields::rendering($serviceones_pvom_brothers, $interview_name, '_none_'); ?>
      </select>
    </div>
  </div>

  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5 title_point">Результат собеседования</div>
    <div class="col-5">
      <select id="point_interview_status" class="i-width-280-px mr-3" data-table="ftt_request" data-field="interview_status" value="<?php echo $request_data['interview_status']; ?>" required>
        <?php
          $options = ['','высоко рекомендовать','рекомендовать','сдержанно рекомендовать','ждать следующего семестра','не рекомендовать'];
          foreach ($options as $key => $value) {
            $interview_status = '';
            $value_data = $value;
            if ($request_data['interview_status'] === $value) {
              $interview_status = 'selected';
            }
            if (!$value) {
              $value_data = '_none_';
            }
            echo "<option value='{$value_data}' {$interview_status}> {$value}";
          }
          ?>
      </select>
      <span class="interview_help_link link_custom_active cursor-pointer" tooltip="<?php echo getValueFttParamByName('interview_help'); ?>">Справка</span>
    </div>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5 title_point">
      Комментарий к собеседованию
    </div>
    <div class="col-5">
      <textarea id="point_interview_info" class="input-request i-width-370-px field_height_90px" data-table="ftt_request" data-field="interview_info" required><?php echo $request_data['interview_info']; ?></textarea>
    </div>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-12">
      <?php if ($request_data['stage'] == 1 || $request_data['stage'] == 3 || $request_data['stage'] == 4): ?>
      <button id="send_to_interview" type="button" class="btn btn-primary btn-sm mr-3 mb-4" data-toggle="modal" data-target="">Передать</button>
      <?php endif; ?>
      <?php if ($is_interviewer == 1 && $request_data['stage'] == 4): ?>
      <button id="send_interview_to" type="button" class="btn btn-success btn-sm mr-3 mb-4" data-toggle="modal" data-target="">Отправить</button>
      <?php endif; ?>
    </div>
  </div>
  <div class="row serviceone_block mb-3">
    <div class="col-12">
      <?php
      $text_interw = '';
      $text_date_interw = date_convert::yyyymmdd_to_ddmmyyyy($request_data['interview_date']);
      if ($request_data['stage'] == 4) {
        $text_interw_send = $serviceones_pvom[$request_data['responsible_int']].' передал заявление ответственному за собеседование — '.$brothers_in_church[$request_data['interview_name']].' '.$text_date_interw;
      } elseif ($request_data['stage'] > 4 && $request_data['interview_name']) {
        $text_interw_send = $serviceones_pvom[$request_data['responsible_int']].' передал заявление ответственному за собеседование — '.$brothers_in_church[$request_data['interview_name']];
        $text_interw_get = "Собеседование прошло $text_date_interw";
      } ?>
      <div><?php echo $text_interw_send; ?></div>
      <div><?php echo $text_interw_get; ?></div>
    </div>
  </div>
</div>
