<div class="container">
  <div class="row">
    <div class="col-2">
      <strong>Key / id</strong>
    </div>
    <div class="col-2">
      <strong>Дата</strong>
    </div>
    <div class="col-4">
      <strong>ФИО</strong>
    </div>
    <div class="col-2">
      <strong>Местность</strong>
    </div>
    <div class="col-1">
      <strong>Гость</strong>
    </div>
    <div class="col-1">
      <strong>Прогресс</strong>
    </div>
  </div>
  <hr class="mb-2 mt-2">
<?php
  $counter = 0;
  foreach (db_getApplicationsPanel('') as $key => $value):
  $counter++;
  $progress = 0;
  foreach ($value as $key_2 => $value_2) {
    if ($value_2) {
      $progress++;
    }
  }
  if ($progress > 137) {
    $progress = 100;
  } else {
    $progress = $progress * 100 / 137;
  }
?>
      <div class="row str_of_list cursor-pointer" data-member_key="<?php echo $value['member_key']; ?>" data-id="<?php echo $value['id']; ?>">
        <div class="col-2">
          <?php echo $value['member_key'].'<br>'.$value['id']; ?>
        </div>
        <div class="col-2">
          <?php echo $value['request_date']; ?>
        </div>
        <div class="col-4">
          <?php echo $value['name']; ?>
        </div>
        <div class="col-2">
          <?php echo $value['locality_name']; ?>
        </div>
        <div class="col-1">
          <?php if ($value['guest']) {
            echo 'ГОСТЬ';
          }  ?>
        </div>
        <div class="col-1">
          <?php echo round($progress).'%' ; ?>
        </div>
      </div>
      <hr class="mb-2 mt-2">
<?php endforeach; ?>
  <div class="row">
    <div class="col">
      <strong>Всего:
      <?php echo $counter; ?>
      </strong>
    </div>
  </div>
</div>
