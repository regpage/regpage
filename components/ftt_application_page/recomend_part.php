<div id="recommended_block" class="container" data-date="<?php echo $request_data['recommendation_date']; ?>">
  <!-- -->
  <div class="row serviceone_block text-white bg-info rounded mb-5">
    <h4 class="pl-3 pl-3 mb-1 mt-1">Рекомендация</h4>
  </div>

  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      Ответственный за рекомендацию:
    </div>
    <div class="col-5">
      <select id="service_recommendation_name" class="i-width-280-px mr-2" data-table="ftt_request" data-field="recommendation_name" value="<?php echo $request_data['recommendation_name']; ?>" required>
      <?php
        $recommendation_name = false;
        if (!empty($request_data['recommendation_name'])) {
          $recommendation_name = $request_data['recommendation_name'];
        }
        FTT_Select_fields::rendering($brothers_in_church, $recommendation_name, '_none_');
      ?>
      </select>

      <!--<input type="text" class="input-request i-width-370-px" value="<?php // echo $request_data['recommendation_name']; ?>" list="recommedators_list" data-table="ftt_request" data-field="recommendation_name" required>


      echo "<datalist id='recommedators_list'>";
      foreach (db_getChurchLifeBrothers() as $key => $value) {
        echo "<option data-member_key='{$key}' value='{$value}'>";
      }
      echo "</datalist>";-->

    </div>
  </div>

  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      Рекомендация:
    </div>
    <div class="col-5">
      <select id="point_recommendation_status" class="i-width-280-px mr-3" data-table="ftt_request" data-field="recommendation_status" value="<?php echo $request_data['recommendation_status']; ?>" required>
        <?php
          $options = ['','высоко рекомендовать','рекомендовать','сдержанно рекомендовать','ждать следующего семестра','не рекомендовать'];
          foreach ($options as $key => $value) {
            $interview_status = '';
            $value_data = $value;
            if ($request_data['recommendation_status'] === $value) {
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
    <div class="col-5">
      Комментарий к рекомендации:
    </div>
    <div class="col-5">
      <textarea id="point_recommendation_info" class="input-request i-width-370-px field_height_90px" data-table="ftt_request" data-field="recommendation_info" required><?php echo $request_data['recommendation_info']; ?></textarea>
    </div>
  </div>

  <!-- -->
  <div class="row serviceone_block">
    <div class="col-12">
      <?php if ($request_data['stage'] == 1 || ($request_data['stage'] == 2 && $is_recommendator != 1)): ?>
      <button id="send_to_recommend" type="button" class="btn btn-primary btn-sm mr-3 mb-4" data-toggle="modal" data-target="">Передать</button>
      <?php endif; ?>
      <?php if ($is_recommendator == 1 && $request_data['stage'] == 2): ?>
        <button id="send_recommend_to" type="button" class="btn btn-success btn-sm mr-3 mb-4" data-toggle="modal" data-target="">Отправить</button>
      <?php endif; ?>
    </div>
  </div>
  <!-- -->
  <div class="row serviceone_block mb-3">
    <div class="col-12">
      <?php
      $text_recomm = '';
      $text_date_recomm = date_convert::yyyymmdd_to_ddmmyyyy($request_data['recommendation_date']);
      if ($request_data['stage'] == 2) {
        $text_recomm_send = $serviceones_pvom[$request_data['responsible_rec']].' передал заявление ответственному за рекомендацию — '.$brothers_in_church[$request_data['recommendation_name']].' '.$text_date_recomm;
      } elseif ($request_data['stage'] > 2 && $request_data['recommendation_name']) {
        $text_recomm_send = $serviceones_pvom[$request_data['responsible_rec']].' передал заявление ответственному за рекомендацию — '.$brothers_in_church[$request_data['recommendation_name']];
        $text_recomm_get = "Рекомендация получена $text_date_recomm";
      } ?>
      <div><?php echo $text_recomm_send; ?></div>
      <div><?php echo $text_recomm_get; ?></div>
    </div>
  </div>
</div>
