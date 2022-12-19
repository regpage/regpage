<div id="recommended_block" class="container" data-date="<?php echo $request_data['recommendation_date']; ?>">
  <!-- -->
  <div class="row serviceone_block text-white bg-info rounded mb-5">
    <h2 class="pl-3 mb-1">Рекомендация</h2>
  </div>

  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      Ответственный за рекомендацию
    </div>
    <div class="col-5">
      <select id="" class="i-width-280-px mr-2" data-table="ftt_request" data-field="recommendation_name" value="<?php echo $request_data['recommendation_name']; ?>" style="width: 180px;"required>
      <?php
        $recommendation_name = false;
        if (!empty($request_data['recommendation_name'])) {
          $recommendation_name = $request_data['recommendation_name'];
        }
        FTT_Select_fields::rendering(db_getChurchLifeBrothers(), $recommendation_name, '_none_');
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
      Содержание рекомендации
    </div>
    <div class="col-5">
      <textarea class="input-request i-width-370-px field_height_90px" data-table="ftt_request" data-field="recommendation_info" required><?php echo $request_data['recommendation_info']; ?></textarea>
    </div>
  </div>

  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      Статус рекомендации
    </div>
    <div class="col-5">
      <div class="i-width-370-px" data-table="ftt_request" data-field="recommendation_status" data-value="<?php echo $request_data['recommendation_info']; ?>" required>
        <div class="form-check-inline">
          <label class="form-check-label" for="person_recommended_yes">
            <input type="radio" id="person_recommended_yes" name="person_recommended" value="да"
            <?php if ($request_data['recommendation_status'] === 'да'): ?>
              <?php echo 'checked'; ?>
            <?php endif; ?>>
          Да</label>
        </div>
        <div class="form-check-inline">
          <label class="form-check-label" for="person_recommended_no">
            <input type="radio" id="person_recommended_no" name="person_recommended" value="нет"
            <?php if ($request_data['recommendation_status'] === 'нет'): ?>
              <?php echo 'checked'; ?>
            <?php endif; ?>>
          Нет</label>
        </div>
      </div>
    </div>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-12">
      <button type="button" class="btn btn-primary btn-sm mr-3 mb-4" data-toggle="modal" data-target="">Передать</button>
    </div>
  </div>
  <!-- -->
  <div class="row serviceone_block mb-3">
    <div class="col-12">
      <span><?php $request_data['recommendation_signature']; ?> ФИ передал заявление ответственному за рекомендацию — ФИ [дата и время].</span>
    </div>
  </div>
</div>
