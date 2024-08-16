<?php
/**
 * фильтр по первым буквам
 */
class LetterFilter
{
  static function reg($adminId, $eventId)
  {
    $adminId = db_real_escape_string($adminId);
    $eventId = db_real_escape_string($eventId);

    $res=db_query ("SELECT DISTINCT LEFT(name, 1) as letter FROM
      (SELECT m.key as id, m.name as name, m.locality_key as locality_key
      FROM access AS a
      LEFT JOIN country c ON c.key = a.country_key
      LEFT JOIN region r ON r.key = a.region_key OR c.key=r.country_key
      INNER JOIN locality l ON l.region_key = r.key OR l.key=a.locality_key
      INNER JOIN member m ON m.locality_key = l.key
      INNER JOIN reg ON reg.member_key = m.key
      WHERE a.member_key='{$adminId}' AND reg.event_key='{$eventId}'
      UNION
      SELECT m.key as id, m.name as name, m.locality_key as locality_key
      FROM reg
      INNER JOIN member m ON m.key = reg.member_key
      LEFT JOIN locality l ON l.key = m.locality_key
      WHERE (reg.admin_key = '{$adminId}') AND reg.event_key='{$eventId}'
      ) q ORDER BY q.name");

      $letters = [];
      while ($row = $res->fetch_assoc()) $letters[]=$row['letter'];

      return $letters;
  }

  static function regService($eventId)
  {
    $eventId = db_real_escape_string($eventId);
    $letters = [];

    $res=db_query ("SELECT DISTINCT LEFT(m.name, 1) as letter
      FROM member as m
      INNER JOIN reg ON reg.member_key = m.key
      WHERE reg.event_key={$eventId}
      ORDER BY m.name");

    while ($row = $res->fetch_assoc()) $letters[]=$row['letter'];    

    return $letters;
  }
  static function member($adminId, $reg)
  {
    // $res = "SELECT DISTINCT LEFT(`name`, 1) as name   FROM `member` WHERE 1";
  }
}
