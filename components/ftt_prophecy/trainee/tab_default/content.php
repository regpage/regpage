<?php foreach (ProphecyDB::getListByMember($memberId) as $key => $value): ?>
  <div class="row list_str pl-0" data-id="<?php echo $value['id'] ?>">
    <div class="col-md-1 col-3 pl-md-0">
      <?php echo date_convert::yyyymmddhhmmss_to_ddmm($value['date']); ?>
    </div>
    <div class="col-md-2 col-9">
      <?php echo CutString::cut($value['prophecy'], 50); ?>
    </div>
  </div>
<?php endforeach; ?>
