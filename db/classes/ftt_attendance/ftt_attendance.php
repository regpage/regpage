<?php
/**
 *
 */
class FttAttendance
{
  // получаем номер листа
  static function getIdByDate ($memberKey, $date)
  {
    global $db;
    $memberKey = $db->real_escape_string($memberKey);
    $date = $db->real_escape_string($date);

    $result = '';
    $res = db_query("SELECT `id` FROM `ftt_attendance_sheet` WHERE `member_key` = '{$memberKey}' AND `date` = '{$date}'");
    while ($row = $res->fetch_assoc()) $result = $row['id'];

    return $result;
  }
  // получаем номер позиции в листе
  static function getAttendanceIdBySheetId ($sheetId, $class=1)
  {
    global $db;
    $sheetId = $db->real_escape_string($sheetId);
    $class = $db->real_escape_string($class);

    $result = [];
    $res = db_query("SELECT `id`, `session_name` FROM `ftt_attendance` WHERE `sheet_id` = '{$sheetId}' AND `class` = '{$class}'");
    while ($row = $res->fetch_assoc()) $result[] = $row;

    return $result;
  }
}
