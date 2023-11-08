<div id="bar_late" class="btn-group">
  <button id="showModalAddEditLate" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddEditLate">Добавить</button>
  <button id="filters_button_late" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalFilrets_late" style="display: none;">Фильтры</button>
  <select id="trainee_select_late" class="form-control form-control-sm">
    <option value="_all_" selected>Все обучающиеся</option>
    <?php foreach ($trainee_list as $key => $value):
      echo "<option value='{$key}'>{$value}</option>";
    endforeach; ?>
  </select>
  <select id="semesters_select_late" class="form-control form-control-sm ">
    <option value="_all_" selected>Все семестры</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
  </select>
  <select id="sevice_one_select_late" class="form-control form-control-sm ">
    <option value="_all_" <?php echo $serving_trainee_selected; ?>>Все служащие</option>
    <?php foreach ($serving_ones_list as $key => $value):
      $selected = '';
      if ($key === $memberId && !$serving_trainee) {
        $selected = 'selected';
      }
      echo "<option value='{$key}' $selected>{$value}</option>";
    endforeach; ?>
  </select>
  <select id="tasks_select_late" class="form-control form-control-sm ">
    <option value="_all_">Все опоздания</option>
    <option value="0" selected>Неучтённые</option>
  </select>
</div>
<div class="row"><span class="col-12 text_grey font-weight-bold text-muted mt-3 mb-3" id="filters_list_late"></span></div>
<div id="list_header_late" class="row">
  <div class="col-2 pl-1" style="max-width: 105px !important;"><b class="text_grey">Дата</b></div>
  <div class="col-3"><b class="text_grey">Обучающийся</b></div>
  <div class="col-4" style="min-width: 500px !important;"><b class="text_grey">Мероприятие</b></div>
  <div class="col-1" style="min-width: 30px !important;"><b class="text_grey">Мин</b></div>
  <div class="col-2" style="max-width: 100px !important;"><b class="text_grey">Учтено</b></div>
</div>
<div id="list_content_late">
  <?php
    foreach (getLateStrings() as $key => $value):
    $short_name_trainee = short_name::no_middle($trainee_list[$value['member_key']]);
    $short_name_service_one = short_name::no_middle($serving_ones_list[$value['serving_one']]);
    $extra_help_id = $value['id'];
    $sevice_one_id_archived = '';// DELETE IT $sevice_one_id_archived = $value['fl_serving_one'];
    $sevice_one_id = $value['serving_one'];
    $trainee_id = $value['member_key'];
    $done = $value['done'];
    $date = $value['date'];
    $date_for_list = date_convert::yyyymmdd_to_ddmm($date);
    $delay = $value['delay'];
    $semester = $value['semester'];
    $session_name = $value['session_name'];
    $session_name_short;
    if (strlen($session_name) > 70) {
      $session_name_short = iconv_substr($session_name, 0, 70, 'UTF-8');
      $session_name_short .= '...';
    } else {
      $session_name_short = $session_name;
    }
    $comment = '';//$comment = $value['comment'];
    $author = $value['author'];
    $show_string = "style='display: none;'";
    $checked_string = '';
    $done_string = '';
    if ($done = $value['done'] === '1') {
      $checked_string = 'checked';
      $done_string = 'green_string';
    } else {
      $done = '0';
    }
    if ($value['serving_one'] === $memberId && $value['done'] === '0' && !$serving_trainee) {
      $show_string = '';
    } elseif ($value['done'] === '0' && $serving_trainee) {
      $show_string = '';
    }
    $show_name_service_one = "display: none;";
    if ($serving_trainee) {
      $show_name_service_one = '';
    }
    if ((isset($ftt_access['ftt_service']) && $ftt_access['ftt_service'] === '06') || $ftt_access['group'] === 'staff' || $memberId === $author || $memberId === $trainee_id) {
    echo "<div class='row ftt_late_string {$done_string}' {$show_string} data-service_one_id='{$sevice_one_id}' data-trainee_id='{$trainee_id}' data-archive='{$done}' data-reason='{$session_name}' data-comment='{$comment}' data-author='{$author}' data-delay='{$delay}' data-id='{$extra_help_id}' data-date='{$date}' data-semester='{$semester}' data-toggle='modal' data-target='#modalAddEditLate'>
      <div class='col-2 date_create_text pl-1'>{$date_for_list}</div>
      <div class='col-3'><span class='trainee_name'>{$short_name_trainee}</span><span class='semester_text'> ({$semester})</span><br><span class='serving_one_name light_text_grey' style='{$show_name_service_one}'>{$short_name_service_one}</span></div>
      <div class='col-4 reason_text'>{$session_name_short}</div>
      <div class='col-1 text_min'>{$delay}</div>
      <div class='col-2 set_to_archive_container'><input type='checkbox' class='set_to_done' {$checked_string} {$serving_trainee_disabled}></div>
    </div>";
    }
  endforeach; ?>
</div>
