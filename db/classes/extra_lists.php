<?php
/**  Списки дополнительные
*  Часовые пояса
*
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
}


?>
