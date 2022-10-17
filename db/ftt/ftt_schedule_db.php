<?php
// Расписание
function getSchedule($semestr){
  global $db;
  $semestr = $db->real_escape_string($semestr);
  $result = [];
  $res = db_query("SELECT * FROM ftt_session WHERE `semester_range`= 0 OR `semester_range`= '$semestr'");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}
// Расписание по дням
function getScheduleByDay($semester_range, $day, $time_zone){
  global $db;
  $semester_range = $db->real_escape_string($semester_range);
  $day = $db->real_escape_string($day);
  $time_zone = $db->real_escape_string($time_zone);

  $result = [];
  $res = db_query("SELECT `id`, `$day`, `session_name`, `attendance`, `duration`, `semester_range`, `comment`, `time_zone`
    FROM ftt_session
    WHERE (`semester_range`= 0 OR `semester_range`= '$semester_range') AND (`time_zone` = '$time_zone' OR `time_zone` = '01')
    ORDER BY `$day`");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}
// корректировки расписания

function getCorrectionSchedule() {
  $result = [];
  $res = db_query("SELECT * FROM ftt_session_correction ORDER BY `semester_range`");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

/*
function getScheduleTrainee($id){

}
*/
?>
