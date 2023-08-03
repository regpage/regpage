<?php
// Сортировка
if (isset($_COOKIE['meet_sorting'])) {
  $meet_curent_sorting = $_COOKIE['meet_sorting'];
  $fa_sort_arr = explode('-', $meet_curent_sorting);
  if (isset($fa_sort_arr[1]) && $fa_sort_arr[1] === 'asc') {
    $fa_sort = 'fa fa-sort-asc';
  } elseif (isset($fa_sort_arr[1]) && $fa_sort_arr[1] === 'desc') {
    $fa_sort = 'fa fa-sort-desc';
  }
  if ($fa_sort_arr[0] === 'meet_sort_date') {
    $meet_sort_date_ico = $fa_sort;
    $meet_sort_s_one_ico = 'hide_element';
  } elseif ($fa_sort_arr[0] === 'meet_sort_servingone') {
    $meet_sort_date_ico = 'hide_element';
    $meet_sort_s_one_ico = $fa_sort;
  } else {
    $meet_sort_date_ico = 'fa fa-sort-asc';
    $meet_sort_s_one_ico = 'hide_element';
    $meet_curent_sorting = 'meet_sort_date-desc';
  }
} else {
  $meet_sort_date_ico = 'fa fa-sort-asc';
  $meet_sort_s_one_ico = 'hide_element';
  $meet_curent_sorting = 'meet_sort_date-desc';
}

// Фильтры
if (isset($_COOKIE['meet_serving_one'])) {
  $serving_ones_flt = $_COOKIE['meet_serving_one'];
} else {
  $serving_ones_flt = $memberId;
}

if (isset($_COOKIE['meet_trainee'])) {
  $trainee_flt = $_COOKIE['meet_serving_one'];
} else {
  $trainee_flt = '_all_';
}
?>
<br>
<div id="meet_list_header" class="btn-group mb-2">
  <button type="button" id="meet_add_staff" class="btn btn-success btn-sm rounded mr-2" data-toggle="modal" data-target="#mdl_edit_fellowship_staff">Добавить</button>
  <select id="meet_serving_ones_list" class="form-control form-control-sm">
    <option value="_all_"></option>
    <?php foreach ($serving_ones_list as $key => $value):
      $selected = "";
      if ($serving_ones_flt === $key) {
        $selected = "selected";
      }
      echo "<option value='{$key}' {$selected}>{$value}</option>";
    endforeach; ?>
    <option disabled>----КБК----</option>";
    <?php foreach ($kbk_list as $key => $value):
      echo "<option value='{$key}'>{$value}</option>";
    endforeach; ?>

  </select>
  <button type="button" id="meet_flt_modal_open" class="btn btn-primary btn-sm rounded mr-2" data-toggle="modal" data-target="#modal_meet_filters" style="display: none;">Фильтры</button>
</div>
<div id="meet_list_content_staff" class="container">
  <div class="row mb-1">
    <div class="col-2 text_blue"><b id="meet_sort_date" class="cursor-pointer">Дата<i class="<?php echo $meet_sort_date_ico; ?>"></i></b></div>
    <div class="col-2"><b>Время</b></div>
    <div class="col-2"><b>Продолж</b></div>
    <div class="col-2 text_blue"><b id="meet_sort_servingone" class="cursor-pointer">Служащий<i class="<?php echo $meet_sort_s_one_ico; ?>"></i></b></div>
    <div class="col-2 text_blue"><b id="meet_sort_trainee" class="cursor-pointer">Обучающийся<i class="<?php echo $meet_sort_trainee_ico; ?>"></i></b></div>
    <div class="col-2"><b>Комментарий</b></div>
  </div>
  <hr style="margin-left: -15px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
<?php
  foreach (get_communication_records_staff($serving_ones_flt, $trainee_flt, $sort) as $key => $value) {
    $bg_empty = '';
    if (empty($value['trainee'])) {
      $bg_empty = 'bg-warning';
    }
    $date = yyyymmdd_to_ddmm($value['date']);
    $comment_short = CutString::cut($value['comment_serv']);
    echo "<div class='row mt-1 mb-1 cursor-pointer str_record_staff {$bg_empty}' ";
    echo "data-id='{$value['id']}' data-serving_one='{$value['serving_one']}' data-trainee='{$value['trainee']}' ";
    echo "data-date='{$value['date']}' data-time='{$value['time']}' data-duration='{$value['duration']}' ";
    echo "data-comment_train='{$value['comment_train']}' data-comment_serv='{$value['comment_serv']}' data-cancel='{$value['cancel']}'>";
    echo "<div class='col-2'>{$date}</div>";
    echo "<div class='col-2'>{$value['time']}</div>";
    echo "<div class='col-2'>{$value['duration']}</div>";
    echo "<div class='col-2'>{$serving_ones_list[$value['serving_one']]}</div>";
    echo "<div class='col-2'>{$trainee_list[$value['trainee']]}</div>";
    echo "<div class='col-2'>{$comment_short}</div>";
    echo "</div>";
  }
?>
</div>

<?php // MODALS
include 'components/ftt_attendance/modal_meet.php';
?>
