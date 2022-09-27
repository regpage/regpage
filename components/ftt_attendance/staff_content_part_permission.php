<br>
<div id="permission_list_header" class="btn-group mb-2">
  <button type="button" id="permission_add" class="btn btn-success btn-sm rounded mr-2" data-toggle="modal" data-target="#edit_permission_blank">Добавить</button>
  <button type="button" id="permission_flt_modal_o" class="btn btn-primary btn-sm rounded mr-2" data-toggle="modal" data-target="#permission_ftr_modal" style="display: none;">Фильтры</button>
  <select id="flt_permission_active" class="form-control form-control-sm mr-2">
    <option value="_all_" <?php if ($flt_permission_active === '_all_') echo 'selected'; ?>>Все</option>
    <option value="1" <?php if ($flt_permission_active === '1') echo 'selected'; ?>>На рассмотрении</option>
  </select>
  <select id="flt_sevice_one_permissions" class="form-control form-control-sm mr-2">
    <option value="_all_">Все служащие</option>
    <?php foreach ($serving_ones_list as $key => $value):
      $selected = '';
      if ($key === $serving_one_permissions) {
        $selected = 'selected';
      }
      echo "<option value='{$key}' $selected>{$value}</option>";
    endforeach; ?>
  </select>
  <select id="ftr_trainee_permissions" class="form-control form-control-sm mr-2">
    <option value="_all_">Все обучающиеся</option>
    <?php foreach ($trainee_list as $key => $value):
      $selected = '';
      if ($key === $trainee_permissions) {
        $selected = 'selected';
      }
      echo "<option value='{$key}' {$selected}>{$value}</option>";
    endforeach; ?>
  </select>
</div>
<div class="row row_corr">
  <div class="col-2 pl-1"><b>Дата</b></div>
  <div class="col-4"><b>Обучающийся</b></div>
  <div class="col-4"><b>Причина</b></div>
  <div class="col-2"><b>Статус</b></div>
</div>
<hr id="hight_line" style="margin-left: 0px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
<div id="list_permission" class="">
  <?php
  foreach (FttPermissions::get_by_staff(ftt_lists::get_trainees_by_staff($serving_one_permissions)) as $key => $value):

    $permission_id = $value['id'];
    $permission_date = $value['date'];
    $permission_status = $value['status'];
    $permission_comment = $value['comment'];
    $permission_name = short_name::no_middle($trainee_list[$value['member_key']]);
    $permission_member_key = $value['member_key'];
    $permission_absence_date = $value['absence_date'];
    $short_date = date_convert::yyyymmdd_to_ddmm($permission_absence_date);
    $permission_date_send = $value['date_send'];
    $permission_serving_one = $value['serving_one'];

    $checked_string = "<span class='badge badge-".$status_list[$permission_status][0]."'>".$status_list[$permission_status][1]."</span>";
    $show_string = '';
    if ($permission_status === '0' || $permission_status === '2' || $permission_status === '3') {
      if ($flt_permission_active === '1') {
        $show_string = 'style="display:none;"';
      }
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

    echo "<div class='row list_string' data-id='{$permission_id}' data-date='{$permission_date}' data-member_key='{$permission_member_key}' data-status='{$permission_status}' data-serving_one='{$permission_serving_one}' data-date_send='{$permission_date_send}' data-absence_date='{$permission_absence_date}' data-comment='{$permission_comment}' data-toggle='modal' data-target='#edit_permission_blank' $show_string>
    <div class='col-2 pl-1'>{$short_date}</div>
    <div class='col-4'>{$permission_name}</div>
    <div class='col-4'>{$permission_comment_short}</div>
    <div class='col-2'>{$checked_string}</div>
    </div>";
  endforeach; ?>
</div>
