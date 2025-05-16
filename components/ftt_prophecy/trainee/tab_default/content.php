<?php foreach (ProphecyDB::getListByMember($memberId) as $key => $value): ?>
  <div class="row list_str pl-1 mr-0" data-id="<?php echo $value['id'] ?>">
    <div class="col-md-1 col-4">
      <?php echo date_convert::yyyymmddhhmmss_to_ddmm($value['date']); ?>
    </div>
    <div class="col-md-1 col-1 text-right">
      <?php echo $value['week_number']; ?>
    </div>
    <div class="col-md-10 col-7">
      <?php echo CutString::cut($value['topic'], 50); ?>
    </div>
  </div>
  <hr class="my-0">
<?php endforeach; ?>
