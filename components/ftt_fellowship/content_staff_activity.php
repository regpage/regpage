<!-- ПОДРАЗДЕЛ АКТИВНОСТЬ-->
<?php require_once 'components/ftt_fellowship/ctrl_content_staff_activity.php'; ?>

<!-- Блок кнопок и фильтров -->
<div id="" class="btn-group mb-2" style="padding-top: 21px;">
  <!-- Фильтр по служащим -->
  <select id="flt_fellowship_activity_servingone" class="form-control form-control-sm mr-2">
    <option value="_all_">Все служащие</option>
    <?php FTT_Select_fields::rendering($serving_ones_list_meet, $serving_ones_activy_flt); ?>
  </select>
  <!-- Фильтр по обучающимся
  <select id="flt_fellowship_activity_trainee" class="form-control form-control-sm mr-2">
    <option value="_all_">Все обучающиеся</option>
    <?php FTT_Select_fields::rendering($trainee_list, $trainee_activy_flt); ?>
  </select>-->
</div>
<!-- Блок списка записей -->
<div id="meet_list_content_staff" class="container">
  <div class="row row_meet mb-1">
    <div class="col-2"><b>Обучающийся</b></div>
    <div class="col-2"><b><?php print(date_convert::yyyymmdd_to_ddmm($fellowshipList['weeks'][0][0]) . ' – ' . date_convert::yyyymmdd_to_ddmm($fellowshipList['weeks'][0][1])) ?></b></div>
    <div class="col-2"><b><?php print(date_convert::yyyymmdd_to_ddmm($fellowshipList['weeks'][1][0]) . ' – ' . date_convert::yyyymmdd_to_ddmm($fellowshipList['weeks'][1][1])) ?></b></div>
    <div class="col-2"><b><?php print(date_convert::yyyymmdd_to_ddmm($fellowshipList['weeks'][2][0]) . ' – ' . date_convert::yyyymmdd_to_ddmm($fellowshipList['weeks'][2][1])) ?></b></div>
    <div class="col-2"><b><?php print(date_convert::yyyymmdd_to_ddmm($fellowshipList['weeks'][3][0]) . ' – ' . date_convert::yyyymmdd_to_ddmm($fellowshipList['weeks'][3][1])) ?></b></div>
    <?php if (isset($fellowshipList['weeks'][4][0])): ?>
      <div class="col-2"><b><?php print(date_convert::yyyymmdd_to_ddmm($fellowshipList['weeks'][4][0]) . ' – ' . date_convert::yyyymmdd_to_ddmm($fellowshipList['weeks'][4][1])) ?></b></div>
    <?php endif; ?>

  </div>
  <hr style="margin-left: -15px; margin-right: -15px; margin-top: 0px; margin-bottom: 10px; border-color: lightgray;">
  <?php foreach ($fellowshipList as $key => $value): ?>
    <?php if ($key === 'weeks') {
      continue;
    } ?>
    <div class="row border-bottom mt-1"><div class="col">
      <?php echo $trainee_list[$key] . ':  '; ?>
    </div>
    <?php
    $firstCol = '<div class="col">';
    $secondCol = '<div class="col">';
    $thirdCol = '<div class="col">';
    $fourthCol = '<div class="col">';
    $fivthCol = '<div class="col">';
    foreach ($value as $key_2 => $value_2):
      if (isset($serving_ones_list[$value_2['serving_one']])) {
        $colorClass = 'fellowship_element';
      } else {
        $colorClass = 'fellowship_element_bbd';
      }
      switch ($value_2['week']) {
        case '0':
          $firstCol .= "<span class='{$colorClass}' title='" . date_convert::yyyymmdd_to_ddmm($value_2['date']) . " {$serving_ones_list[$value_2['serving_one']]}'></span>";
          break;
        case 1:
          $secondCol .= "<span class='{$colorClass}' title='" . date_convert::yyyymmdd_to_ddmm($value_2['date']) . " {$serving_ones_list[$value_2['serving_one']]}'></span>";
          break;
        case 2:
          $thirdCol .= "<span class='{$colorClass}' title='" . date_convert::yyyymmdd_to_ddmm($value_2['date']) . " {$serving_ones_list[$value_2['serving_one']]}'></span>";
          break;
        case 3:
          $fourthCol .= "<span class='{$colorClass}' title='" . date_convert::yyyymmdd_to_ddmm($value_2['date']) . " {$serving_ones_list[$value_2['serving_one']]}'></span>";
          break;
        case 4:
          $fivthCol .= "<span class='{$colorClass}' title='" . date_convert::yyyymmdd_to_ddmm($value_2['date']) . " {$serving_ones_list[$value_2['serving_one']]}'></span>";
          break;
        default:
          $fivthCol .= "<span class='{$colorClass}' title='" . date_convert::yyyymmdd_to_ddmm($value_2['date']) . " {$serving_ones_list[$value_2['serving_one']]}'></span>";
          break;
      }
    ?>
    <?php endforeach; ?>
    <?php
    $firstCol .= '</div>';
    $secondCol .= '</div>';
    $thirdCol .= '</div>';
    $fourthCol .= '</div>';
    $fivthCol .= '</div>';
    echo "{$firstCol}{$secondCol}{$thirdCol}{$fourthCol}{$fivthCol}</div>"; ?>
  <?php endforeach; ?>
  <!-- Список записей а последние четыре недели -->

</div>
