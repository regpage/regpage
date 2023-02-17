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

  // участники для раздела "Список посещаемости"
  function getListAttend ($adminId, $sortField, $sortType)
  {
      global $db;
      $adminId = $db->real_escape_string($adminId);
      $sortField = $db->real_escape_string($sortField);
      $sortType = $db->real_escape_string($sortType);
      $sortAdd = $sortField!=' name ' ? ' , name' : ' ';
      $active = 'active DESC, ';
      //(SELECT at.attend_pm FROM attendance at WHERE at.member_key=m.key) as attend_pm_n
      //(SELECT at.attend_pm FROM attendance at WHERE at.member_key=m.key) as attend_pm_n
      $res=db_query ("SELECT DISTINCT * FROM (SELECT m.key as id, m.name as name, IF (COALESCE(l.name,'')='', m.new_locality, l.name) as locality,
                      (SELECT name FROM member m2 WHERE m2.key=m.admin_key) as admin_name, m.active, m.locality_key,
                      DATEDIFF(CURRENT_DATE, STR_TO_DATE(m.birth_date, '%Y-%m-%d'))/365 as age, m.birth_date,
                      m.category_key, m.attend_meeting,
                      ca.name as category_name,
                      (SELECT rg.name FROM region rg WHERE rg.key=l.region_key) as region,
                      (SELECT co.name FROM country co INNER JOIN region re ON co.key=re.country_key WHERE l.region_key=re.key) as country, at.attend_pm, at.attend_gm,at.attend_am, at.attend_vt,
                      at.comment AS at_comment, at.editors
                      FROM access as a
                      LEFT JOIN country c ON c.key = a.country_key
                      LEFT JOIN region r ON r.key = a.region_key OR c.key=r.country_key
                      INNER JOIN locality l ON l.region_key = r.key OR l.key=a.locality_key
                      INNER JOIN member m ON m.locality_key = l.key
                      LEFT JOIN category ca ON ca.key = m.category_key
                      LEFT JOIN attendance at ON at.member_key = m.key
                      WHERE a.member_key='$adminId'
                      UNION
                      SELECT m.key as id, m.name as name, IF (COALESCE(m.locality_key,'')='', m.new_locality, m.name) as locality,
                      (SELECT name FROM member m2 WHERE m2.key=m.admin_key) as admin_name, m.active, m.locality_key,
                      DATEDIFF(CURRENT_DATE, STR_TO_DATE(m.birth_date, '%Y-%m-%d'))/365 as age, m.birth_date,
                      m.category_key, m.attend_meeting,
                      ca.name as category_name, at.attend_pm, at.attend_gm, at.attend_am, at.attend_vt,
                      at.comment AS at_comment, at.editors,
                      '' as region,
                      '' as country
                      FROM member m
                      LEFT JOIN category ca ON ca.key = m.category_key
                      LEFT JOIN attendance at ON at.member_key = m.key
                      WHERE m.admin_key='$adminId' and m.locality_key is NULL
                      ) q ORDER BY $active $sortField $sortType $sortAdd ");

      $members = array ();
      while ($row = $res->fetch_object()) $members[]=$row;
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
