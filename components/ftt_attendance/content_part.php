<div id="extra_help_staff" class="container">
  <!-- Nav tabs -->
  <br>
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_attendance_active; ?>" data-toggle="tab" href="#current_extra_help">Листы посещаемости</a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_permission_active; ?>" data-toggle="tab" href="#permission_tab">
        Листы отсутствия <?php echo $permission_statistics; ?>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_missed_class_active; ?>" data-toggle="tab" href="#missed_class_tab">
        Пропущенные занятия <?php echo $missed_class_statistics; ?>
      </a>
    </li>
  </ul>
  <!-- Tab panes -->
  <div id="tab_content_extra_help" class="tab-content">
    <!-- ATTENDANCE TAB -->
    <div id="current_extra_help" class="container tab-pane <?php echo $tab_attendance_active; ?>"><br>
      <div id="bar_extra_help" class="btn-group mb-2">
        <!--<button id="showModalAddEditExtraHelp" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddEdit">Добавить</button>-->
        <?php
        $selected_week = '';
        $selected_month = '';
        $selected_all = '';
        if (isset($_COOKIE['filter_period_att'])) {
          if ($_COOKIE['filter_period_att'] === 'week') {
            $selected_week = 'selected';
          } elseif ($_COOKIE['filter_period_att'] === 'month') {
            $selected_month = 'selected';
          } else {
            $selected_all = 'selected';
          }
        }
        ?>
        <select id="period_select" class="form-control form-control-sm">
          <option value="week" <?php echo $selected_week; ?>>Неделя</option>
          <option value="month" <?php echo $selected_month; ?>>Месяц</option>
          <option value="_all_" <?php echo $selected_all; ?>>Весь семестр</option>
        </select>
        <!--<select id="tasks_select" class="form-control form-control-sm ">
          <option value="_all_" selected>Все отчёты</option>
          <option value="1">Отправленые</option>
          <option value="0">Не отправленые</option>
        </select>-->
      </div>
      <!--<div class="row"><span class="col-12 text_grey font-weight-bold text-muted mt-3 mb-3" id="filters_list"></span></div>-->
      <div id="list_header" class="row">
        <?php if ($trainee_data['semester'] < 5): ?>
          <div class="col-2 pl-1"><b>Дата</b></div>
          <div class="col-3"><b>Чтение библии</b></div>
          <div class="col-5"><b>Комментарий</b></div>
          <div class="col-2"><b>Статус</b></div>
        <?php else: ?>
          <div class="col-2 pl-1"><b>Дата</b></div>
          <div class="col-1"><b>УО</b></div>
          <div class="col-1"><b>ЛМ</b></div>
          <div class="col-1"><b>МТ</b></div>
          <div class="col-1"><b>ЧБ</b></div>
          <div class="col-1"><b>ЧС</b></div>
          <div class="col-3"><b>Комментарий</b></div>
          <div class="col-2"><b>Статус</b></div>
        <?php endif; ?>

      </div>
      <hr id="hight_line" style="margin-left: 0px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
      <div id="list_content" class="mb-2">

        <?php
          $filter_period_att = 'week';
          if (isset($_COOKIE['filter_period_att'])) {
            $filter_period_att = $_COOKIE['filter_period_att'];
          }
          if ($ftt_access['group'] === 'trainee') {
            $serving_trainee_disabled = 'disabled';
            $list_access = $memberId;
          } else {
            $list_access = '_all_';
          }
          $current_date_z = date("Y-m-d");
          $only_one_time = false;
          foreach (getFttAttendanceSheetAndStrings($list_access, $filter_period_att) as $key => $value):
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
          $day_of_week_short = date_convert::week_days($date, true);
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
          $comment = $value['comment'];
          $name_trainee = short_name::no_middle($value['name']);
          $bible_reading_text = $bible_reading.' мин.';

          if ($bible_reading === '0') {
            $bible_reading_text = '';
          }
          $book = $value['bible_book'];
          $chapter = $value['bible_chapter'];
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
            $checked_string = "<span class='badge badge-success'>Отправлен</span>";
            //$done_string = 'green_string'; {$done_string}
          } else {
            $archive = '0';
            $checked_string = "<span class='badge badge-secondary'>Не отправлен</span>";
          }

          // ПЕРЕРЫВ
          if (!$only_one_time) {
            $date_start_str = $value['pause_start'];
            $date_stop_str = $value['pause_stop'];
            $pause_from = '';
            $pause_start = '';
            $pause_to = '';
            $pause_stop = '';
            if ((strtotime(date($current_date_z)) >= strtotime(date($date_start_str)) && !$date_stop_str) || (strtotime(date($current_date_z)) >= strtotime(date($date_start_str)) && strtotime(date($current_date_z)) <= strtotime(date($date_stop_str)))) {
              $pause_from = 'Перерыв в учёте посещаемости с ';
              $pause_start = date_convert::yyyymmdd_to_ddmm($date_start_str);
              $pause_stop = date_convert::yyyymmdd_to_ddmm($date_stop_str).'.';
              $pause_to = ' по ';
              if ($pause_start === 'No date') {
                $pause_from = '';
                $pause_start = '';
                $pause_to = '';
                $pause_stop = '';
              }
              if ($pause_stop === 'No date.') {
                $pause_to = '';
                $pause_stop = '';
                $pause_start .='.';
              }
            }
            $only_one_time = true;
          }
          /*if ($value['status'] === '0') {
            $show_string = '';
          }*/
          if ($trainee_data['semester'] < 5) {
            echo "<div class='row list_string' data-id='{$id}' data-date='{$date}' data-member_key='{$member_key}' data-status='{$status}' data-date_send='{$date_send}' data-bible='{$bible}' data-morning_revival='{$morning_revival}' data-personal_prayer='{$personal_prayer}' data-common_prayer='{$common_prayer}' data-bible_reading='{$bible_reading}' data-ministry_reading='{$ministry_reading}' data-bible_book='{$book}' data-bible_chapter='{$chapter}' data-comment='{$comment}' data-toggle='modal' data-target='#modalAddEdit'>
            <div class='col-2 col_n_1 pl-1'><span class='date_str' data-short='{$day_of_week_short}'>{$short_date}</span><span class='pl-2'> {$day_of_week}</span></div>
            <div class='col-3'><span class='trainee_name'>{$bible_reading_text}</span></div>
            <div class='col-5 col_n_3'>{$comment_short}</div>
            <div class='col-2 set_to_archive_container col_n_4'>{$checked_string}</div>
            <div class='comment_mbl pl-1'>$comment_short</div>
            </div>";
          } else {
            echo "<div class='row list_string' data-id='{$id}' data-date='{$date}' data-member_key='{$member_key}' data-status='{$status}' data-date_send='{$date_send}' data-bible='{$bible}' data-morning_revival='{$morning_revival}' data-personal_prayer='{$personal_prayer}' data-common_prayer='{$common_prayer}' data-bible_reading='{$bible_reading}' data-ministry_reading='{$ministry_reading}' data-bible_book='{$book}' data-bible_chapter='{$chapter}' data-comment='{$comment}' data-toggle='modal' data-target='#modalAddEdit'>
            <div class='col-2 col_n_1 pl-1'><span class='date_str' data-short='{$day_of_week_short}'>{$short_date}</span> <span> {$day_of_week}</span></div>
            <div class='col-1'><span class='trainee_name'>{$morning_revival}</span></div>
            <div class='col-1'><span class='trainee_name'>{$personal_prayer}</span></div>
            <div class='col-1'><span class='trainee_name'>{$common_prayer}</span></div>
            <div class='col-1'><span class='trainee_name'>{$bible_reading}</span></div>
            <div class='col-1'><span class='trainee_name'>{$ministry_reading}</span></div>
            <div class='col-3 col_n_3'>{$comment_short}</div>
            <div class='col-2 set_to_archive_container col_n_4'>{$checked_string}</div>
            <div class='comment_mbl pl-1'>$comment_short</div>
            </div>";
          }
        endforeach; ?>
      </div>
      <?php echo "<strong class='period_col'>{$pause_from} {$pause_start}{$pause_to}{$pause_stop}</strong>"; ?>
    </div>
    <!-- PERMISSION TAB -->
    <div id="permission_tab" class="tab-pane container <?php echo $tab_permission_active; ?>">
      <?php include 'components/ftt_attendance/content_part_permission.php'; ?>
    </div>
    <div id="missed_class_tab" class="tab-pane container <?php echo $tab_missed_class_active; ?>">
      <?php include 'components/ftt_attendance/content_classes_trainee.php'; ?>
    </div>
  </div>
</div>
