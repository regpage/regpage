<div id="interview_block" class="container">

  <!-- -->
  <div class="row serviceone_block text-white bg-info rounded mb-5">
    <h2 class="pl-3 mb-1">Собеседование</h2>
  </div>

  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      <span>Ответственный за собеседование</span>
    </div>
    <div class="col-5">
      <select id="service_interview_name" class="i-width-280-px mr-2" data-table="ftt_request" data-field="interview_name" value="<?php echo $request_data['interview_name']; ?>" style="width: 180px;"required>
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
    <div class="col-5">
      Содержание собеседования
    </div>
    <div class="col-5">
      <textarea id="point_interview_info" class="input-request i-width-370-px field_height_90px" data-table="ftt_request" data-field="interview_info" required><?php echo $request_data['interview_info']; ?></textarea>
    </div>
  </div>

  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      Результат собеседования
    </div>
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
      <span id="interview_help_link" class="link_custom_active cursor-pointer" tooltip="<?php echo getValueFttParamByName('interview_help'); ?>">Справка</span>
    </div>
  </div>

  <!-- -->
  <div class="row serviceone_block">
    <div class="col-12">
      <?php if ($request_data['stage'] == 1 || $request_data['stage'] == 3): ?>
      <button id="send_to_interview" type="button" class="btn btn-primary btn-sm mr-3 mb-4" data-toggle="modal" data-target="">Передать</button>
      <?php endif; ?>
      <?php if ($is_interviewer == 1 && $request_data['stage'] == 4): ?>
      <button id="send_interview_to" type="button" class="btn btn-success btn-sm mr-3 mb-4" data-toggle="modal" data-target="">Отправить</button>
      <?php endif; ?>
    </div>
  </div>
  <div class="row serviceone_block mb-3">
    <div class="col-12">
      <span>ФИ передал заявление ответственному за собеседование — ФИ [дата и время].</span>
    </div>
  </div>
</div>
