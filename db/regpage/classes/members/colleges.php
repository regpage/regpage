<?php
/**
 *
 */
class Colleges
{

  static function getList(){
    $colleges = array ();

    $res = db_query("SELECT `key`, `name` FROM `college` ORDER BY `name`");
    while ($row = $res->fetch_assoc()) $colleges[$row['key']]=$row['name'];

    return $colleges;
  }

  function db_getColleges($member_id){
      global $db;
      $member_id = $db->real_escape_string($member_id);

      //$search = $text ? " AND (c.name LIKE '%$text%' OR c.short_name LIKE '%$text%' OR l.name LIKE '%$text%') " : "";

      $res = db_query("SELECT c.key as id, c.short_name, c.name, l.name as locality, l.key as locality_key,
                  CASE WHEN c.author='$member_id' THEN 1 ELSE 0 END as author
                  FROM college c INNER JOIN locality l ON c.locality_key=l.key ORDER BY c.short_name ASC ");

      $colleges = array ();
      while ($row = $res->fetch_assoc()) $colleges[]=$row;
      return $colleges;
  }

  function db_getCollegesLocality(){
      $res = db_query("SELECT DISTINCT l.name as locality, l.key as locality_key
                  FROM college c INNER JOIN locality l ON c.locality_key=l.key ORDER BY l.name ASC");

      $localities = array ();
      while ($row = $res->fetch_assoc()) $localities[]=$row;
      return $localities;
  }

  function db_setCollege($collegeId, $name, $shortName, $locality, $adminId){
      global $db;
      $collegeId = $db->real_escape_string($collegeId);
      $name = $db->real_escape_string($name);
      $shortName = $db->real_escape_string($shortName);
      $locality = $db->real_escape_string($locality);
      $adminId = $db->real_escape_string($adminId);

      if($collegeId){
          db_query("UPDATE college SET locality_key='$locality', name='$name', short_name='$shortName', changed=1 WHERE `key`='$collegeId'");
      }
      else {
          $newCollegeId = db_getNewCollegeKey();
          db_query("INSERT INTO college (`key`, locality_key, name, short_name, author, changed) VALUE ('$newCollegeId', '$locality', '$name', '$shortName', '$adminId', 1)");

          $adminName = db_getAdminNameById($adminId);

          db_sendMsgToRespOneSync(COLLEGE_TYPE, [ 'name' => $name, 'short_name' => $shortName, 'author' => $adminName]);
      }
  }

  function db_getNewCollegeKey (){
      $res=db_query ("SELECT `key` as id FROM college WHERE `key` LIKE '9%' ORDER BY `key` DESC LIMIT 1");
      $row = $res->fetch_object();
      $key = "90000";
      if ($row && strlen($row->id) == 5) $key = (string)($row->id + 1);
      return $key;
  }

  function db_deleteCollege($collegeId){
      global $db;
      $collegeId = $db->real_escape_string($collegeId);
      db_query ("DELETE FROM college WHERE `key`='$collegeId'");
  }
}
