<div id="extra_help_staff" class="container">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#current_extra_help">Задания</a>
    </li>
  </ul>
  <!-- Tab panes -->
  <div id="tab_content_extra_help" class="tab-content">
    <div id="current_extra_help" class="container tab-pane active"><br>
      <div id="bar_extra_help" class="btn-group">
        <button id="showModalAddEditExtraHelp" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddEditExtraHelp">Добавить</button>
        <button id="filters_button" type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalFilrets" style="display: none;">Фильтры</button>
        <select id="tasks_select" class="form-control form-control-sm ">
          <option value="_all_">Все задания</option>
          <option value="0" selected>Текущие</option>
        </select>
      </div>
      <div class="row"><span class="col-12 text_grey font-weight-bold text-muted mt-3 mb-3" id="filters_list"></span></div>
      <div id="list_header" class="row">
        <div class="col-2 pl-1" style="max-width: 105px !important;"><b class="text_grey">Дата</b></div>
        <div class="col-8" style="min-width: 530px !important;"><b class="text_grey">Описание</b></div>
        <div class="col-2" style="max-width: 100px !important;"><b class="text_grey">Выполнено</b></div>
      </div>
      <div id="list_content">
        <?php
          if ($ftt_access['group'] === 'trainee') {
            $serving_trainee_disabled = 'disabled';
          }
          foreach (getExtraHelpTrainee($memberId) as $key => $value):
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
          if (strlen($reason) > 30) {
            $reason_short = iconv_substr($reason, 0, 84, 'UTF-8');
            if (strlen($reason) >= 84) {
              //$reason_short .= '...';  
            }
          } else {
            $reason_short = $reason;
          }
          $comment = $value['comment'];
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
          if ($value['archive'] === '0') {
            $show_string = '';
          }
          echo "<div class='row ftt_extra_help_string {$done_string}' {$show_string} data-service_one_id='{$sevice_one_id}' data-service_one_archived_id='$sevice_one_id_archived' data-trainee_id='{$trainee_id}' data-archive='{$archive}' data-reason='{$reason}' data-comment='{$comment}' data-author='{$author}' data-archived='{$date_closed}' data-id='{$extra_help_id}' data-date='{$date}' data-semester='{$semester}' data-toggle='modal' data-target='#modalAddEditExtraHelp'>
            <div class='col-2 date_create_text pl-1'>{$date_for_list}</div>
            <div class='col-3' style='display: none;'><span class='reson_mbl' style='display: none;'>{$reason_short}</span></div>
            <div class='col-8 reason_text'>{$reason_short}</div>
            <div class='col-2 set_to_archive_container'><input type='checkbox' class='set_to_archive' {$checked_string} {$serving_trainee_disabled}></div>
          </div>";
        endforeach; ?>
      </div>
    </div>
    <div id="extra_help_statistic" class="container tab-pane fade"><br>
      <h3>Статистика</h3>
      <p>В разработке...</p>
    </div>
  </div>
</div>
