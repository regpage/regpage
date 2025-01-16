<!-- ВХОДЯЩИЕ ЗАЯВКИ -->

<!-- список -->
<div class="row mr-0 ml-0">
  <div class="calls_list container pl-0">
  <?php foreach (CallsDB::getCalls('incomming', $callsUserData['role'], $sort_setting[0], $sort_setting[1], $fltGender, $fltAuthor, $fltSearch) as $key => $value): ?>
    <div class="row call_str pl-0" data-id="<?php echo $value['id'] ?>">
      <div class="col-md-1 col-3 pl-md-0">
        <div class="">
          <?php echo date_convert::yyyymmddhhmmss_to_ddmm($value['created_date']); ?>
          <?php echo date_convert::week_days($value['created_date'], true); ?>
        </div>
      </div>
      <div class="col-md-2 col-9">
        <div class="">
          <?php echo '<a href="tel:' . phoneNumberPrepare($value['phone']) . '" class="d-sm-none pr-3">' . phoneNumberPrepare($value['phone']) . '</a> <span class="d-none d-sm-inline"> ' . phoneNumberPrepare($value['phone']) . '</span>';
          if (!empty($value['time_zone'])) {
            echo " {$value['time_zone']} ";
          }
          ?>
        </div>
      </div>
      <div class="col-md-3 col-12">
        <div>
          <span class="d-sm-none pr-3 font-weight-bold"><?php echo $value['name']; ?></span> <span class="d-none d-sm-inline"><?php echo $value['name']; ?></span>
        </div>
      </div>
      <div class="col-md-4 d-none d-sm-inline">
        <div class="">
          <?php echo CutString::cut($value['comment'], 38); ?>
        </div>
      </div>
      <div class="col-md-2 col-12">
        <div class="">
          <button type="button" class="btn btn-light btn-sm get_to_work">Взять в работу</button>
          <?php echo '<span class="d-sm-none pl-3">' . CutString::cut($value['comment'], 15) . '</span>'; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</div>
