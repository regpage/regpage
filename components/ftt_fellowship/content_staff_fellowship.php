<!-- Подраздел общение -->
<?php require_once 'components/ftt_fellowship/ctrl_content_staff.php'; ?>
<div id="meet_list_header" class="btn-group mb-2" style="padding-top: 21px;">
  <?php if ($memberId === '000001679'): ?>
    <button type="button" id="meet_add_staff" class="btn btn-success btn-sm rounded mr-2" data-toggle="modal" data-target="#mdl_edit_fellowship_staff">Добавить</button>
  <?php endif; ?>
  <select id="meet_serving_ones_list" class="form-control form-control-sm mr-2">
    <option value="_all_">Все служащие</option>
    <?php foreach ($serving_ones_list_meet as $key => $value):
      $selected = "";
      if ($serving_ones_flt === $key) {
        $selected = "selected";
      }
      echo "<option value='{$key}' {$selected}>{$value}</option>";
    endforeach; ?>
    <option disabled>----КБК----</option>";
    <?php foreach ($kbk_list as $key => $value):
      $selected = "";
      if ($serving_ones_flt === $key) {
        $selected = "selected";
      }
      echo "<option value='{$key}' {$selected}>{$value}</option>";
    endforeach; ?>
  </select>
  <select id="meet_trainee_select" class="form-control form-control-sm mr-2">
    <option value="_all_">Все обучающиеся</option>
    <?php foreach ($trainee_list as $key => $value):
      $selected = "";
      if ($trainee_flt === $key) {
        $selected = "selected";
      }
      echo "<option value='{$key}' {$selected}>{$value}</option>";
    endforeach; ?>
  </select>
  <select id="fellowship_active" class="form-control form-control-sm">
    <option value="1" <?php if ($active_flt === '1') echo 'selected'; ?>>Текущие</option>
    <option value="0" <?php if ($active_flt === '0') echo 'selected'; ?>>Архивные</option>
  </select>
  <button type="button" id="meet_flt_modal_open" class="btn btn-primary btn-sm rounded mr-2" data-toggle="modal" data-target="#modal_meet_filters" style="display: none;">Фильтры</button>
</div>
<div id="meet_list_content_staff" class="container">
  <div class="row row_meet mb-1">
    <div class="col-1 text_blue pl-1"><b id="meet_sort_date" class="cursor-pointer">Дата<i class="<?php echo $meet_sort_date_ico; ?>"></i></b></div>
    <div class="col-2 text_blue" style="max-width: 120px;"><b id="meet_sort_time" class="cursor-pointer">Время<i class="<?php echo $meet_sort_time_ico; ?>"></i></b></div>
    <div class="col-1 text-right"><b>Продолж</b></div>
    <div class="col-2 text_blue"><b id="meet_sort_trainee" class="cursor-pointer">Обучающийся<i class="<?php echo $meet_sort_trainee_ico; ?>"></i></b></div>
    <div class="col-2 text_blue"><b id="meet_sort_servingone" class="cursor-pointer">Служащий<i class="<?php echo $meet_sort_s_one_ico; ?>"></i></b></div>
    <div class="col-4"><b>Комментарий</b></div>
  </div>
  <hr style="margin-left: -15px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
<?php
  foreach (get_communication_records_staff($serving_ones_flt, $trainee_flt, $active_flt, $meet_curent_sorting) as $key => $value) {
    $hide = '';
    if ($serving_ones_flt === $memberId) {
      $hide = 'd-none';
    }
    $bg_busy = '';
    if (!empty($value['trainee'])) {
      $bg_busy = 'green_string';
    }
    $time_to = '';
    if (!empty($value['time']) && !empty($value['duration'])) {
      $time_to = time_convert::sum($value['time'], $value['duration']);
    }

    $date = date_convert::yyyymmdd_to_ddmm($value['date']);
    $day_of_week = date_convert::week_days($value['date'], true);
    //$comment_short = CutString::cut($value['comment_serv']);
    $comment_short_trainee = CutString::cut($value['comment_train'], 30);
    echo "<div class='row str_record_staff {$bg_busy}'";
    echo "data-id='{$value['id']}' data-serving_one='{$value['serving_one']}' data-trainee='{$value['trainee']}' ";
    echo "data-date='{$value['date']}' data-time='{$value['time']}' data-duration='{$value['duration']}' ";
    echo "data-comment='{$value['comment_train']}' data-cancel='{$value['cancel']}'>";
    echo "<div class='col-1 pl-1'>{$date} {$day_of_week}</div>";
    echo "<div class='col-2' style='max-width: 120px;'>{$value['time']}–{$time_to}</div>";
    echo "<div class='col-1 text-right'>{$value['duration']}</div>";
    echo "<div class='col-3 text-secondary' style='display: none;'>коммент.</div>";
    echo "<div class='col-2'><div>{$trainee_list[$value['trainee']]}</div><div class='grey_text'>{$serving_ones_list[$trainee_list_list[$value['trainee']]['serving_one']]}</div></div>";
    echo "<div class='col-2 {$hide}'>{$serving_ones_list[$value['serving_one']]}</div>";
    echo "<div class='col-4'>{$comment_short_trainee}</div>"; //<br><span class='grey_text'>{$comment_short}</span>
    echo "</div>";
  }
?>
</div>
