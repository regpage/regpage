<select id="modal_flt_list_trainees" class="form-control form-control-sm mb-2">
  <?php FTT_Select_fields::rendering($listTraneesByStaffForFlt, $cookieFltListTrainee, 'Все обучающиеся'); ?>
</select>
<select id="modal_flt_list_weeks" class="form-control form-control-sm mb-2">
  <?php FTT_Select_fields::rendering($weeks, $cookieFltListWeeks, 'Все недели'); ?>
</select>
<select id="modal_flt_list_servingone" class="form-control form-control-sm mb-2">
  <?php FTT_Select_fields::rendering($serving_ones_list, $cookieFltListServingone, 'Все служащие'); ?>
</select>
<select id="modal_flt_list_currents" class="form-control form-control-sm mb-2">
  <?php FTT_Select_fields::rendering(['Текущие', 'Все'], $cookieFltListCurrents); ?>
</select>
