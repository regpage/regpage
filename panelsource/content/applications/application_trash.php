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
    <div class="col-2">
      <strong>Доп.</strong>
    </div>
  </div>

<?php foreach (db_getApplicationsPanel('', true) as $key => $value): ?>
      <div class="row str_of_list" data-member_key="<?php echo $value['member_key']; ?>" data-id="<?php echo $value['id']; ?>">
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
        <div class="col-2">
          <?php if ($value['guest']) {
            echo 'ГОСТЬ';
          }  ?>
        </div>
      </div>
<?php endforeach; ?>
</div>
