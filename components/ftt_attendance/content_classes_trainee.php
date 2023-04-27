<?php
$flt_skip_done = 0;
if (isset($_COOKIE['flt_skip_done'])) {
  $flt_skip_done = $_COOKIE['flt_skip_done'];
}

$skip_sort_date_ico = 'hide_element';
$skip_curent_sorting = 'skip_sort_date-desc';
if (isset($_COOKIE['skip_sorting'])) {
  $skip_curent_sorting = $_COOKIE['skip_sorting'];
}
if (isset($_COOKIE['skip_sorting'])) {
  if ($_COOKIE['skip_sorting'] === 'skip_sort_date-desc') {
    $skip_sort_date_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['skip_sorting'] === 'skip_sort_date-asc') {
    $skip_sort_date_ico = 'fa fa-sort-desc';
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
  <?php
  $skip_done_list = array('_all_' => 'Все', '0' =>'Не выполнены', '1' =>'На проверке', '2' =>'Выполнены');
  foreach ($skip_done_list as $key => $value) {
    $sel = '';
    if (trim($key) === $flt_skip_done) {
      $sel = 'selected';
    }
    echo "<option value='{$key}' {$sel}>{$value}";
  }
  ?>
  </select>
</div>
<!-- Хедер -->
<div class="pl-0">
  <div class="row row_corr">
    <div class="col-1 pl-1 text_blue"><b class="skip_sort_date" style="cursor: pointer;">Дата<i class="<?php echo $skip_sort_date_ico; ?>"></i></b></div>
    <div class="col-1"><b>Время</b></div>
    <div class="col-8"><b>Мероприятие</b></div>
    <div class="col-2"><b></b></div>
  </div>
</div>
<hr id="hight_line" style="margin-left: 0px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
<div id="list_skip" class="">
<?php
foreach (getMissedClasses($skip_curent_sorting, $memberId) as $key => $value) {
  $dayOfTheWeek = date_convert::week_days($value['date_blank'], true);
  if (isset($value['session_name']) && mb_substr(trim($value['session_name']), -1) === ')' && mb_substr($value['session_name'], -7, -6) === '(') {
    $session_time_echo = mb_substr(trim($value['session_name']), -6, -1);
  } else {
    $session_time_echo = $value['session_time'];
  }
  if (strlen($value['comment']) > 80) {
    $short_comment = mb_substr($value['comment'], 0, 80).'...';
  } else {
    $short_comment = $value['comment'];
  }

  $checked_string_skip = "<span class='badge badge-".$status_list[$value['status']][0]."'>".$status_list[$value['status']][1]."</span>";

  $skip_checked_string = "<span class='badge badge-".$status_list[$value['status']][0]."'>".$status_list[$value['status']][1]."</span>";
  $nameTrainee = short_name::no_middle($value['name']);
  $dateBlank = date_convert::yyyymmdd_to_ddmm($value['date_blank']);
  echo "<div class='row skip_string ml-0' data-id='{$value['id']}' data-date='{$value['date_blank']}' data-member_key='{$value['member_key']}' data-serving_one='{$value['serving_one']}'";
  echo " data-comment='{$value['comment']}' data-status='{$value['status']}' data-session_time='{$value['session_time']}' data-session_name='{$value['session_name']}' data-topic='{$value['topic']}' data-file='{$value['file']}' data-create_send='{$value['date']}'>";
  echo "<div class='col-1 pl-1'>{$dateBlank} {$dayOfTheWeek}</div><div class='col-1'>{$session_time_echo}</div><div class='col-8'>{$value['session_name']}<br><span class='grey_text'>{$short_comment}</span></div><div class='col-2'>{$checked_string_skip}</div></div>";
}
?>
</div>
