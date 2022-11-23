  <!-- ЗАЯВЛЕНИЕ ЗАЯВИТЕЛЯ -->
  <div class="row">
    <!--<div class="col"><img src="img/lsm-logo.png" alt=""></div>-->
    <div class="col">
      <!-- ЗАГОЛОВОК -->
      <h5>Заявление для участия в Полновременном обучении</h5>
      <h6><?php echo getValueFttParamByName("semester"); ?>  (<?php echo getValueFttParamByName("period"); ?>)<h6>
      <hr style="margin: 0;">
    </div>
  </div>
  <!-- БЛОК ЗАЯВЛЕНИЯ -->
  <?php if (false) {
    // ПРЕДОСМОТР И ОТПРАВКА
    // Панель кнопок
    include_once "components/application_page/btn_bar_part.php";
    // Предосмотр анкеты
    include_once "components/application_page/application_part.php";
    // Рекомендации, служащие и решения
    if (!$applicant) {
      include_once "components/application_page/service_part.php";
    }
  } else {
    // МАСТЕР (WIZARD)
    $dir = '/components/application_page/'; // Папка с файлами
    $files = scandir($_SERVER['DOCUMENT_ROOT'].$dir);
    sort($files);

    $cookie_v_ruky = 'wizard_step_01';
    if (isset($_COOKIE['wizard_step'])) {
      $cookie_v_ruky = $_COOKIE['wizard_step'];
    }

    foreach ($files as $file){
      if(preg_match('/(wizard_step_)/', $file)) { // Выводим только .wizard_step_
        $visibility = 'style="display: none;"';
        if ($file == $cookie_v_ruky.'.php') {
          $visibility = '';
        }
        $step_id = explode('.',$file);
        echo "<div id='{$step_id[0]}' class='wizard_step' {$visibility}>";
        include_once $_SERVER['DOCUMENT_ROOT'].$dir.$file;
        echo "</div>";
      }
    }
    ?>
    <button id="prev_step" type="button" class="btn btn-primary mr-3">Предыдущий</button>
    <button id="next_step" type="button" class="btn btn-primary">Следующий</button>

    <?php
  } ?>
