<br>
<div id="permission_list_header" class="btn-group mb-2">
  <button type="button" id="permission_add" class="btn btn-success btn-sm rounded mr-2" data-toggle="modal" data-target="#edit_permission_blank">Добавить</button>
  <select id="permission_active" class="form-control form-control-sm mr-2">
    <option value="_all_">Все</option>
    <option value="0">На рассмотрении</option>
  </select>
  <select id="sevice_one_select" class="form-control form-control-sm mr-2">
    <option value="_all_">Все служащие</option>
    <?php foreach ($serving_ones_list as $key => $value):
      $selected = '';
      if ($key === $serving_one_selected) {
        $selected = 'selected';
      }
      echo "<option value='{$key}' $selected>{$value}</option>";
    endforeach; ?>
  </select>
  <select id="author_select_desk" class="form-control form-control-sm mr-2">
    <option value="_all_">Все обучающиеся</option>
    <?php foreach ($trainee_list as $key => $value):
      $selected = '';
      if ($key === $memberId) {
        $selected = 'selected';
      }
      echo "<option value='{$key}' {$selected}>{$value}</option>";
    endforeach; ?>
  </select>
</div>
<div class="row row_corr">
  <div class="col-2 pl-1"><b>Дата</b></div>
  <div class="col-8"><b>Комментарий</b></div>
  <div class="col-2"><b>Статус</b></div>
</div>
<hr id="hight_line" style="margin-left: 0px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
<div id="list_permission" class="">
  <?php
  foreach (FttPermissions::get_by_staff(ftt_lists::get_trainees_by_staff($memberId)) as $key => $value):

    $id = $value['id'];
    $date = $value['absence_date'];
    $permission_status = $value['status'];
    $permission_comment = $value['comment'];
    $short_date = date_convert::yyyymmdd_to_ddmm($date);

    $checked_string = "<span class='badge badge-secondary'>Не отправлен</span>";
    $done_string = '';
    if ($archive = $value['status'] === '1') {
      $checked_string = "<span class='badge badge-success'>Отправлен</span>";
      $done_string = 'green_string';
    }

    $permission_comment_short;
    if (strlen($permission_comment) > 30) {
      $permission_comment_short = iconv_substr($permission_comment, 0, 70, 'UTF-8');
      if (strlen($permission_comment) >= 70) {
        $permission_comment_short .= '...';
      }
    } else {
      $permission_comment_short = $permission_comment;
    }

    echo "<div class='row list_string' data-id='{$permission_id}' data-date='{$permission_date}' data-member_key='{$permission_member_key}' data-status='{$permission_status}' data-date_send='{$permission_date_send}' data-absence_date='{$absence_date}' data-comment='{$permission_comment}' data-toggle='modal' data-target='#' $show_string>
    <div class='col-2 pl-1'>{$short_date}</div>
    <div class='col-8'>{$permission_comment_short}</div>
    <div class='col-2'>{$checked_string}</div>
    </div>";
  endforeach; ?>
</div>