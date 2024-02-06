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

    $res = db_query("SELECT fps.id, fps.member_key, fps.absence_date, fps.date,
      fps.comment, fps.status, fps.date_send, fps.decision_date, fps.comment_extra, fps.notice
      FROM ftt_permission_sheet AS fps
      WHERE  fps.member_key = '$member_id'
      ORDER BY fps.absence_date DESC");
    while ($row = $res->fetch_assoc()) $result[]=$row;

    return $result;
  }

  static function get_by_trainee_data($member_id)
  {
    global $db;
    $member_id = $db->real_escape_string($member_id);
    $result = [];

    $res = db_query("SELECT fps.id, fps.member_key, fps.absence_date, fps.date, fps.comment,
      fps.status, fps.date_send, fps.decision_date, fps.comment_extra, fps.notice,
      fp.id AS fp_id, fp.sheet_id, fp.session_id, fp.session_correction_id,
      fp.session_name, fp.session_time, fp.duration, fp.checked
      FROM ftt_permission_sheet AS fps
      INNER JOIN ftt_permission fp ON fp.sheet_id = fps.id
      WHERE  fps.member_key = '$member_id'
      ORDER BY fps.absence_date DESC");
    while ($row = $res->fetch_assoc()) $result[]=$row;

    return $result;
  }
  // получаем разрешения по списку обучающихся
  static function get_by_staff($trainee_list, $sorting)
  {
    global $db;
    $condition='';
    if ($sorting) {
      if ($sorting === 'sort_date-asc') {
        $sorting = ' fps.absence_date ASC, m.name ASC ';
      } elseif ($sorting === 'sort_date-desc') {
        $sorting = ' fps.absence_date DESC, m.name ASC ';
      } elseif ($sorting === 'sort_trainee-asc') {
        $sorting = ' m.name ASC, fps.absence_date DESC ';
      } elseif ($sorting === 'sort_trainee-desc') {
        $sorting = ' m.name DESC, fps.absence_date DESC ';
      } else {
        $sorting = ' fps.absence_date DESC, m.name DESC ';
      }
    } else {
      $sorting = ' fps.absence_date DESC, m.name DESC ';
    }

    $result=[];
    if (count($trainee_list) > 0) {
      foreach ($trainee_list as $key => $value) {
        $key = $db->real_escape_string($key);
        if (!empty($condition)) {
          $condition .= " OR ";
        }
        $condition .= " fps.member_key='$key' ";
      }
    } else {
      $condition=0;
    }

    $res = db_query("SELECT fps.id, fps.member_key, fps.absence_date, fps.date, fps.comment,
      fps.status, fps.date_send, fps.serving_one, fps.decision_date, fps.comment_extra, fps.notice,
      m.name
      FROM ftt_permission_sheet AS fps
      INNER JOIN member m ON m.key = fps.member_key
      WHERE {$condition}
      ORDER BY {$sorting}");
    while ($row = $res->fetch_assoc()) $result[]=$row;

    return $result;
  }

  static function get_by_date($date)
  {
    global $db;
    $date = $db->real_escape_string($date);
    $sheets = [];
    $result = [];

    $res = db_query("SELECT `id`, `member_key`, `absence_date`, `comment`, `status`
      FROM ftt_permission_sheet
      WHERE  `absence_date` = '$date' AND `status` = 2");
    while ($row = $res->fetch_assoc()) $sheets[]=$row;

    for ($i=0; $i < count($sheets); $i++) {
      $condition = $sheets[$i]['id'];
      $res = db_query("SELECT `id`, `sheet_id`, `session_id`, `session_correction_id`
        FROM ftt_permission
        WHERE  `sheet_id` = '{$condition}' AND `checked` = 1");
      while ($row = $res->fetch_assoc()) {
        $result[$sheets[$i]['member_key']]['sessions'][]=$row;
      }
      $result[$sheets[$i]['member_key']]['sheet']=$sheets[$i];
    }
    return $result;
  }
}
 ?>
