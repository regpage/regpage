  <!-- ЗАЯВЛЕНИЕ ЗАЯВИТЕЛЯ -->
  <div class="row">
    <!--<div class="col"><img src="img/lsm-logo.png" alt=""></div>-->
    <div class="col pl-3">
      <!-- ЗАГОЛОВОК -->
      <h5 class="pl-3">Заявление для участия в Полновременном обучении</h5>
      <h6 class="pl-3"><?php echo getValueFttParamByName("semester"); ?>  (<?php echo getValueFttParamByName("period"); ?>)
      <?php echo $status_application_label; ?>
      </h6>
    </div>
    <div class="col-4">
      <button type="button" class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#modalStartInfo">Информация</button>
      <?php if (!empty($request_data['member_key']) && $memberId != $request_data['member_key']): ?>
        <button id="application_print" type="button" class="btn btn-primary btn-sm mr-2" disabled>Печать</button>
      <?php endif; ?>
      <?php if ($serviceone_role === 3): ?>
        <button type="button" id="toEditMyRequest" class="btn btn-warning btn-sm mr-2"><i class="fa fa-pencil" aria-hidden="true"></i></button>
      <?php endif; ?>
      <?php if ($memberId === $request_data['member_key'] || $serviceone_role === 3): ?>
        <button type="button" id="toModalDeleteMyRequest" class="btn btn-danger btn-sm mr-2" data-toggle="modal" data-target="#modalDeleteMyRequest"><i class="fa fa-trash" aria-hidden="true"></i></button>
      <?php endif; ?>
    </div>
  </div>
  <!-- БЛОК ЗАЯВЛЕНИЯ -->
  <?php if ($application_prepare === '1' || $request_data['stage'] > 0) {
    // ПРЕДОСМОТР И ОТПРАВКА
    // Панель кнопок
    //include_once "components/ftt_application_page/btn_bar_part.php";
    // Предосмотр анкеты
    //include_once "components/ftt_application_page/application_part.php";
    $points_head =[];
    for ($i=0; $i <count($points); $i++) {
      if ($points[$i]['display_type'] === 'header' && $points[$i]['group_position'] !== '0') {
        $points_head[$points[$i]['group_position']] = $points[$i]['group'];
      }
    }
    ksort($points_head);
    foreach ($points_head as $key => $value_group) {
      if ($value_group === 'Общая информация') {
        $other = array('localities' => $gl_localities, 'countries1' => $countries1, 'countries2' => $countries2);
      }
      FTTRenderPoints::rendering($points, $value_group, $request_data, $other);
    }
    // Рекомендации, служащие и решения
    /*if (!$applicant) {
      include_once "components/ftt_application_page/service_part.php";
    }*/
    echo "<div class='col'>{$status_phrase}</div>";
    echo '<div class="ml-2 mt-3 pl-1">';
    if ($request_data['stage'] < 1) {
      echo '<button id="back_to_master" type="button" class="btn btn-primary btn-sm mr-3">Вернуться</button>';
    }
    if ($request_data['stage'] < 1) {
      echo '<button id="send_application" type="button" class="btn btn-success btn-sm">Отправить</button>';
    }
    echo '</div>';
  } else {
    $points_head =[];
    for ($i=0; $i <count($points); $i++) {
      if ($points[$i]['display_type'] === 'header' && $points[$i]['group_position'] !== '0') {
        $points_head[$points[$i]['group_position']] = $points[$i]['group'];
      }
    }
    ksort($points_head);
    foreach ($points_head as $key => $value_group) {
      $other = [];
      // extra data
      if ($value_group === 'Общая информация') {
        $other = array('localities' => $gl_localities, 'countries1' => $countries1, 'countries2' => $countries2);
      }
      // cookie
      $cookie_v_ruky = 'wizard_step_1';
      if (isset($_COOKIE['wizard_step'])) {
        $cookie_v_ruky = $_COOKIE['wizard_step'];
      }
      // visibility
      $visibility = 'style="display: none;"';
      $link_custom_active = '';
      if ('wizard_step_'.$key == $cookie_v_ruky) {
        $visibility = '';
        $link_custom_active = 'link_custom_active';
      }
      echo "<div id='wizard_step_{$key}' class='wizard_step' {$visibility}>";
      FTTRenderPoints::rendering($points, $value_group, $request_data, $other);
      echo "</div>";

      // pagination
      $pagination .= "<span class='link_custom {$link_custom_active} pr-2 pl-2' data-step='wizard_step_{$key}'>{$key}</span>";
    }
    $pagination = '<div id="wizard_pagination" class="ml-1 mt-3">'.$pagination.'</div>';//text-center
    /*
    // МАСТЕР (WIZARD)
    $dir = '/components/ftt_application_page/'; // Папка с файлами
    $files = scandir($_SERVER['DOCUMENT_ROOT'].$dir);
    sort($files);
    */
    /*$cookie_v_ruky = 'wizard_step_01';
    if (isset($_COOKIE['wizard_step'])) {
      $cookie_v_ruky = $_COOKIE['wizard_step'];
    }
    $pagination = '<div id="wizard_pagination" class="text-center">';
    */

    /*
    $counter = 1;
    foreach ($files as $file){

      if(preg_match('/(wizard_step_)/', $file)) { // Выводим только .wizard_step_
        $visibility = 'style="display: none;"';
        $link_custom_active = '';
        if ($file == $cookie_v_ruky.'.php') {
          $visibility = '';
          $link_custom_active = 'link_custom_active';
        }
        $step_id = explode('.',$file);
        //echo "<div id='{$step_id[0]}' class='wizard_step' {$visibility}>";
        //include_once $_SERVER['DOCUMENT_ROOT'].$dir.$file;
        //echo "</div>";
        $link_step = explode('.', $file);
        $pagination .= "<span class='link_custom {$link_custom_active} pr-2 pl-2' data-step='{$link_step[0]}'>{$counter}</span>";
        $counter++;
      }
    }
    */
        //$pagination.='</div>';

    ?>
    <div id="send_application_text" class="ml-2 mt-3 pl-1" style="display: none;">
      <b><?php echo getValueFttParamByName('request_bottom'); ?></b>
    </div>
    <div class="ml-2 mt-3 pl-1">
      <button id="prev_step" type="button" class="btn btn-primary btn-sm mr-3">Назад</button>
      <button id="next_step" type="button" class="btn btn-primary btn-sm mr-3">Далее</button>
      <button id="send_application" type="button" class="btn btn-warning btn-sm" style="display: none;">Предпросмотр</button>
    </div>
    <?php
      echo $pagination;
    } ?>
