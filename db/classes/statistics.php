<?php
/**  Статистики
*  statistics::extra_help_count($memberId) - Количество активных допзаданий
*
**/
class statistics {
  //Количество активных допзаданий
  static function extra_help_count ($memberId) {
    global $db;
    $memberId = $db->real_escape_string($memberId);
    $result = '';
    $res = db_query("SELECT COUNT(`id`) AS total FROM ftt_extra_help WHERE `member_key`= '$memberId' AND `archive`=0");
    while ($row = $res->fetch_assoc()) $result = $row['total'];
    return $result;
  }

  static function permission_count ($memberId) {
    global $db;
    $condition;
    $trainee = false;
    if (is_array($memberId)) {
      if (count($memberId) > 0) {
        foreach ($memberId as $key => $value) {
          $key = $db->real_escape_string($key);
          if (!empty($condition)) {
            $condition .= " OR ";
          }
          $condition .= " (`member_key`='$key' AND `status`=1) ";
        }
      } else {
        $condition=0;
      }
    } else {
      $trainee = true;
      $memberId = $db->real_escape_string($memberId);
    }

    $result = '';
    if ($trainee) {
      $res = db_query("SELECT COUNT(`id`) AS total FROM ftt_permission_sheet WHERE `member_key`= '$memberId' AND `notice`=1");
      while ($row = $res->fetch_assoc()) $result = $row['total'];

    } else {
      $res = db_query("SELECT COUNT(`id`) AS total FROM ftt_permission_sheet WHERE $condition");
      while ($row = $res->fetch_assoc()) $result = $row['total'];
    }

    return $result;
  }
}


?>
