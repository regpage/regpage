<div id="extra_help_staff" class="container">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#current_extra_help">Задания</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#current_late">Опоздания</a>
    </li>
    <?php if (!$serving_trainee): ?>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#extra_help_statistic">Статистика</a>
      </li>
    <?php endif; ?>
  </ul>
  <!-- Tab panes -->
  <div id="tab_content_extra_help" class="tab-content">
    <div id="current_extra_help" class="container tab-pane active"><br>
      <div id="bar_extra_help" class="btn-group">
        <button id="showModalAddEditExtraHelp" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddEditExtraHelp">Добавить</button>
        <button id="showModalShortStatistics" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalShortStatistics">Печать</button>
        <button id="filters_button" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalFilrets" style="display: none;">Фильтры</button>
        <button id="sort_button" type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalSort" style="display: none;">Порядок</button>
        <?php // if ($trainee_data['coordinator'] !== '1'): ?>
        <select id="trainee_select" class="form-control form-control-sm" style="width: 158px;">
          <option value="_all_">Все обучающиеся</option>
          <?php foreach ($trainee_list as $key => $value):
            $selected = '';
            if (isset($_COOKIE['trainee_select']) && $_COOKIE['trainee_select'] === $key) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; ?>
        </select>
        <select id="semesters_select" class="form-control form-control-sm">
          <option value="_all_">Все семестры</option>
          <?php
          $points = [1,2,3,4,5,6];
          foreach ($points as $key => $value):
            $selected = '';
            if (isset($_COOKIE['semesters_select']) && $_COOKIE['semesters_select'] == $value) {
              $selected = 'selected';
            }
            echo "<option value='{$value}' {$selected}>{$value}</option>";
          endforeach; ?>
        </select>
        <select id="sevice_one_select" class="form-control form-control-sm">
          <option value="_all_" <?php echo $serving_trainee_selected; ?>>Все служащие</option>
          <?php foreach ($serving_ones_list as $key => $value):
            $selected = '';
            if (!isset($_COOKIE['sevice_one_select']) && $key === $memberId && !$serving_trainee
            || (isset($_COOKIE['sevice_one_select']) && $_COOKIE['sevice_one_select'] === $key && !$serving_trainee)) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' $selected>{$value}</option>";
          endforeach; ?>
        </select>
        <?php // endif; ?>
        <select id="tasks_select" class="form-control form-control-sm ">
          <?php
          $selected = '';
          $selected2 = '';
          if (isset($_COOKIE['tasks_select']) && $_COOKIE['tasks_select'] === '_all_') {
            $selected = 'selected';
            $selected2 = '';
          } else {
            $selected2 = 'selected';
          }
          ?>
          <option value="_all_" <?php echo $selected; ?>>Все задания</option>
          <option value="0" <?php echo $selected2; ?>>Текущие</option>
        </select>
      </div>
      <?php
      $sort_date_ico = 'hide_element';
      $sort_trainee_ico = 'hide_element';
      if (isset($_COOKIE['sorting'])) {
        if ($_COOKIE['sorting'] === 'sort_date-desc') {
          $sort_date_ico = 'fa fa-sort-asc';
          //$sort_cookie = $_COOKIE['sorting'];
        } elseif ($_COOKIE['sorting'] === 'sort_date-asc') {
          $sort_date_ico = 'fa fa-sort-desc';
          //$sort_cookie = 'sort_date-desc';
        } elseif ($_COOKIE['sorting'] === 'sort_trainee-desc') {
          $sort_trainee_ico = 'fa fa-sort-asc';
          //$sort_cookie = 'sort_date-desc';
        } elseif ($_COOKIE['sorting'] === 'sort_trainee-asc') {
          $sort_trainee_ico = 'fa fa-sort-desc';
          //$sort_cookie = 'sort_date-desc';
        } else {
          $sort_date_ico = 'fa fa-sort-asc';
        }
      } else {
        $sort_date_ico = 'fa fa-sort-asc';
      }
       ?>
      <div class="row"><span class="col-12 text_grey font-weight-bold text-muted mt-3 mb-3" id="filters_list"></span></div>
      <div id="list_header" class="row">
        <div class="col-2 pl-1 cursor-pointer text_blue" style="max-width: 105px !important;"><b class="sort_date">Дата<i class="<?php echo $sort_date_ico; ?>"></i></b></div>
        <div class="col-3 text_blue cursor-pointer" style="min-width: 150px !important;"><b class="sort_trainee">Обучающийся<i class="<?php echo $sort_trainee_ico; ?>"></i></b></div>
        <div class="col-5" style="min-width: 530px !important;"><b class="text_grey">Описание</b></div>
        <div class="col-2" style="max-width: 100px !important;"><b class="text_grey">Выполнено</b></div>
      </div>
      <div id="list_content">
        <?php
          foreach (getExtraHelp($memberId, $serving_trainee, $_COOKIE['sorting']) as $key => $value):
          $short_name_trainee = short_name::no_middle($trainee_list[$value['feh_member_key']]);
          $short_name_service_one = short_name::no_middle($serving_ones_list[$value['serving_one']]);
          $extra_help_id = $value['feh_id'];
          $sevice_one_id_archived = $value['feh_serving_one'];
          $sevice_one_id = $value['serving_one'];
          $trainee_id = $value['feh_member_key'];
          $archive = $value['archive'];
          $date = $value['date'];
          $date_for_list = date_convert::yyyymmdd_to_ddmm($date);
          $date_closed = $value['archive_date'];
          $semester = $value['semester'];
          $reason = $value['reason'];
          $reason_short;
          if (strlen($reason) > 70) {
            $reason_short = iconv_substr($reason, 0, 70, 'UTF-8'); //substr
            if (strlen($reason) >= 70) {
              //$reason_short .= '...';
            }
          } else {
            $reason_short = $reason;
          }
          $comment = $value['comment'];
          if ($comment) {
            $str_comment_hide = "";
          } else {
            $str_comment_hide = 'hide_element';
          }
          $author = $value['author'];
          $show_string = "style='display: none;'";
          $checked_string = '';
          $done_string = '';
          if ($archive = $value['archive'] === '1') {
            $checked_string = 'checked';
            $done_string = 'green_string';
          } else {
            $archive = '0';
          }
          if ($value['serving_one'] === $memberId && $value['archive'] === '0' && !$serving_trainee) {
            $show_string = '';
          } elseif ($value['archive'] === '0' && $serving_trainee) {
            $show_string = '';
          }
          $show_name_service_one = "display: none;";
          if ($serving_trainee) {
            $show_name_service_one = '';
          }
          $show_reason_short  = "display: none;";

          if ($trainee_data['coordinator'] === '1' && $trainee_id === $memberId && $archive === "0") {
            $show_string = '';
          } elseif ($trainee_data['coordinator'] === '1' && $trainee_id === $memberId) {
            $show_string = "style='display: none;'";
          }
          if ($trainee_data['coordinator'] !== '1' || ($trainee_data['coordinator'] === '1' && $trainee_id === $memberId)) {
          echo "<div class='row ftt_extra_help_string {$done_string}' {$show_string} data-service_one_id='{$sevice_one_id}' data-service_one_archived_id='$sevice_one_id_archived' data-trainee_id='{$trainee_id}' data-archive='{$archive}' data-reason='{$reason}' data-comment='{$comment}' data-author='{$author}' data-archived='{$date_closed}' data-id='{$extra_help_id}' data-date='{$date}' data-semester='{$semester}' data-toggle='modal' data-target='#modalAddEditExtraHelp'>
            <div class='col-2 date_create_text pl-1'>{$date_for_list}</div>
            <div class='col-3'><span class='trainee_name'>{$short_name_trainee}</span><span class='semester_text'> ({$semester})</span><br><span class='serving_one_name light_text_grey' style='{$show_name_service_one}'>{$short_name_service_one}</span><span class='reson_mbl light_text_grey' style='{$show_reason_short}'>{$reason_short}</span></div>
            <div class='col-5 reason_text'>{$reason_short}</div>
            <div class='col-2 set_to_archive_container'><input type='checkbox' class='set_to_archive align-middle' {$checked_string} {$serving_trainee_disabled}><span class='{$str_comment_hide} ml-3 align-middle' title='{$comment}'><i class='fa fa-sticky-note' aria-hidden='true'></i></span></div>
          </div>";
          }
        endforeach; ?>
      </div>
    </div>
    <div id="current_late" class="container tab-pane fade"><br>
      <?php include_once 'components/ftt_extra_help/staff_content_part_late.php'; ?>
    </div>
    <div id="extra_help_statistic" class="container tab-pane fade"><br>
      <h3>Статистика</h3>
      <p>В разработке...</p>
    </div>
  </div>
</div>
