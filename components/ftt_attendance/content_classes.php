<?php
$flt_skip_done = 1;
$flt_sevice_one_skip = $memberId;
$ftr_trainee_skip = '_all_';

if (isset($_COOKIE['flt_skip_done'])) {
  $flt_skip_done = $_COOKIE['flt_skip_done'];
}
if (isset($_COOKIE['flt_sevice_one_skip'])) {
  $flt_sevice_one_skip = $_COOKIE['flt_sevice_one_skip'];
}

if (isset($_COOKIE['ftr_trainee_skip'])) {
  $ftr_trainee_skip = $_COOKIE['ftr_trainee_skip'];
}

$skip_sort_date_ico = 'hide_element';
$skip_sort_trainee_ico = 'hide_element';
$skip_curent_sorting = 'skip_sort_date-desc';
if (isset($_COOKIE['skip_sorting'])) {
  $skip_curent_sorting = $_COOKIE['skip_sorting'];
}
if (isset($_COOKIE['skip_sorting'])) {
  if ($_COOKIE['skip_sorting'] === 'skip_sort_date-desc') {
    $skip_sort_date_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['skip_sorting'] === 'skip_sort_date-asc') {
    $skip_sort_date_ico = 'fa fa-sort-desc';
  } elseif ($_COOKIE['skip_sorting'] === 'skip_sort_trainee-desc') {
    $skip_sort_trainee_ico = 'fa fa-sort-asc';
  } elseif ($_COOKIE['skip_sorting'] === 'skip_sort_trainee-asc') {
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
  <select id="flt_sevice_one_skip" class="form-control form-control-sm mr-2">
    <option value="_all_">Все служащие</option>
    <?php foreach ($serving_ones_list as $key => $value):
      $selected = '';
      if ($key === $flt_sevice_one_skip) {
        $selected = 'selected';
      }
      echo "<option value='{$key}' {$selected}>{$value}</option>";
    endforeach; ?>
  </select>
  <select id="ftr_trainee_skip" class="form-control form-control-sm mr-2">
    <option value="_all_">Все обучающиеся</option>
    <?php foreach ($trainee_list as $key => $value):
      $selected = '';
      if ($key === $ftr_trainee_skip) {
        $selected = 'selected';
      }
      echo "<option value='{$key}' {$selected}>{$value}</option>";
    endforeach; ?>
  </select>
</div>
<!-- Хедер -->
<div class="pl-0">
  <div class="row row_corr">
    <div class="col-1 pl-1 text_blue"><b class="skip_sort_date" style="cursor: pointer;">Дата<i class="<?php echo $skip_sort_date_ico; ?>"></i></b></div>
    <div class="col-3 text_blue"><b class="skip_sort_trainee" style="cursor: pointer;">Обучающийся<i class="<?php echo $skip_sort_trainee_ico; ?>"></i></b></div>
    <div class="col-7"><b>Мероприятие</b></div>
    <div class="col-1"><b>Выполнено</b></div>
  </div>
</div>
<hr id="hight_line" style="margin-left: 0px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
<div id="list_skip" class="">
<?php
foreach (getMissedClasses($skip_curent_sorting) as $key => $value) {
  $dayOfTheWeek = date_convert::week_days($value['date_blank'], true);
  // name & time preparing
  $session_name_echo = explode(',', $value['session_name']);
  $session_time_and_during = $session_name_echo[1];
  $session_name_echo = $session_name_echo[0];
  $session_time_echo = explode('мин.', $session_time_and_during);
  $session_during = trim($session_time_echo[0]);
  if (isset($value['session_name']) && mb_substr(trim($value['session_name']), -1) === ')' && mb_substr($value['session_name'], -7, -6) === '(') {
    $session_time_echo = mb_substr(trim($session_time_and_during), -6, -1);
  } else {
    $session_time_echo = $value['session_time'];
  }
  // time rendering
  $all_seconds=0;
  list($hour, $minute) = explode(':', $session_time_echo);
  $second = 0;
  $all_seconds += intval($hour) * 3600;
  $all_seconds += (intval($minute) + intval($session_during)) * 60;
  $all_seconds += $second;
  $total_minutes = floor($all_seconds/60);
  $seconds = $all_seconds % 60;
  $hours = floor($total_minutes / 60);
  $minutes = $total_minutes % 60;
  $session_name_echo = $session_name_echo . ' ('. $session_time_echo . ' – ' . sprintf('%02d:%02d', $hours, $minutes). ')';

  if (strlen($value['comment']) > 80) {
    $short_comment = mb_substr($value['comment'], 0, 80).'...';
  } else {
    $short_comment = $value['comment'];
  }
  $disabled = '';
  $checked = '';
  if ($value['status'] == 0) {
    $disabled = 'disabled';
  } elseif ($value['status'] == 1) {

  } elseif ($value['status'] == 2) {
    $checked = 'checked';
  } else {
    $disabled = 'disabled';
  }
  $skip_checked_string = "<span class='badge badge-".$status_list[$value['status']][0]."'>".$status_list[$value['status']][1]."</span>";
  $nameTrainee = short_name::no_middle($value['name']);
  $dateBlank = date_convert::yyyymmdd_to_ddmm($value['date_blank']);
  echo "<div class='row skip_string ml-0' data-id='{$value['id']}' data-date='{$value['date_blank']}' data-member_key='{$value['member_key']}' data-serving_one='{$value['serving_one']}'";
  echo " data-comment='{$value['comment']}' data-status='{$value['status']}' data-session_time='{$value['session_time']}' data-session_name='{$value['session_name']}' data-topic='{$value['topic']}' data-file='{$value['file']}' data-create_send='{$value['date']}'>";
  echo "<div class='col-1 pl-1'>{$dateBlank} {$dayOfTheWeek}</div><div class='col-3'>{$nameTrainee}</div><div class='col-7'>{$session_name_echo}<br><span class='grey_text'>{$short_comment}</span></div><div class='col-1'><input type='checkbox' class='skip_done' {$checked} {$disabled}></div></div>";
}
?>
</div>
