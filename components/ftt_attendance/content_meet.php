<br>
<div id="meet_list_header" class="btn-group mb-2">
  <button type="button" id="meet_add" class="btn btn-success btn-sm rounded mr-2" data-toggle="modal" data-target="#edit_meet_blank">Добавить</button>
  <button type="button" id="meet_flt_modal_open" class="btn btn-primary btn-sm rounded mr-2" data-toggle="modal" data-target="#modal_meet_filters" style="display: none;">Фильтры</button>
</div>
<div id="meet_list_content" class="">
<?php
  foreach (get_communication_records($memberId) as $key => $value) {
    $date = yyyymmdd_to_ddmm($value['date']);
    echo "<div class='cursor-pointer str_record' data-id='{$value['id']}'>{$date} — {$value['time']} Служащий: {$serving_ones_list[$value['serving_one']]}</div>";
  }
?>
</div>

<?php // MODALS
include 'components/ftt_attendance/modal_meet.php';
?>
