<?php
/**
 * получаем разрешения по обучающемуся
 */
class FttPermissions
{
  static function get_by_trainee($member_id)
  {
    global $db;
    $member_id = $db->real_escape_string($member_id);
    $result = [];

    $res = db_query("SELECT fps.id, fps.member_key, fps.absence_date, fps.date, fps.comment, fps.status, fps.date_send
      FROM ftt_permission_sheet AS fps
      WHERE  fps.member_key = '$member_id'
      ORDER BY fps.date");
    while ($row = $res->fetch_assoc()) $result[]=$row;

    return $result;
  }

  static function get_by_trainee_data($member_id)
  {
    global $db;
    $member_id = $db->real_escape_string($member_id);
    $result = [];

    $res = db_query("SELECT fps.id, fps.member_key, fps.absence_date, fps.date, fps.comment, fps.status, fps.date_send,
      fp.id AS fp_id, fp.sheet_id, fp.session_id, fp.session_correction_id, fp.session_name, fp.session_time, fp.duration
      FROM ftt_permission_sheet AS fps
      INNER JOIN ftt_permission fp ON fp.sheet_id = fps.id
      WHERE  fps.member_key = '$member_id'
      ORDER BY fps.date");
    while ($row = $res->fetch_assoc()) $result[]=$row;

    return $result;
  }

  static function get_by_staff($member_id)
  {
    global $db;
    $member_id = $db->real_escape_string($member_id);
  }
}
 ?>
