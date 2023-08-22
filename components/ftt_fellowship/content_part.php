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
?>

<br>
<div id="meet_list_header" class="btn-group mb-2">
  <button type="button" id="meet_add" class="btn btn-success btn-sm rounded mr-2" data-toggle="modal" data-target="#edit_meet_blank">Добавить</button>
  <button type="button" id="meet_flt_modal_open" class="btn btn-primary btn-sm rounded mr-2" data-toggle="modal" data-target="#modal_meet_filters" style="display: none;">Фильтры</button>
</div>
<div id="meet_list_content" class="container">
  <div class="row row_meet mb-1">
    <div class="col-2 pl-1 text_blue"><b id="meet_sort_date" class="cursor-pointer">Дата<i class="<?php echo $meet_sort_date_ico; ?>"></i></b></div>
    <div class="col-2"><b>Время</b></div>
    <div class="col-2"><b>Продолж</b></div>
    <div class="col-3 text_blue"><b id="meet_sort_servingone" class="cursor-pointer">Служащий<i class="<?php echo $meet_sort_s_one_ico; ?>"></i></b></div>
    <div class="col-3"><b>Комментарий</b></div>
  </div>
  <hr style="margin-left: -15px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
<?php
  foreach (get_communication_records($memberId, $meet_curent_sorting) as $key => $value) {
    $date = date_convert::yyyymmdd_to_ddmm($value['date']);
    $day_of_week = date_convert::week_days($value['date'], true);
    $comment_short = CutString::cut($value['comment_train']);

    echo "<div class='row str_record' data-id='{$value['id']}' ";
    echo "data-duration='{$value['duration']}' data-trainee='{$value['trainee']}' data-serving_one='{$value['serving_one']}' data-time='{$value['time']}' data-date='{$value['date']}' data-comment='{$value['comment_train']}' data-cancel='{$value['cancel']}'>";
    echo "<div class='col-2 pl-1'>{$date} {$day_of_week}</div>";;
    echo "<div class='col-2'>{$value['time']}</div>";
    echo "<div class='col-2'>{$value['duration']}</div>";
    echo "<div class='col-3'>{$serving_ones_list[$value['serving_one']]}</div>";
    echo "<div class='col-3'>{$value['comment_train']}</div>";
    echo "</div>";
  }
?>
</div>
