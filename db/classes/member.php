<?php
/**
 * Получаем данные об участние
 */
class Member
{

  static function get_name ($memberId)
  {
      global $db;
      $memberId = $db->real_escape_string($memberId);
      $res=db_query ("SELECT name FROM member WHERE `key`='$memberId'");
      $row = $res->fetch_assoc();
      return $row ? $row['name'] : '';
  }
  static function get_data($member_key)
  {
    global $db;
    $member_key = $db->real_escape_string($member_key);
    $result=[];
    //  left & right join LOCALITY NAME ect
    $res = db_query("SELECT m.key, m.address, m.category_key, m.citizenship_key, m.baptized, m.russian_lg,
      m.document_key, m.document_num, m.document_date, m.document_auth, m.document_dep_code,
      m.tp_num, m.tp_date, m.tp_auth, m.tp_name, m.comment, m.changed, m.new_locality,
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
      m.new_locality, m.tp_num, m.tp_date, m.tp_auth, m.tp_name, m.comment, m.changed
      FROM member AS m
      WHERE m.key = '$member_key'
      ORDER BY m.name");
      while ($row = $res->fetch_assoc()) $result=$row;

      return $result;
  }

  static function get_full($member_key)
  {

    $member_key = db_real_escape_string($member_key);
    $result=[];

    $res = db_query("SELECT m.* FROM member m WHERE m.key = '{$member_key}'");
      while ($row = $res->fetch_assoc()) $result=$row;

      return $result;
  }  

  static function get_fullMemberLocalityInfo($member_key)
  {
    $member_key = db_real_escape_string($member_key);
    $result=['locality'=>'','region'=>'','country'=>''];

    $res=db_query ("SELECT l.name AS locality_name, r.name AS region_name, c.name AS country_name
      FROM member m
      INNER JOIN locality l ON l.key = m.locality_key
      INNER JOIN region r ON r.key = l.region_key
      INNER JOIN country c ON c.key = r.country_key
      WHERE m.key='{$member_key}'");
      while ($row = $res->fetch_assoc()) $result=['locality'=>$row['locality_name'],'region'=>$row['region_name'],'country'=>$row['country_name']];

    return $result;
  }
}
