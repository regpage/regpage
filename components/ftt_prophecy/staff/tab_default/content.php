<?php foreach (ProphecyDB::getListForServingones($cookieFltListTrainee, $cookieFltListWeeks) as $key => $value): ?>
  <div class="row list_str pl-1 mr-0" data-id="<?php echo $value['id'] ?>">
    <div class="col-md-1 col-2">
      <?php echo date_convert::yyyymmddhhmmss_to_ddmm($value['date']); ?>
    </div>
    <div class="col-md-1 col-2 text-right">
      <?php echo $value['week_number']; ?> <span class="d-md-none d-inline"> н.</span>
    </div>
    <div class="col-md-8 col-7">
      <?php echo short_name::no_middle($value['name']) ?>
    </div>
    <div class="col-md-1 col-2">
      <input type="checkbox" class="form-control-sm" <?php echo $value['done'] ? 'checked' : ''; ?> disabled>
    </div>
    <div class="col-md-1 col-2">
      <input type="checkbox" class="form-control-sm checked_in_list" name="checked" <?php echo $value['checked'] ? 'checked' : ''; ?>>
    </div>
  </div>
  <hr class="my-0">
<?php endforeach; ?>
