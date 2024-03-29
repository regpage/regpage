<br>
<div id="permission_list_header" class="btn-group mb-2">
  <button type="button" id="permission_add" class="btn btn-success btn-sm rounded mr-2" data-toggle="modal" data-target="#edit_permission_blank">Добавить</button>
  <select id="flt_permission_active" class="form-control form-control-sm">
    <option value="_all_" <?php if ($flt_permission_active === '_all_') echo 'selected'; ?>>Все</option>
    <option value="1" <?php if ($flt_permission_active === '1') echo 'selected'; ?>>Текущие</option>
  </select>
</div>
<div class="row row_corr">
  <div class="col-2 pl-1"><b>Дата</b></div>
  <div class="col-8"><b>Причина</b></div>
  <div class="col-2"><b>Статус</b></div>
</div>
<hr id="hight_line" style="margin-left: 0px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
<div id="list_permission" class="">
  <?php
  foreach (FttPermissions::get_by_trainee($memberId) as $key => $value):

    $permission_id = $value['id'];
    $permission_member_key = $value['member_key'];
    $permission_absence_date = $value['absence_date'];
    $permission_date = $value['date'];
    $permission_date_send = $value['date_send'];
    $permission_status = $value['status'];
    $permission_serving_one = $value['serving_one'];
    $permission_date_decision = $value['decision_date'];
    $permission_notice = $value['notice'];
    $permission_comment = $value['comment'];
    $short_absence_date = date_convert::yyyymmdd_to_ddmm($permission_absence_date);

    $checked_string = "<span class='badge badge-".$status_list[$permission_status][0]."'>".$status_list[$permission_status][1]."</span>";
    $show_string = '';
    if (($permission_status === '0' || $permission_status === '2' || $permission_status === '3') && !$permission_notice) {
      if ($flt_permission_active === '1') {
        $show_string = 'style="display:none;"';
      }
    }

    $notice_color = '';
    if ($permission_notice) {
      $notice_color = 'bg-notice-string';
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

    echo "<div class='row list_string {$notice_color}' data-id='{$permission_id}' data-date='{$permission_date}'
    data-member_key='{$permission_member_key}' data-status='{$permission_status}'
    data-date_send='{$permission_date_send}' data-absence_date='{$permission_absence_date}'
    data-comment='{$permission_comment}' data-serving_one='$permission_serving_one'
    data-date_decision='{$permission_date_decision}' data-notice='$permission_notice'
    data-toggle='modal' data-target='#edit_permission_blank' $show_string>
    <div class='col-2 pl-1'>{$short_absence_date}</div>
    <div class='col-8'>{$permission_comment_short}</div>
    <div class='col-2'>{$checked_string}</div>
    </div>";
  endforeach; ?>
</div>
