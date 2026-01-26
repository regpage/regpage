<?php foreach (ProphecyDB::getListByMember($memberId, $cookieAll) as $key => $value): ?>
  <div class="row list_str pl-1 mr-0" data-id="<?php echo $value['id'] ?>">
    <div class="col-md-1 col-2">
      <?php echo date_convert::yyyymmddhhmmss_to_ddmm($value['date']); ?>
    </div>
    <div class="col-md-1 col-3 text-right">
      <?php echo $value['week_number']; ?> <span class="d-md-none d-inline"> нед.</span>
    </div>
    <div class="col-md-8 col-7">
      <?php echo CutString::cut($value['topic'], 50); ?>
    </div>
    <div class="col-md-2 col-12">
      <?php echo $value['done'] ? '<span class="">✅</span>' : ''; ?>
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
