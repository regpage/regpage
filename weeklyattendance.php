<?php
//
// строку ниже заменить на config.php
include_once 'config.php';
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
      // extrahelp
      $member_key = $value['member_key'];
      $date_for_msg = date_convert::yyyymmdd_to_ddmm($value['date']);
      $reason = "Не отправлен вовремя лист посещаемости от {$date_for_msg}";
      $serving_one = $value['serving_one'];
      db_query("INSERT INTO ftt_extra_help (`date`, `member_key`, `reason`, `serving_one`, `changed`)
      VALUES (NOW(), '$member_key', '$reason', '$serving_one', 1)");
      echo "{$member_key}, ";
      // missed class
      setMissedClasses($id);
    }
  }
}

/* MISSED CLASS */
function checkMissedSessions($sheet_id)
{
  global $db;
  $sheet_id = $db->real_escape_string($sheet_id);
  $result = [];

  $res = db_query("SELECT * FROM `ftt_attendance` WHERE `sheet_id` = '$sheet_id' AND `class` = '1' AND (`reason` != '' OR `absence` = '1')");
  while ($row = $res->fetch_assoc()) $result[] = $row;

  return $result;
}

function setMissedClasses($sheet_id='')
{
  global $db;
  $sheet_id = $db->real_escape_string($sheet_id);
  $check = checkMissedSessions($sheet_id);

  if ($sheet_id === '') {
    write_to_log::error('', 'Нет ID бланка. Пропущенные занятия не проверены');
    return 'Error. No ID.';
  }

  foreach ($check as $key => $value) {
    $id_attendance = $value['id'];
    $id_attendance_sheet = $value['sheet_id'];
    $res = db_query("INSERT INTO `ftt_skip` (`id_attendance`, `id_attendance_sheet`, `comment`, `changed`)
    VALUES ('{$id_attendance}', '{$id_attendance_sheet}', 'Бланк не сдан во время, обратитесь к служащему.', 1)");
  }
}
/* MISSED CLASS */

db_checkweeklyAttendance ();

?>
