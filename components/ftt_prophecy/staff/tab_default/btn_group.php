<button id="addProphecy" class="btn btn-success btn-sm mr-2 rounded" type="button" title="Добавить новую запись" data-toggle="modal" data-target="#modal_edit_add_md">
  <i class="d-inline d-sm-none fa fa-plus"></i> <span class="d-none d-md-inline">Добавить</span>
</button>
<select id="flt_list_trainees" class="form-control form-control-sm mr-2">
  <?php FTT_Select_fields::rendering($listTraneesByStaffForFlt, $cookieFltListTrainee, 'Все обучающиеся'); ?>
</select>
<select id="flt_list_weeks" class="form-control form-control-sm mr-2">
  <?php FTT_Select_fields::rendering($weeks, $cookieFltListWeeks, 'Все недели'); ?>
</select>
<select id="flt_list_servingone" class="form-control form-control-sm mr-2">
  <?php FTT_Select_fields::rendering($serving_ones_list, $cookieFltListServingone, 'Все служащие'); ?>
</select>
<select id="flt_list_currents" class="form-control form-control-sm mr-2">
  <?php FTT_Select_fields::rendering(['Текущие', 'Все'], $cookieFltListCurrents); ?>
</select>
