<?php
$skip_sort_date_ico = 'hide_element';
$skip_sort_trainee_ico = 'hide_element';
$skip_curent_sorting = 'sort_date-desc';
if (isset($_COOKIE['skip_sorting'])) {
$skip_curent_sorting = $_COOKIE['skip_sorting'];
}
if (isset($_COOKIE['skip_sorting'])) {
  if ($_COOKIE['skip_sorting'] === 'sort_date-desc') {
    $skip_sort_date_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['skip_sorting'] === 'sort_date-asc') {
    $skip_sort_date_ico = 'fa fa-sort-desc';
  } elseif ($_COOKIE['skip_sorting'] === 'sort_trainee-desc') {
    $skip_sort_trainee_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['skip_sorting'] === 'sort_trainee-asc') {
    $skip_sort_trainee_ico = 'fa fa-sort-desc';
  } else {
    $skip_sort_date_ico = 'fa fa-sort-asc';
  }
} else {
  $skip_sort_date_ico = 'fa fa-sort-asc';
}
?>
<br>
<!-- Кнопки и фильтры -->
<div id="skip_list_header" class="btn-group mb-2">
  <button type="button" id="skip_flt_modal_o" class="btn btn-primary btn-sm rounded mr-2" data-toggle="modal" data-target="#skip_ftr_modal" style="display: none;">Фильтры</button>
  <select id="flt_skip_done" class="form-control form-control-sm mr-2">
    <option value="_all_" <?php if ($flt_skip_active === '_all_') echo 'selected'; ?>>Все</option>
    <option value="1" <?php if ($flt_skip_active === '1') echo 'selected'; ?>>Выполнены</option>
    <option value="0" <?php if ($flt_skip_active === '0') echo 'selected'; ?>>Не выполнены</option>
    <option value="2" <?php if ($flt_skip_active === '2') echo 'selected'; ?>>Приняты</option>
  </select>
  <select id="flt_sevice_one_skip" class="form-control form-control-sm mr-2">
    <option value="_all_">Все служащие</option>
    <?php foreach ($serving_ones_list as $key => $value):
      $selected = '';
      if ($key === $serving_one_skip) {
        $selected = 'selected';
      }
      echo "<option value='{$key}' $selected>{$value}</option>";
    endforeach; ?>
  </select>
  <select id="ftr_trainee_skip" class="form-control form-control-sm mr-2">
    <option value="_all_">Все обучающиеся</option>
    <?php foreach ($trainee_list as $key => $value):
      $selected = '';
      if ($key === $trainee_skip) {
        $selected = 'selected';
      }
      echo "<option value='{$key}' {$selected}>{$value}</option>";
    endforeach; ?>
  </select>
</div>
<!-- Хедер -->
<div class="pl-0">
  <div class="row row_corr">
    <div class="col-1 pl-1 text_blue"><b class="skip_sort_date cursor-pointer">Дата<i class="<?php echo $skip_sort_date_ico; ?>"></i></b></div>
    <div class="col-3 text_blue"><b class="skip_sort_trainee cursor-pointer">Обучающийся<i class="<?php echo $skip_sort_trainee_ico; ?>"></i></b></div>
    <div class="col-3"><b>Занятие</b></div>
    <div class="col-3"><b>Комментарий</b></div>
    <div class="col-2"><b>Статус</b></div>
  </div>
</div>
<hr id="hight_line" style="margin-left: 0px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
<div id="list_skip" class="">
<?php
foreach (getMissedClasses() as $key => $value) {
  $skip_checked_string = "<span class='badge badge-".$status_list[$value['status']][0]."'>".$status_list[$value['status']][1]."</span>";
  $nameTrainee = short_name::no_middle($value['name']);
  $dateBlank = date_convert::yyyymmdd_to_ddmm($value['date_blank']);
  echo "<div class='row skip_string ml-0' data-id='{$value['id']}' data-member_key='{$value['member_key']}' data-serving_one='{$value['serving_one']}' data-comment='{$value['comment']}' data-status='{$value['status']}' data-file='{$value['file']}'><div class='col-1 pl-1'>{$dateBlank}</div><div class='col-3'>{$nameTrainee}</div><div class='col-3'>{$value['session_name']}<br>{$value['session_time']}</div><div class='col-3'>{$value['comment']}</div><div class='col-2'>{$skip_checked_string}</div></div>";
}
?>
</div>
