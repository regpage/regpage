<?php
/**
*  Местности, регионы и страны
*
**/
class localities
{

  static function get_localities () {
        $res = db_query("SELECT `key`, `name` FROM locality ORDER BY name ASC");

        $localities = array ();
        while ($row = $res->fetch_assoc()) $localities[$row['key']]=$row['name'];
        return $localities;
  }

  static function db_getMemberLocality ($memberId) {
      global $db;
      $memberId = $db->real_escape_string($memberId);
      $res=db_query ("SELECT l.name FROM member m INNER JOIN locality l ON l.key=m.locality_key WHERE m.key='$memberId'");
      $row = $res->fetch_assoc();
      return $row ? $row['name'] : '';
  }

  static function db_getAdminLocality($adminId){
      global $db;
      $adminId = $db->real_escape_string($adminId);

      $res = db_query("SELECT locality_key FROM member WHERE `key`='$adminId'");

      if($res->num_rows>0){
          return $res->fetch_assoc()['locality_key'];
      }
      return '';
  }

  static function db_getLocalityKeyByName($locality_name){
      global $db;
      $_locality_name = $db->real_escape_string($locality_name);
      $res = db_query("SELECT `key` FROM locality WHERE name = '$locality_name' LIMIT 1");

      if ($row = $res->fetch_assoc())
          return $row['key'];
      return null;
  }

  function db_getLocalityByKey($locality_key){
      global $db;
      $locality = $db->real_escape_string($locality_key);
      $res = db_query("SELECT name FROM locality WHERE `key`='$locality'");

      if ($row = $res->fetch_object()){
          return $row->name;
      }
      return null;
  }

  static function db_getAdminCountry($adminId) {
      global $db;
      $adminId = $db->real_escape_string($adminId);

      $res=db_query ("SELECT c.key as country
                      FROM member m
                      INNER JOIN locality l ON l.key = m.locality_key
                      INNER JOIN region r ON r.key = l.region_key
                      INNER JOIN country c ON c.key = r.country_key
                      WHERE m.key='$adminId'");

      while ($row = $res->fetch_assoc()) $country=$row['country'];
      return $country;
  }

  static function get_countries ($sorted_ones)
  {
      $res=db_query ($sorted_ones ? "SELECT `key` as id, name FROM country WHERE COALESCE(`order`,0)>0 ORDER BY `order`" :
                     "SELECT `key` as id, name FROM country WHERE COALESCE(`order`,0)=0 ORDER BY name");

      $countries = array ();
      while ($row = $res->fetch_assoc()) $countries[$row['id']]=$row['name'];
      return $countries;
  }

  // Получаем страну по местности
  static function db_getCountryByLocality($localityKey){
      global $db;
      $localityKey = $db->real_escape_string($localityKey);
      $country;

      $res=db_query ("SELECT r.country_key AS country_key
                      FROM locality l
                      INNER JOIN region r ON r.key = l.region_key
                      WHERE l.key='$localityKey'");

      while ($row = $res->fetch_assoc()) $country=$row['country_key'];
      return $country;
  }

  static function db_getRegionsList()
  {
      $res=db_query ("SELECT `key`, `name` FROM region WHERE COALESCE(`name`,0)!='--'");
      $regions = array ();
      while ($row = $res->fetch_object()) $regions[]=$row;
      return $regions;
  }

  static function db_getLocalListByRegion()
  {
      $res = db_query("SELECT CONCAT_WS (':', c.key, r.key, l.key) as locality_key, l.name FROM region r INNER JOIN locality l ON r.key=l.region_key INNER JOIN country c ON c.key=r.country_key");

      $localities = array ();
      while ($row = $res->fetch_object()) $localities[]=$row;
      return $localities;
  }

  function db_getAdminLocalitiesWithFilters($adminId){
      global $db;
      $adminId = $db->real_escape_string($adminId);

      $res=db_query ("SELECT DISTINCT * FROM (
                      SELECT l.key as id, l.name as name
                      FROM access a
                      LEFT JOIN country c ON c.key = a.country_key
                      LEFT JOIN region r ON r.key = a.region_key or c.key=r.country_key
                      INNER JOIN locality l ON l.region_key = r.key OR l.key=a.locality_key
                      LEFT JOIN member m ON m.locality_key = l.key
                      WHERE a.member_key='$adminId' and l.key is not null
                      UNION
                      SELECT f.value as id, f.name as name
                      FROM filter f
                      WHERE f.admin_key='$adminId' and f.value is not null
                      ) q ORDER BY q.name");

      $localities = array ();
      while ($row = $res->fetch_assoc()) $localities[]=$row;
      return $localities;

  }

  static function getAdminLocalities ($adminId)
  {
      global $db;
      $adminId = $db->real_escape_string($adminId);

      $res=db_query ("SELECT DISTINCT * FROM (
                      SELECT l.key as id, l.name as name
                      FROM access a
                      LEFT JOIN country c ON c.key = a.country_key
                      LEFT JOIN region r ON r.key = a.region_key or c.key=r.country_key
                      INNER JOIN locality l ON l.region_key = r.key OR l.key=a.locality_key
                      LEFT JOIN member m ON m.locality_key = l.key
                      WHERE a.member_key='$adminId'
                      UNION
                      SELECT l.key as id, l.name as name
                      FROM member m
                      LEFT JOIN locality l ON l.key=m.locality_key
                      WHERE m.admin_key='$adminId'
                      UNION
                      SELECT l.key as id, l.name as name
                      FROM reg
                      INNER JOIN member m ON m.key=reg.member_key
                      LEFT JOIN locality l ON l.key=m.locality_key
                      WHERE reg.admin_key='$adminId'
                      ) q ORDER BY q.name");

      $localities = array ();
      while ($row = $res->fetch_assoc()) $localities[$row['id']]=$row['name'];
      return $localities;
  }

  function db_getAdminLocalitiesNotRegTbl ($adminId)
  {
      global $db;
      $adminId = $db->real_escape_string($adminId);

      $res=db_query ("SELECT DISTINCT * FROM (
                      SELECT l.key as id, l.name as name
                      FROM access a
                      LEFT JOIN country c ON c.key = a.country_key
                      LEFT JOIN region r ON r.key = a.region_key or c.key=r.country_key
                      INNER JOIN locality l ON l.region_key = r.key OR l.key=a.locality_key
                      LEFT JOIN member m ON m.locality_key = l.key
                      WHERE a.member_key='$adminId'
                      ) q ORDER BY q.name");

      $localities = array ();
      while ($row = $res->fetch_assoc()) $localities[$row['id']]=$row['name'];
      return $localities;
  }
  function db_getAdminLocalitiesAdmin($query, $adminId){
      global $db;
      $adminId = $db->real_escape_string($adminId);
      $query = $db->real_escape_string($query);

      $res=db_query ("SELECT l.key as data, l.name as value
                      FROM access a
                      LEFT JOIN country c ON c.key = a.country_key
                      LEFT JOIN region r ON r.key = a.region_key or c.key=r.country_key
                      INNER JOIN locality l ON l.region_key = r.key OR l.key=a.locality_key
                      WHERE a.member_key='$adminId' and l.key is not null AND l.name LIKE '$query%'
                      ORDER BY l.name");

      $localities = array ();
      while ($row = $res->fetch_object()) $localities[]=$row;
      return $localities;

  }

}


?>
