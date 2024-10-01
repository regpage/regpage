<?php
/**
 * Важный класс получаем участников мероприятия по ответственному за регистрацию (по зонам) и id мероприятия
 */
class RegPage
{
  // получаем участников мероприятия по ответственному за регистрацию (по зонам) и id мероприятия
  function getEventMembers($adminId, $eventId, $category = '_all_', $status = '_all_') {
      global $db;
      $adminId = $db->real_escape_string($adminId);
      $eventId = $db->real_escape_string($eventId);
      $category = $db->real_escape_string($category);
      // можно сделать условие в родительском классе что то вроде этого $category = parent::getCondition($db->real_escape_string($category), 'AND m.category_key');
      // выбрать с категорией
      // для проверки на существование статуса или категории можно получать их списки
      if ($category === '_all_') {
        $category = '';
      } else {
        $category = " AND m.category_key = '{$category}' ";
      }
      // выбрать со статусом
      if ($status === '_all_') {
        $status = '';
      } else {
        $status = " AND r.status_key = '{$status}' ";

      }
          $res=db_query ("SELECT DISTINCT m.key as id, m.name as name
              FROM access as a
              LEFT JOIN country c ON c.key = a.country_key
              LEFT JOIN region r ON r.key = a.region_key OR c.key=r.country_key
              INNER JOIN locality l ON l.region_key = r.key OR l.key=a.locality_key
              INNER JOIN member m ON m.locality_key = l.key
              INNER JOIN reg re ON re.member_key = m.key
              WHERE a.member_key='{$adminId}' AND re.event_key='{$eventId}' {$} ORDER BY m.name");

      $members = array();
      while ($row = $res->fetch_assoc()) $members[$row['id']]=$row['name'];
      return $members;
  }
  // получаем участников из списка участников по ответственному за регистрацию (по зонам)
  function getMembersByAdmin($adminId) {
      global $db;
      $adminId = $db->real_escape_string($adminId);

          $res=db_query ("SELECT DISTINCT m.key as id, m.name as name
              FROM access as a
              LEFT JOIN country c ON c.key = a.country_key
              LEFT JOIN region r ON r.key = a.region_key OR c.key=r.country_key
              INNER JOIN locality l ON l.region_key = r.key OR l.key=a.locality_key
              INNER JOIN member m ON m.locality_key = l.key
              WHERE a.member_key='{$adminId}' ORDER BY m.name");

      $members = array();
      while ($row = $res->fetch_assoc()) $members[$row['id']]=$row['name'];
      return $members;
  }
}
