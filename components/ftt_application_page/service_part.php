<?php if ($serviceone_role === 3): ?>
<div class="container">
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-12">
      <strong>Передано на собеседование хх.хх.хххх</strong>
    </div>
  </div>
  <!-- -->
  <div class="row serviceone_block text-white bg-info rounded mb-5">
    <h2 class="pl-3 mb-1">Cлужащие ПВОМ</h2>
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
      <span>Статус заявления: </span>
    </div>
    <div class="col-5">
      <?php
        $swith_status = '';
        switch ($request_data['stage']) {
          case '1':
            echo 'на рассмотрении';
            break;
          case '2':
            echo 'на рассмотрении';
            break;
          case '3':
            echo 'на рассмотрении';
            break;
          case '4':
            echo 'на рассмотрении';
            break;
          case '4':
            echo 'на рассмотрении';
            break;
          case '4':
            echo 'решение принято';
            break;
          default:
          echo 'черновик';
            break;
        }
      ?>
    </div>
  </div>
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
  <div class="row serviceone_block">
    <div class="col-5">
      <span>Дата принятия решения: </span>
    </div>
    <div class="col-5">
      <input type="date" class="input-request b-width-125-px" data-table="ftt_request" data-field="decision_date" data-value="<?php echo $request_data['decision_date']; ?>" value="<?php echo $request_data['decision_date']; ?>">
    </div>
  </div>
  <div class="row serviceone_block">
    <div class="col-5 m-b-15px"><span>Комментарий к принятому решению: </span></div>
    <div class="col-5 ">
      <textarea rows="4" cols="50" class="input-request t-width-long" data-table="ftt_request" data-field="decision_info" data-value="<?php echo $request_data['decision_info']; ?>"><?php echo $request_data['decision_info']; ?></textarea>
    </div>
  </div>
</div>
<?php endif; ?>
