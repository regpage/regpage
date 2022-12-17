<div id="interview_block" class="container">
  <!-- -->
  <div class="row serviceone_block text-white bg-info rounded mb-5">
    <h2 class="pl-3 mb-1">Собеседование</h2>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      <span>Кто проводит собеседование?</span>
    </div>
    <div class="col-5">
      <select id="flt_service_ones" class="i-width-280-px mr-2" data-table="ftt_request" data-field="decision_name" style="width: 180px;">
      <?php
        $decision_name = false;
        if (!empty($request_data['decision_name'])) {
          $decision_name = $request_data['decision_name'];
        }
        FTT_Select_fields::rendering($serviceones_pvom_brothers, $decision_name, '_none_') ?>
      </select>
    </div>
  </div>
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      1
    </div>
    <div class="col-5">
      2
    </div>
  </div>
  <div class="row serviceone_block">
    <div class="col-5">
      1
    </div>
    <div class="col-5">
      2
    </div>
  </div>

  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      1
    </div>
    <div class="col-5">
      2
    </div>
  </div>
</div>
