<?php
/**
 * isAdmin() есть у админа зоны доступа?
 * getAdminEventsRespForReg это админ мероприятия?
 */
class Access
{
  static function isZoneAdmin($adminId) {
      $adminId = db_real_escape_string($adminId);
      $res=db_query ("SELECT DISTINCT l.key as id, l.name as name FROM access a
                      LEFT JOIN country c ON c.key = a.country_key
                      LEFT JOIN region r ON r.key = a.region_key or c.key=r.country_key
                      LEFT JOIN locality l ON l.region_key = r.key OR l.key=a.locality_key
                      WHERE a.member_key='$adminId'");

      return $res->num_rows > 0;
  }

  static function getAdminEventsRespForReg($adminId) {
      $adminId = db_real_escape_string($adminId);
      $res = db_query("SELECT `key` as event_id FROM event_access WHERE member_key='{$adminId}'");

      $events = [];
      while ($row = $res->fetch_assoc()) $events [] = $row['event_id'];
      return $events;
  }

  static function isFttPage()
  {
    if (explode('_', $_SERVER['PHP_SELF'])[0] === '/ftt') {
      return true;
    } else {
      return false;
    }
  }
}
