<?php
/* Пропущенные занятия */
function checkMissedSessions($sheet_id)
{
  global $db;
  $sheet_id = $db->real_escape_string($sheet_id);
  $result = [];
  // если установлена причина или опоздание >= 20 мин
  // если причина "Р" и опоздания нет или оно < 20 мин то проп. занятие не создаётся
  $res = db_query("SELECT * FROM `ftt_attendance`
    WHERE `sheet_id` = '$sheet_id' AND `class` = '1' AND (
    ((`reason` != '' AND `reason` != 'Р') OR `absence` = '1') OR
    (`reason` = 'Р' AND `attend_time` = '') OR
    (`reason` = 'Р' AND  ((TIME_FORMAT(`attend_time`, '%k%i') - TIME_FORMAT(`session_time`, '%k%i')) >= 20))
    )");
  while ($row = $res->fetch_assoc()) $result[] = $row;

  return $result;
}

function setMissedClasses($sheet_id='')
{
  global $db;
  $sheet_id = $db->real_escape_string($sheet_id);
  $check = checkMissedSessions($sheet_id);

  if ($sheet_id === '') {
    //write_to_log::error('', 'Нет ID бланка. Пропущенные занятия не проверены');
    return 'Error. No ID.';
  }

  foreach ($check as $key => $value) {
    $id_attendance = $value['id'];
    $id_attendance_sheet = $value['sheet_id'];
    $res = db_query("INSERT INTO `ftt_skip` (`id_attendance`, `id_attendance_sheet`, `changed`)
    VALUES ('{$id_attendance}', '{$id_attendance_sheet}', 1)");
  }
}

function getMissedClasses($sort='', $member='_all_')
{

  global $db;
  $sort = $db->real_escape_string($sort);
  $member = $db->real_escape_string($member);
  $result = [];
  $condition = ' 1 ';
  $order = ' fas.date, m.name ';
  if (!empty($sort)) {
    if ($sort === 'skip_sort_date-desc') {
      $order = ' fas.date DESC, m.name DESC ';
    } elseif ($sort === 'skip_sort_trainee-asc') {
      $order = ' m.name, fas.date ';
    } elseif ($sort === 'skip_sort_trainee-desc') {
      $order = ' m.name DESC, fas.date DESC ';
    }
  }

  if ($member !== '_all_') {
    $condition = " fas.member_key = '{$member}'";
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

function setSkipBlank($data)
{
  global $db;
  $data = json_decode($data);
  $sheet_id = $db->real_escape_string($data->sheet_id);
  $id = $db->real_escape_string($data->id);
  $topic = $db->real_escape_string($data->topic);
  $status = $db->real_escape_string($data->status);
  $comment = $db->real_escape_string($data->comment);
  $id_attendance = $db->real_escape_string($data->id_attendance);

  if (!empty($id)) {
    $res = db_query("UPDATE `ftt_skip` SET `topic` = '{$topic}', `status` = '{$status}', `comment` = '{$comment}', `changed` = 1  WHERE `id` = '$id'");
  } else {
    $res = db_query("INSERT INTO `ftt_skip` (`topic`, `status`, `comment`, `id_attendance_sheet`, `id_attendance`, `changed`) VALUES ('{$topic}', '{$status}', '{$comment}', '{$sheet_id}', '{$id_attendance}', 1)");
  }

  return $res;
}

function setPics($id, $file)
{
  global $db;
  $file = $db->real_escape_string($file);
  $id = $db->real_escape_string($id);
  $result = '';

  $res = db_query("SELECT `file` FROM `ftt_skip` WHERE `id` = '$id'");
  while ($row = $res->fetch_assoc()) $result = $row['file'];

  if (!empty($result)) {
    $file = $file . ';' . $result;
  }

  $res = db_query("UPDATE `ftt_skip` SET `file` = '{$file}', `changed` = 1  WHERE `id` = '$id'");

  return $file;
}
/* MISSED CLASS */
