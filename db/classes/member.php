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
  /*
  static function member_full($value='')
  {
  l.name AS locality_name,m.name, m.male,m.birth_date, m.cell_phone, m.email, m.attend_meeting,m.locality_key,
  LEFT JOIN locality l ON l.key = m.locality_key
  }
  */
}
 ?>
