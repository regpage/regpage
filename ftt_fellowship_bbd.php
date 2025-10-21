<?php
define("IS_FTT_PAGE", true);
// GLOBAL CNTRL
// db
include_once 'config.php';

$memberId = $_GET['member_key'];

include_once 'db/classes/ftt_lists.php';
$kbk_list = ftt_lists::kbk_brothers();
// проверить есть ли ключ в списке служащих
if (!array_key_exists($memberId, $kbk_list)) {
  exit;
}
include_once 'db/classes/trainee_data.php';
include_once 'db/classes/short_name.php';
include_once 'db/classes/CutString.php';
include_once 'db/classes/date_convert.php';
include_once 'db/classes/statistics.php';
include_once 'db/classes/ftt_info.php';
include_once 'db/classes/extra_lists.php';
include_once 'db/ftt/ftt_fellowship_db.php';
include_once 'db/classes/time_convert.php';

// components
include_once 'components/ftt_blocks/FTT_Select_fields.php';

/**
* Глобальные переменные
*
**/
// GLOBALS
$gl_time_zones = extra_lists::get_time_zones_list();
// access
$serving_trainee = '';

// lists
$serving_ones_list = ftt_lists::serving_ones();
$serving_ones_list_list = ftt_lists::serving_ones_list();
$trainee_list = ftt_lists::trainee();
$trainee_list_list = ftt_lists::trainee_list();

// SECTION CNTRL MAIN

$serving_ones_list_full = ftt_lists::serving_ones_full();
$trainee_list_full = ftt_lists::trainee_full();


$serving_ones_list_meet = ftt_lists::get_fellowship_list();

$serving_ones_list = array_merge($serving_ones_list_meet, $kbk_list);
// Активный подраздел
$fellowship_tab_active = '';
$fellowship_bbd_tab_active = 'active';
$fellowship_activity_tab_active = '';

// SECTION CNTRL
// Сортировка
$meet_sort_date_ico = 'fa fa-sort-asc';
$meet_sort_s_one_ico = 'hide_element';
$meet_sort_trainee_ico = 'hide_element';
$meet_sort_time_ico = 'hide_element';
$meet_curent_sorting = 'meet_sort_date-asc';

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
    $meet_sort_trainee_ico = 'hide_element';
    $meet_sort_time_ico = 'hide_element';
  } elseif ($fa_sort_arr[0] === 'meet_sort_servingone') {
    $meet_sort_date_ico = 'hide_element';
    $meet_sort_s_one_ico = $fa_sort;
    $meet_sort_trainee_ico = 'hide_element';
    $meet_sort_time_ico = 'hide_element';
  } elseif ($fa_sort_arr[0] === 'meet_sort_trainee') {
    $meet_sort_date_ico = 'hide_element';
    $meet_sort_s_one_ico = 'hide_element';
    $meet_sort_trainee_ico = $fa_sort;
    $meet_sort_time_ico = 'hide_element';
  } elseif ($fa_sort_arr[0] === 'meet_sort_time') {
    $meet_sort_date_ico = 'hide_element';
    $meet_sort_s_one_ico = 'hide_element';
    $meet_sort_trainee_ico = 'hide_element';
    $meet_sort_time_ico = $fa_sort;
  } else {
    $meet_sort_date_ico = 'fa fa-sort-asc';
    $meet_sort_s_one_ico = 'hide_element';
    $meet_sort_trainee_ico = 'hide_element';
    $meet_sort_time_ico = 'hide_element';
    $meet_curent_sorting = 'meet_sort_date-asc';
  }
} else {
  $meet_sort_date_ico = 'fa fa-sort-asc';
  $meet_sort_s_one_ico = 'hide_element';
  $meet_sort_trainee_ico = 'hide_element';
  $meet_sort_time_ico = 'hide_element';
  $meet_curent_sorting = 'meet_sort_date-asc';
}

// Фильтры
// вкладка служащие
$serving_ones_flt = $memberId;

if (!empty($_COOKIE['meet_flt_trainee'])) {
  $trainee_fltBBD = $_COOKIE['meet_flt_trainee'];
} else {
  $trainee_fltBBD = '_all_';
}

if (isset($_COOKIE['meet_flt_active'])) {
  $active_fltBBD = $_COOKIE['meet_flt_active'];
} else {
  $active_fltBBD = 1;
}

include_once 'header2.php';
?>


<!-- JS MAIN -->
<script>
  // serving ones list
  let serving_ones_list_tmp = "<?php foreach ($serving_ones_list as $id => $name) echo $id.'_'.$name.'_'; ?>";
  serving_ones_list_tmp = serving_ones_list_tmp ? serving_ones_list_tmp.split('_') : [];
  let serving_ones_list = [];
  for (let i = 0; i < serving_ones_list_tmp.length; i = i + 2) {
    serving_ones_list[serving_ones_list_tmp[i]] = serving_ones_list_tmp[i+1];
  }

  // trainee list
  let trainee_list_tmp = "<?php foreach ($trainee_list as $id => $name) echo $id.'_'.$name.'_'; ?>";
  trainee_list_tmp = trainee_list_tmp ? trainee_list_tmp.split('_') : [];
  let trainee_list = [];
  for (let i = 0; i < trainee_list_tmp.length; i = i + 2) {
    trainee_list[trainee_list_tmp[i]] = trainee_list_tmp[i+1];
  }

  // trainee_access
  let ftt_access_trainee = "";
  <?php if ($ftt_access['ftt_service']): ?>
    ftt_access_trainee = "<?php echo strval($ftt_access['ftt_service']); ?>";
  <?php endif; ?>

  ftt_access_trainee === 6 ? ftt_access_trainee = true : ftt_access_trainee = false;
  let coordinator = "<?php echo $serving_trainee; ?>";
  if (!ftt_access_trainee && coordinator) {
    ftt_access_trainee = true;
  }
  let trainee_access = false;
  trainee_access = "<?php if ($ftt_access['group'] === 'trainee') { echo "1"; } ?>";

  // admin key
  let admin_id_gl = "<?php echo $memberId;?>";
  // получаем текущую дату
  let gl_date_now = date_now_gl();
</script>

<!-- JS SECTION -->
<script>
// ------ ACTIVITY TAB ------
if ($(window).width()<=769) {
  $(".row_meet").hide();
  if ($("#fellowship_tab_activity").hasClass("active")) {
    $("#meet_list_content_staff .activity_str .week_col").hide();
    $("#meet_list_content_staff .activity_str .col_mbl").show();
  }
}
// serving ones list
/*let serving_ones_list_tmp;
serving_ones_list_tmp = "<?php
//$kbk_list = array_merge($serving_ones_list, $kbk_list);
foreach ($kbk_list as $id => $name) echo $id.'_'.$name.'_'; ?>";
*/
// full
serving_ones_list_full_tmp = "<?php foreach ($serving_ones_list_full as $id => $values) echo $id.'_'.$values[0].'_'.$values[1].'_'; ?>";
serving_ones_list_full_tmp = serving_ones_list_full_tmp ? serving_ones_list_full_tmp.split('_') : [];
let serving_ones_list_full = [];
for (let i = 0; i < serving_ones_list_full_tmp.length; i = i + 3) {
  serving_ones_list_full[serving_ones_list_full_tmp[i]] = {'name': serving_ones_list_full_tmp[i+1], 'male': serving_ones_list_full_tmp[i+2]};
}

// full
trainee_list_tmp = "<?php foreach ($trainee_list_full as $id => $value) echo $id.'_'.$value[0].'_'.$value[1].'_'.$value[4].'_'.$value[5].'_'; ?>";
trainee_list_tmp = trainee_list_tmp ? trainee_list_tmp.split('_') : [];
let trainee_list_full = [];
for (let i = 0; i < trainee_list_tmp.length; i = i + 5) {
  trainee_list_full[trainee_list_tmp[i]] = {'name': trainee_list_tmp[i+1], 'male': trainee_list_tmp[i+2], 'semester': trainee_list_tmp[i+3], 'time_zone': trainee_list_tmp[i+4]};
}
</script>
<script src="/js/ftt/ftt_fellowship/script.js?v21"></script>
<script src="/js/ftt/ftt_fellowship/design.js?v23"></script>
<script src="/js/modules/week.js?v1"></script>
<script src="/js/modules/time.js?v1"></script>
<script src="/js/modules/date.js?v1"></script>
<script src="/js/modules/blank.js?v1"></script>



<div id="main_container" class="container-xl" style="margin-top: 10px; padding-left: 20px; padding-bottom: 25px; background-color: white; max-width: 1170px;">
  <!-- Подраздел общение -->
  <div id="meet_list_header" class="btn-group mb-2" style="padding-top: 21px;">
    <select id="meet_trainee_select" class="form-control form-control-sm mr-2">
      <option value="_all_">Все обучающиеся</option>
      <?php foreach ($trainee_list as $key => $value):
        $selected = "";
        if ($trainee_fltBBD === $key) {
          $selected = "selected";
        }
        echo "<option value='{$key}' {$selected}>{$value}</option>";
      endforeach; ?>
    </select>
    <select id="fellowship_active" class="form-control form-control-sm">
      <option value="1" <?php if ($active_fltBBD === '1') echo 'selected'; ?>>Текущие</option>
      <option value="0" <?php if ($active_fltBBD === '0') echo 'selected'; ?>>Архивные</option>
    </select>
    <button type="button" id="meet_flt_modal_open" class="btn btn-primary btn-sm rounded mr-2" data-toggle="modal" data-target="#modal_meet_filters" style="display: none;">Фильтры</button>
  </div>
  <div id="meet_list_content_staff" class="container">
    <div id="columns_header" class="row row_meet mb-1">
      <div class="col-1 text_blue pl-1"><b id="meet_sort_date" class="cursor-pointer">Дата<i class="<?php echo $meet_sort_date_ico; ?>"></i></b></div>
      <div class="col-2 text_blue" style="max-width: 120px;"><b id="meet_sort_time" class="cursor-pointer">Время<i class="<?php echo $meet_sort_time_ico; ?>"></i></b></div>
      <div class="col-1 text-right"><b>Продолж</b></div>
      <div class="col-2 text_blue"><b id="meet_sort_trainee" class="cursor-pointer">Обучающийся<i class="<?php echo $meet_sort_trainee_ico; ?>"></i></b></div>
      <div class="col-6"><b>Комментарий</b></div>
    </div>
    <hr style="margin-left: -15px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
  <?php
    foreach (get_communication_records_staff($memberId, $trainee_fltBBD, $active_fltBBD, $meet_curent_sorting) as $key => $value) {
      $hide = '';

      $bg_busy = '';
      if (!empty($value['trainee']) && $value['trainee'] !== '_none_') {
        $bg_busy = 'green_string';
      }
      $time_to = '';
      if (!empty($value['time']) && !empty($value['duration'])) {
        $time_to = time_convert::sum($value['time'], $value['duration']);
      }

      $date = date_convert::yyyymmdd_to_ddmm($value['date']);
      $day_of_week = date_convert::week_days($value['date'], true);
      $traineeForList = '';
      if (isset($trainee_list[$value['trainee']])) {
        $traineeForList = $trainee_list[$value['trainee']];
      }
      $servingoneForList = '';
      if (isset($trainee_list[$value['trainee']])) {
        $servingoneForList = $serving_ones_list[$trainee_list_list[$value['trainee']]['serving_one']];
      }

      //$comment_short = CutString::cut($value['comment_serv']);
      $comment_short_trainee = CutString::cut($value['comment_train'], 30);
      echo "<div class='row str_record_staff {$bg_busy}'";
      echo "data-id='{$value['id']}' data-serving_one='{$value['serving_one']}' data-trainee='{$value['trainee']}' ";
      echo "data-date='{$value['date']}' data-time='{$value['time']}' data-duration='{$value['duration']}' ";
      echo "data-comment='{$value['comment_train']}' data-cancel='{$value['cancel']}'>";
      echo "<div class='col-3 col-md-1 pl-1'>{$date} {$day_of_week}</div>";
      echo "<div class='col-6 col-md-2 line_period' style='max-width: 120px;'>{$value['time']}–{$time_to}</div>";
      echo "<div class='col-1 text-right line_duration'>{$value['duration']}</div>";
      echo "<div class='col-6 col-md-2 line_trainee'><div>{$traineeForList}</div><div class='grey_text'>{$servingoneForList}</div></div>";
      echo "<div class='col-6 col-md-6'>{$comment_short_trainee}</div>"; //<br><span class='grey_text'>{$comment_short}</span>
      echo "</div>";
    }
  ?>
  </div>
</div>

<!-- MADAL ОБЩЕНИЕ ЗАПИСЬ -->
<div id="mdl_edit_fellowship_staff" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-date="" data-trainee="" data-comment="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Запись на общение</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row mb-2">
            <div class="col">
              <select id="mdl_meet_trainee_list" class="form-control form-control-sm" disabled>
                <option value="_none_"></option>
                <?php foreach ($trainee_list as $key => $value):
                  echo "<option value='{$key}'>{$value}</option>";
                endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <select id="mdl_meet_serving_ones_list" class="form-control form-control-sm" disabled>
                <option value="_none_"></option>
                <?php
                  echo "<option value='{$memberId}'>{$kbk_list[$memberId]}</option>";
                ?>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-6">
              <input type="date" id="mdl_meet_date" class="form-control form-control-sm" disabled>
            </div>
            <div class="col-4">
              <input type="time" id="mdl_meet_time" class="form-control form-control-sm" style="max-width: 100% !important;" disabled>
            </div>
            <div class="col-2">
              <input type="text" id="mdl_meet_duration" class="form-control form-control-sm" style="max-width: 100% !important;" disabled>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <textarea id="mdl_meet_comment_trainee" class="form-control form-control-sm" rows="4" placeholder="Комментарий" style="width: 100%;"></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="text-right w-100 pl-1 pr-1">
          <button id="dlt_fellowship_record" class="btn btn-sm btn-danger float-left ml-2" title="Удалить запись">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>
          </button>
          <button id="meet_cancel" title="Отменить общение" class="btn btn-sm btn-secondary float-left ml-2" style="width: 34px"><b>X</b></button>
          <button id="mdl_btn_meet_ok" class="btn btn-sm btn-success">Сохранить</button>
          <button class="btn btn-sm btn-secondary mr-2" data-dismiss="modal" aria-hidden="true">Отмена</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Фильтры -->
<div id="modal_meet_filters" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="">Фильтры</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">
        <select id="flt_sevice_one_meet_mbl" class="form-control form-control-sm mr-2 mb-2">
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
            echo "<option value='{$key}'>{$value}</option>";
          endforeach; ?>
        </select>
        <select id="ftr_trainee_meet_mbl" class="form-control form-control-sm mr-2 mb-2">
          <option value="_all_">Все обучающиеся</option>
          <?php
          foreach ($trainee_list as $key => $value):
            $selected = "";
            if ($trainee_flt === $key) {
              $selected = "selected";
            }
            echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; ?>
        </select>
        <select id="fellowship_active_mbl" class="form-control form-control-sm mr-2">
          <option value="1" <?php if ($active_flt === '1') echo 'selected'; ?>>Активные</option>
          <option value="0" <?php if ($active_flt === '0') echo 'selected'; ?>>Архивные</option>
        </select>
      </div>
      <div class="modal-footer" style="">
        <button id="apply_filters_meet_mbl" class="btn btn-sm btn-info" data-dismiss="modal" aria-hidden="true" style="">Применить</button>
      </div>
    </div>
  </div>
</div>
<script>
if ($(window).width()<=769) {
  $("#columns_header").hide();
  $(".line_trainee").addClass("pl-1");
  $(".line_duration").addClass("pl-1");
  $(".line_period").addClass("pl-1").addClass("pr-1");
  $("#main_container").css("font-size", '16px');
  $("#main_container select").css("font-size", '16px');
  $("#mdl_meet_date, #mdl_meet_time").parent().addClass("pr-1");
  $("#mdl_meet_time, #mdl_meet_duration").parent().addClass("pl-1");
  $("#mdl_edit_fellowship_staff .container").addClass("pl-1").addClass("pr-1");


}
</script>
