<?php
/**
 * получть только занятия из расписания
 */
class Sessions
{

  static function get_classes($timeZone, $semester, $day)
  {
    global $db;
    $timeZone = $db->real_escape_string($timeZone);
    $semester = $db->real_escape_string($semester);
    $day = $db->real_escape_string($day);
    $semesterRange = 0;
    $result = [];

    // устанавливаем semester_range
    if ($semester > 0 && $semester < 5) {
      $semesterRange = "`semester_range` < 2";
    } elseif ($semester > 4) {
      $semesterRange = "`semester_range` != 1";
    }

    $res = db_query("SELECT `id`, `session_name`
      FROM `ftt_session`
      WHERE {$semesterRange} AND `time_zone` = '{$timeZone}' AND `class` = 1 AND `{$day}` != ''
      ORDER BY `session_name`");
    while ($row = $res->fetch_assoc()) $result[] = $row;
    return $result;
  }
}
