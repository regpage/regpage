<?php
/**
 * isAdmin() Есть у админа зоны доступа?
 */
class Access
{

  function isAdmin($adminId){
      global $db;
      $adminId = $db->real_escape_string($adminId);
      $res=db_query ("SELECT DISTINCT l.key as id, l.name as name FROM access a
                      LEFT JOIN country c ON c.key = a.country_key
                      LEFT JOIN region r ON r.key = a.region_key or c.key=r.country_key
                      LEFT JOIN locality l ON l.region_key = r.key OR l.key=a.locality_key
                      WHERE a.member_key='$adminId'");

      return $res->num_rows > 0;
  }
}
 ?>
