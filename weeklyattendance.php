<?php
//
// строку ниже заменить на config.php
include_once 'db.php';
include_once 'logWriter.php';
include_once 'db/classes/date_convert.php';

function db_checkweeklyAttendance () {
  $result=[];
  $res = db_query("SELECT fas.id, fas.member_key, fas.date, fas.status, fas.date_send, fas.changed, ft.serving_one
    FROM  ftt_attendance_sheet AS fas
    INNER JOIN ftt_trainee ft ON ft.member_key = fas.member_key
    WHERE (fas.date = DATE_FORMAT((NOW() - INTERVAL 7 DAY), '%Y-%m-%d')) AND fas.status=0");
  while ($row = $res->fetch_assoc()) $result[]=$row;

  foreach ($result as $key => $value){
    $id = $value['id'];
    $check = false;
    $res_2 = db_query("SELECT `id` FROM ftt_attendance WHERE `sheet_id`='$id' LIMIT 1");
    while ($row = $res_2->fetch_assoc()) $check=true;

    if ($check) {
      db_query("UPDATE `ftt_attendance_sheet` SET `status` = 2 WHERE `id` = '{$id}'");
      $member_key = $value['member_key'];
      $date_for_msg = date_convert::yyyymmdd_to_ddmm($value['date']);
      $reason = "Не отправлен вовремя лист посещаемости от {$date_for_msg}";
      $serving_one = $value['serving_one'];
      db_query("INSERT INTO ftt_extra_help (`date`, `member_key`, `reason`, `serving_one`, `changed`)
      VALUES (NOW(), '$member_key', '$reason', '$serving_one', 1)");
      echo "{$member_key}, ";
    }
  }
}

db_checkweeklyAttendance ();
?>
