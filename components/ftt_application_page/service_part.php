<?php if ($serviceone_role === 3): ?>
<div class="container">
  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      требуется рекомендация
    </div>
    <div class="col-5">
      <input type="checkbox" id="point_need_recommend" class="form-check-input input-request ml-1" data-table="ftt_request" data-field="need_recommend" <?php oneToChecked($request_data['need_recommend']); ?>>
    </div>
  </div>
  <div class="row serviceone_block">
    <div class="col-5">
      требуется собеседование
    </div>
    <div class="col-5">
      <input type="checkbox" id="point_need_interview" class="form-check-input input-request ml-1" data-table="ftt_request" data-field="need_interview" <?php oneToChecked($request_data['need_interview']); ?>>
    </div>
  </div>

  <!-- -->
  <div class="row serviceone_block">
    <div class="col-5">
      <span>Этап заявления</span>
    </div>
    <div class="col-5">
      <?php
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
          case '4':
            echo 'принятие решения';
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
  <hr><hr><hr>
  <!--
  <div class="row serviceone_block">
    <div class="col-5">
      <span>Передано на собеседование</span>
    </div>
    <div class="col-5">
      <strong>хх.хх.хххх</strong>
    </div>
  </div>-->
</div>
<?php endif;
if ($serviceone_role === 3)
  include_once "components/ftt_application_page/recomend_part.php";

if ($serviceone_role === 3)
  include_once "components/ftt_application_page/interview_part.php";

if ($serviceone_role === 3)
  include_once "components/ftt_application_page/decision_part.php";
?>
