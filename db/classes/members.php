<?php
/**
 * Получаем списки участников
 * db_get_members_by_admin получаем данные по всем зонам администратора
 */
class Members
{
  // предварительная версия
  static function db_get_members_by_admin ($adminId)
  {
      global $db;
      $adminId = $db->real_escape_string($adminId);

      $res=db_query ("SELECT DISTINCT * FROM (
                          SELECT m.key as id, m.name as name, l.name as locality, l.key as locId, m.category_key as catId
                          FROM access a
                          LEFT JOIN country c ON c.key = a.country_key
                          LEFT JOIN region r ON r.key = a.region_key or c.key=r.country_key
                          INNER JOIN locality l ON l.region_key = r.key OR l.key=a.locality_key
                          INNER JOIN member m ON m.locality_key = l.key
                          WHERE a.member_key='$adminId'
                          UNION
                          SELECT m.key as id, m.name as name, COALESCE(l.name, m.new_locality) as locality,
                          l.key as locId, m.category_key as catId
                          FROM member m
                          LEFT JOIN locality l ON l.key=m.locality_key
                          WHERE m.admin_key='$adminId'
                          UNION
                          SELECT m.key as id, m.name as name, COALESCE(l.name, m.new_locality) as locality, l.key as locId,
                          m.category_key as catId
                          FROM reg
                          INNER JOIN member m ON m.key=reg.member_key
                          LEFT JOIN locality l ON l.key=m.locality_key
                          WHERE reg.admin_key='$adminId'
                          ) q ORDER BY q.name");

      $members = array ();
      while ($row = $res->fetch_assoc())
          $members[$row['id']]=array (
              "name" => $row['name'],
              "locality" => $row['locality'],
              "localityId" => $row['locId'],
              "categoryId" => $row['catId']
          );
      return $members;
  }

  /*
  static function member_full($value='')
  {
  l.name AS locality_name,m.name, m.male,m.birth_date, m.cell_phone, m.email, m.attend_meeting,m.locality_key,
  LEFT JOIN locality l ON l.key = m.locality_key
  }
  */
}
 ?>
