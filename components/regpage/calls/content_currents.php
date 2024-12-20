<!-- ТЕКУЩИЕ ЗАЯВКИ -->
<!-- заголовки колонок -->
<div class="row pb-2 mr-0 border-bottom">
  <div class="col pl-0">
    <b class="sort_col" data-sort="c.created_date">Дата <i class="<?php echo $sort_created_date_ico ?>"></i></b>
  </div>
  <div class="col pl-3">
    <b class="sort_col" data-sort="c.name">ФИО <i class="<?php echo $sort_fio_ico ?>"></i></b>
  </div>
  <div class="col pl-3">
    <b>Телефон</b>
  </div>
  <div class="col pl-3">
    <b>Комментарий</b>
  </div>
  <div class="col pl-3">
    <b></b>
  </div>
</div>

<!-- список -->
<div class="row mr-0 ml-0">
  <div class="calls_list container pl-0">
  <?php foreach (CallsDB::getCalls('currents', '', $sort_setting[0], $sort_setting[1], $fltGender, $fltAuthor, $fltSearch) as $key => $value): // $callsUserData['role'] ?>
    <div class="row call_str pl-0" data-id="<?php echo $value['id'] ?>">
      <div class="col pl-0">
        <div class="">
          <?php echo date_convert::yyyymmddhhmmss_to_ddmm($value['created_date']); ?>
          <?php echo date_convert::week_days($value['created_date'], true); ?>
        </div>
      </div>
      <div class="col">
        <div class="">
          <?php echo $value['name']; ?>
        </div>
      </div>
      <div class="col">
        <div class="">
          <?php echo phoneNumberPrepare($value['phone']);
          if (!empty($value['time_zone'])) {
            echo " {$value['time_zone']}";
          }
          ?>
        </div>
      </div>
      <div class="col">
        <div class="">
          <?php echo CutString::cut($value['comment'], 20); ?>
        </div>
      </div>
      <div class="col">
        <div class="">
          <?php

            if ($value['status'] === 'В работе') {
              $badgeClass = "secondary";
            } elseif ($value['status'] === 'Недозвон') {
              $badgeClass = "warning";
            } elseif ($value['status'] === 'Ошибка') {
              $badgeClass = "dark";
            } elseif ($value['status'] === 'Отказ') {
              $badgeClass = "danger";
            } elseif ($value['status'] === 'Повтор') {
              $badgeClass = "info";
            } elseif ($value['status'] === 'Уточнение') {
              $badgeClass = "primary";
            } elseif ($value['status'] === 'Заказ') {
              $badgeClass = "success";
            }
            echo "<span class='badge badge-{$badgeClass}'>{$value['status']}</span>";
          ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</div>
