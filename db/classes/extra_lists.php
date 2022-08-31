<?php
/**  Списки дополнительные
*  Часовые пояса
*  Часовые пояса для которых существует расписанием пвом
**/
class extra_lists {

  //global $db;
  //$memberId = $db->real_escape_string($memberId);

  // Часовые пояса / time zones
  static function get_time_zones () {
    $result = [];
    $res = db_query("SELECT * FROM time_zone WHERE `archive` = 0 ORDER BY `utc`");
    while ($row = $res->fetch_assoc()) $result[$row['id']] = $row;
    return $result;
  }

  // Часовые пояса для которых есть расписание / time zones
  static function get_schedule_zones () {
    $time_zones = self::get_time_zones ();
    $result = [];
    $res = db_query("SELECT DISTINCT `time_zone` FROM ftt_session");
    while ($row = $res->fetch_assoc()) {
      if (array_key_exists($row['time_zone'], $time_zones)) {
        $result[$row['time_zone']] = $time_zones[$row['time_zone']];
      }
    }
    return $result;
  }
}


?>
