<style>
#list_content {
  padding-left: 0px;
  padding-right: 0px;
}
#ftt_sub_container {
  margin-right: 0px !important;
  padding-right: 0px !important;
}
</style>
<div id="extra_help_staff" class="container">
  <!-- Nav tabs-->
  <br>
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#current_extra_help">Листы посещаемости</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#permission_tab">Разрешения</a>
    </li>
  </ul>
  <!-- Tab panes -->
  <div id="tab_content_extra_help" class="tab-content">
    <div id="current_extra_help" class="container tab-pane active"><br>
      <div id="bar_extra_help" class="btn-group mb-2">
        <?php
        $serving_one_selected = $memberId;
        if (isset($_COOKIE['filter_serving_one']) && $_COOKIE['filter_serving_one']) {
          $serving_one_selected = $_COOKIE['filter_serving_one'];
        }
         ?>
        <select id="sevice_one_select" class="form-control form-control-sm">
          <option value="_all_">Все служащие</option>
          <?php foreach ($serving_ones_list as $key => $value):
            $selected = '';
            if ($key === $serving_one_selected) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' $selected>{$value}</option>";
          endforeach; ?>
        </select>
        <!--<button id="showModalAddEditExtraHelp" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddEdit">Добавить</button>-->
        <!--<select id="author_select" class="form-control form-control-sm" style="width: 200px;">-->
          <!--<option value="_all_">Все обучающиеся</option>-->
          <!--<option value="my" selected>Моя группа</option>-->
          <?php /* foreach (getMyTrainee($memberId) as $key => $value):
            $selected = '';*/
            /*if ($key === $memberId) {
              $selected = 'selected';
            }*/
            /*echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; */?>
        <!--</select>-->
        <?php
        if (isset($_COOKIE['filter_period_att'])) {
          $selected_week = '';
          $selected_month = '';
          $selected_all = '';
          if ($_COOKIE['filter_period_att'] === 'week') {
            $selected_week = 'selected';
          } elseif ($_COOKIE['filter_period_att'] === 'month') {
            $selected_month = 'selected';
          } else {
            $selected_all = 'selected';
          }
        }
        ?>

        <!--<select id="period_select" class="form-control form-control-sm">
          <option value="week" <?php echo $selected_week; ?>>Неделя</option>
          <option value="month" <?php echo $selected_month; ?>>Месяц</option>
          <option value="_all_" <?php echo $selected_all; ?>>Весь семестр</option>
        </select>-->

        <!--<select id="tasks_select" class="form-control form-control-sm ">
          <option value="_all_" selected>Все отчёты</option>
          <option value="1">Отправленые</option>
          <option value="0">Не отправленые</option>
        </select>-->

      </div>
      <!--<div class="row"><span class="col-12 text_grey font-weight-bold text-muted mt-3 mb-3" id="filters_list"></span></div>-->
      <!--<div id="list_header" class="row">
        <div class="col-2 pl-1" style="max-width: 105px !important;"><b>Дата</b></div>
        <div class="col-3"><b>Обучающийся</b></div>
        <div class="col-5" style="min-width: 530px !important;"><b>Комментарий</b></div>
        <div class="col-2" style="max-width: 100px !important;"><b>Отправлено</b></div>
      </div>-->
      <div id="list_content" class="row">
        <div class="" id="accordion_attendance">
          <hr style="margin-left: 12px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
        <?php
          $filter_period_att = 'week';
          $prev_member_key = '';
          $start = true;
          $counter = 0;
          $id_head_start = '';
          /*if (isset($_COOKIE['filter_period_att'])) {
            $filter_period_att = $_COOKIE['filter_period_att'];
          }*/
          if ($ftt_access['group'] === 'trainee') {
            $serving_trainee_disabled = 'disabled';
            $list_access = $memberId;
          } else {
            $list_access = '_all_';
          }
          $current_date_z = date("Y-m-d");

          foreach (getFttAttendanceSheetAndStrings($list_access, $filter_period_att, $serving_one_selected) as $key => $value):
            $counter++;
          /*$short_name_trainee = short_name::no_middle($trainee_list[$value['feh_member_key']]);
          $short_name_service_one = short_name::no_middle($serving_ones_list[$value['serving_one']]);
          */

          /*$data_session = '';
          $data_session_arr = [];
          for ($ii=0; $ii < count($value['strings']); $ii++) {
            foreach ($value['strings'][$ii] as $key_session => $value_session) {
              $data_session = $data_session . " data-{$key_session}='{$value_session}'";
              //echo "{$key_session}=====> {$data_session}";
            }
            $data_session_arr[] = $data_session;
          }
          $data_session = implode(" ",$data_session_arr);
          //foreach ($value['strings'] as $key_session => $value_session) {
             //$data_session = $data_session . " data-{$key_session}='{$value_session}'";
          //}
          {$data_session}
          */
          $id = $value['id'];
          $date = $value['date'];
          $day_of_week = date_convert::week_days($date);
          $short_day_of_week = date_convert::week_days($date, true);
          $sunday_class = '';
          if ($short_day_of_week === 'вс' ) {
            $sunday_class = 'font-weight-bold';
          }
          $short_date = date_convert::yyyymmdd_to_ddmm($value['date']);
          $member_key = $value['member_key'];
          $status = $value['status'];
          $date_send = $value['date_send'];
          $bible = $value['bible'];
          $morning_revival = $value['morning_revival'];
          $personal_prayer = $value['personal_prayer'];
          $common_prayer = $value['common_prayer'];
          $bible_reading = $value['bible_reading'];
          $ministry_reading = $value['ministry_reading'];
          $serving_one = $value['serving_one'];
          $comment = $value['comment'];
          $name_trainee = short_name::no_middle($value['name']);
          $bible_reading_text = '';
          if ($bible == 1) {
            $bible_reading_text = 'Да';
          } else {
            $bible_reading_text = 'Нет';
          }
          $semester_number = $trainee_list_full[$value['member_key']][4];
          if ($trainee_list_full[$value['member_key']][4] < 5) {
            $total = "Чтение библии — {$bible_reading_text}";
          } else {
            $total = "ОЖ — {$morning_revival}, ЛМ — {$personal_prayer}, СМ — {$common_prayer}, ЧБ — {$bible_reading}, ЧС — {$ministry_reading}.";
          }

          $comment_short;
          if (strlen($comment) > 30) {
            $comment_short = iconv_substr($comment, 0, 70, 'UTF-8');
            if (strlen($comment) >= 70) {
              $comment_short .= '...';
            }
          } else {
            $comment_short = $comment;
          }
          // archived string checked
          //$show_string = "style='display: none;'";
          $checked_string = 'display: none;';
          $done_string = '';

          if ($archive = $value['status'] === '1') {
            $checked_string = '';
            $done_string = 'green_string';
          } else {
            $archive = '0';
            $done_string = '';
          }
          /*if ($value['status'] === '0') {
            $show_string = '';
          }*/
          $id_head = 'id_head_'.$key;
          $id_collapse = 'id_collapse_'.$key;
          $open_day = '';
          $btn_bold = 'accordion-head';

          if ($value['member_key'] !== $prev_member_key && !$start) {
            $pause_from = '';
            $pause_start = '';
            $pause_to = '';
            $pause_stop = '';
            if ((date($current_date_z) >= date($date_start_str) && !$date_stop_str) || (date($current_date_z) >= date($date_start_str) && date($current_date_z) <= date($date_stop_str))) {
              $pause_from = 'Перерыв с ';
              $pause_start = date_convert::yyyymmdd_to_ddmm($date_start_str);
              $pause_stop = date_convert::yyyymmdd_to_ddmm($date_stop_str);
              $pause_to = 'по';
              if ($pause_start === 'No date') {
                $pause_from = '';
                $pause_start = '';
                $pause_to = '';
                $pause_stop = '';
              }
              if ($pause_stop === 'No date') {
                $pause_to = '';
                $pause_stop = '';
              }
            }

            if ($comment_ico_str) {
              $comment_ico_str = "<i class='fa fa-sticky-note' aria-hidden='true' title='{$comment_ico_str}'></i>";
            } else {
              $comment_ico_str = '';
            }

            echo "<span class='period_col'>{$pause_from} {$pause_start} {$pause_to} {$pause_stop}</span>{$comment_ico_str}</div></div>";
            $start = true;
          }
          if ($value['member_key'] !== $prev_member_key && $start) {
            $date_start_str = $value['pause_start'];
            $date_stop_str = $value['pause_stop'];
            $comment_ico_str = $value['pause_comment'];
            $id_head_start = $id_head;
            $start = false;
            echo "<div data-member_key='{$member_key}' style='margin-top: 2px;'>
                    <div class='card_header cursor-pointer'>
				                <button class='btn btn-link'>{$name_trainee} ({$semester_number})</button> <span class='list_string link_day {$sunday_class} {$done_string}' data-id='{$id}' data-date='{$date}' data-member_key='{$member_key}' data-status='{$status}' data-date_send='{$date_send}' data-bible='{$bible}' data-morning_revival='{$morning_revival}' data-personal_prayer='{$personal_prayer}' data-common_prayer='{$common_prayer}' data-bible_reading='{$bible_reading}' data-ministry_reading='{$ministry_reading}' data-serving_one='{$serving_one}' data-comment='{$comment}' data-toggle='modal' data-target='#modalAddEdit'> {$short_date} {$short_day_of_week} </span>";
          } else {
            /*if ($counter_periods === 8) {
              echo "</div><div id='collapse_{$id_head_start}' class='collapse' data-parent='#accordion_attendance'>
              <div class='row card-body' data-toggle='modal' data-target='#modalAddEdit' {$show_string}>
              <span class='list_string link_day {$sunday_class}' data-id='{$id}' data-date='{$date}' data-member_key='{$member_key}' data-status='{$status}' data-date_send='{$date_send}' data-bible='{$bible}' data-morning_revival='{$morning_revival}' data-personal_prayer='{$personal_prayer}' data-common_prayer='{$common_prayer}' data-bible_reading='{$bible_reading}' data-ministry_reading='{$ministry_reading}' data-serving_one='{$serving_one}' data-comment='{$comment}' data-toggle='modal' data-target='#modalAddEdit'> {$short_date} {$short_day_of_week} </span>";
            } else {*/
              echo "<span class='list_string link_day {$sunday_class} {$done_string}' data-id='{$id}' data-date='{$date}' data-member_key='{$member_key}' data-status='{$status}' data-date_send='{$date_send}' data-bible='{$bible}' data-morning_revival='{$morning_revival}' data-personal_prayer='{$personal_prayer}' data-common_prayer='{$common_prayer}' data-bible_reading='{$bible_reading}' data-ministry_reading='{$ministry_reading}' data-serving_one='{$serving_one}' data-comment='{$comment}' data-toggle='modal' data-target='#modalAddEdit'> {$short_date} {$short_day_of_week}</span>";
            /*}*/
          }
          $prev_member_key = $value['member_key'];
        endforeach;
        if ($counter > 0) {
            echo "</div></div>";
        }
        ?>
        </div>
      </div>
    </div>
    <div id="permission_tab" class="tab-pane">
      <div class="container">
        <div class="row">
          <div class="col-12 mt-2">
            <span>В разработке.</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
