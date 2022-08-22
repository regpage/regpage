<?php
/**
 * Получаем данные об участние
 */
class Member
{

  static function get_data($member_key)
  {
    global $db;
    $member_key = $db->real_escape_string($member_key);
    $result=[];
    //  left & right join LOCALITY NAME ect
    $res = db_query("SELECT m.key, m.address, m.category_key, m.citizenship_key, m.baptized, m.russian_lg,
      m.document_key, m.document_num, m.document_date, m.document_auth, m.document_dep_code,
      m.tp_num, m.tp_date, m.tp_auth, m.tp_name, m.comment, m.changed,
      ft.member_key, ft.gospel_group, ft.gospel_team, ft.semester, ft.serving_one, ft.coordinator, ft.time_zone
      FROM member m
      INNER JOIN ftt_trainee ft ON ft.member_key = m.key
      WHERE m.key = '$member_key'
      ORDER BY m.name");
      while ($row = $res->fetch_assoc()) $result=$row;

      return $result;
  }

  static function get_data_staff($member_key)
  {
    global $db;
    $member_key = $db->real_escape_string($member_key);
    $result=[];
    //  left & right join LOCALITY NAME ect
    $res = db_query("SELECT m.key, m.address, m.category_key, m.citizenship_key, m.baptized, m.russian_lg,
      m.document_key, m.document_num, m.document_date, m.document_auth, m.document_dep_code,
      m.tp_num, m.tp_date, m.tp_auth, m.tp_name, m.comment, m.changed
      FROM member AS m
      WHERE m.key = '$member_key'
      ORDER BY m.name");
      while ($row = $res->fetch_assoc()) $result=$row;

      return $result;
  }
  // предварительная версия
  static function db_getAdminMembers ($adminId)
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

  function db_getMemberListAdmins ($sortField, $sortType)
  {
      global $db;

      $res=db_query ("SELECT m.key as id, m.name as name, m.email as email, m.cell_phone as cell_phone,
          lo.name as locality_name, ad.comment as note, GROUP_CONCAT(DISTINCT c.key) as countries, GROUP_CONCAT(DISTINCT r.key) as regions, GROUP_CONCAT(DISTINCT l.key) as localities
          FROM access as a
          INNER JOIN admin ad ON ad.member_key=a.member_key
          INNER JOIN member m ON a.member_key = m.key
          INNER JOIN locality lo ON lo.key=m.locality_key

          LEFT JOIN country c ON c.key=a.country_key
          LEFT JOIN region r ON r.country_key=c.key OR r.key=a.region_key
          LEFT JOIN locality l ON l.region_key=r.key OR l.key=a.locality_key

          GROUP BY m.key ORDER BY m.name");

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
