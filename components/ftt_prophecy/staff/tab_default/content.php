<?php foreach (ProphecyDB::getListForServingones($cookieFltListTrainee, $listTraneesByStaffForFlt, $cookieFltListCurrents, $sortField, $sortType) as $key => $value): ?>
  <?php // заменить на исправленный cutString
  if (mb_strlen($value['topic']) > 82) {
    $shortTopic = mb_substr($value['topic'], 0, 82).'...';
  } else {
    $shortTopic = $value['topic'];
  } ?>
  <div class="row list_str pl-1 mr-0" data-id="<?php echo $value['id'] ?>">
    <div class="col-md-1 col-2">
      <?php echo date_convert::yyyymmddhhmmss_to_ddmm($value['date']); ?>
    </div>
    <div class="col-md-2 col-10 pr-0">
      <?php echo short_name::no_middle($value['name']) . ' (' . $value['semester'] . ')'; ?> <span class="float-right"><?php echo $value['done'] ? '✅' : ''; ?></span>
      <?php if ($cookieFltListServingone === '_all_'): ?>
        <br> <span class="grey_text"><?php echo $serving_ones_list[$value['serving_one']]; ?></span>
      <?php endif; ?>
    </div>
    <div class="col-md-1 col-2 text-right">
      <?php echo $value['week_number']; ?> <span class="d-md-none d-inline"> н.</span>
    </div>
    <div class="col-md-7 col-10">
      <?php echo $shortTopic; ?>
    </div>
     <div class="col-md-1 col-12">
       <?php if ($value['checked'] == 0 && $value['send_date'] === '0000-00-00 00:00:00'): ?>
         <span class="float-right badge badge-secondary">не отправлен</span>
       <?php endif; ?>
       <?php if ($value['checked'] == 0 && !empty($value['send_date']) && $value['send_date'] !== '0000-00-00 00:00:00'): ?>
         <span class="float-right badge badge-warning">на рассмотрении</span>
       <?php endif; ?>
       <?php if ($value['checked'] == 1): ?>
         <span class="float-right badge badge-success">проверено</span>
       <?php endif; ?>
    </div>
  </div>
  <hr class="my-0">
<?php endforeach; ?>
