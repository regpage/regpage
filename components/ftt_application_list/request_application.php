<br>
<div id="tab_request_for" class="container tab-pane  <?php echo $activeRequestFor; ?>" style="background-color: white;" data-role="<?php // echo $accessToPage; ?>">
  <div class="row">
    <div class="col-2">
      <strong>Дата</strong>
    </div>
    <div class="col-5">
      <strong>ФИО</strong>
    </div>
    <div class="col-2">
      <strong>Местность</strong>
    </div>
    <div class="col-2">
      <strong>Создать заявление</strong>
    </div>
    <div class="col-1 text-center">
      <strong>Удалить запрос</strong>
    </div>
  </div>

  <?php foreach (db_getRequestForApplication('', true) as $key => $value): ?>    
      <div class="row str_of_list border-top pt-2" data-member_key="<?php echo $value['member_key']; ?>" data-id="<?php echo $value['id']; ?>" data-guest="<?php echo $value['guest']; ?>">
        <div class="col-2">
          <?php echo $value['request_date']; ?>
        </div>
        <div class="col-5">
          <?php if ($value['guest']) {
            echo "ГОСТЬ ";
          } ?>
          <?php echo $value['name']; ?>
        </div>
        <div class="col-2">
          <?php echo $value['locality_name']; ?>
        </div>
        <div class="col-2">
          <button type="button" class="btn btn-sm btn-success btn_approve_request">Создать заявление</button>
        </div>
        <div class="col-1 text-center">
          <button class="btn btn-sm btn_delete_request"><i class="fa fa-trash text-danger" style="font-size: 1.2rem;"></i></button>
        </div>
      </div>
  <?php endforeach; ?>
</div>
