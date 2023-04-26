<?php
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
    $res = db_query("INSERT INTO `ftt_skip` (`id_attendance`, `id_attendance_sheet`, `changed`)
    VALUES ('{$id_attendance}', '{$id_attendance_sheet}', 1)");
  }
}

function getMissedClasses($sort='', $status='_all_')
{

  global $db;
  $sort = $db->real_escape_string($sort);
  $status = $db->real_escape_string($status);
  $result = [];
  $condition = ' 1 ';
  $order = ' fas.date, m.name ';

  if ($status === 'done') {

  } elseif ($status === 'panding') {

  }

  $res = db_query("SELECT fs.*, fas.date AS date_blank, fas.member_key, fa.session_name, fa.session_time, m.name, tr.serving_one
    FROM ftt_skip AS fs
    LEFT JOIN ftt_attendance fa ON fa.id = fs.id_attendance
    LEFT JOIN ftt_attendance_sheet fas ON fas.id = fs.id_attendance_sheet
    LEFT JOIN member m ON m.key = fas.member_key
    LEFT JOIN ftt_trainee tr ON tr.member_key = fas.member_key
    WHERE {$condition}
    ORDER BY {$order}");
  while ($row = $res->fetch_assoc()) $result[] = $row;

  return $result;
}

function dltMissedClass($id)
{
  global $db;
  $id = $db->real_escape_string($id);

  $res = db_query("DELETE FROM `ftt_skip` WHERE `id_attendance_sheet` = '$id' AND `status` <> 1 AND `status` <> 2");

  return $res;
}

function setSkipBlank($data, $file)
{
  global $db;
  $data = json_decode($data);
  $id = $db->real_escape_string($data->id);
  $topic = $db->real_escape_string($data->topic);
  $status = $db->real_escape_string($data->status);
  $comment = $db->real_escape_string($data->comment);
  if ($file === '_none_') {
    $file = '';
  } else {
    $file = $db->real_escape_string($file);
    $file = " `file` = '$file', ";
  }

  $res = db_query("UPDATE `ftt_skip` SET `topic` = '{$topic}', `status` = '{$status}', `comment` = '{$comment}', {$file} `changed` = 1  WHERE `id` = '$id'");


}
/* MISSED CLASS */
