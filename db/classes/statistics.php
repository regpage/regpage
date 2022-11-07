<?php
/**  Статистики
*  statistics::extra_help_count($memberId) - Количество активных допзаданий
*  statistics::extra_help_count($memberId, true) - поимённый список активных допзаданий
*  Разрешения колво активных
**/
class statistics {
  // Количество активных допзаданий
  static function extra_help_count ($memberId, $statistic = false)
  {
    global $db;
    $result = '';
    $trainee = false;
    $condition = '';
    if (is_array($memberId)) {
      if (count($memberId) > 0) {
        foreach ($memberId as $key => $value) {
          $key = $db->real_escape_string($key);
          if (!empty($condition)) {
            $condition .= " OR ";
          }
          if ($statistic) {
            $condition .= " (feh.member_key='$key' AND feh.archive=0) ";
          } else {
            $condition .= " (`member_key`='$key' AND `archive`=0) ";
          }
        }
      } else {
        $condition=0;
      }
    } else {
      $trainee = true;
      $memberId = $db->real_escape_string($memberId);
    }

    if ($trainee) {
      $res = db_query("SELECT COUNT(`id`) AS total FROM ftt_extra_help WHERE `member_key`= '$memberId' AND `archive`=0");
      while ($row = $res->fetch_assoc()) $result = $row['total'];
    } else {
      if ($statistic) {
        $result = ['count' => 0];
        $res = db_query("SELECT feh.id, feh.member_key, m.name
          FROM ftt_extra_help AS feh
          INNER JOIN member m ON m.key = feh.member_key
          WHERE {$condition} ORDER BY m.name");
        while ($row = $res->fetch_assoc()) {
          if (isset($result[$row['member_key']])) {
            $result[$row['member_key']]++;
          } else {
            $result[$row['member_key']] = 1;
          }
          $result['count']++;
        }
      } else {
        $res = db_query("SELECT COUNT(`id`) AS total FROM ftt_extra_help WHERE {$condition}");
        while ($row = $res->fetch_assoc()) $result = $row['total'];
      }
    }
    return $result;
  }

  // Разрешения
  static function permission_count ($memberId)
  {
    global $db;
    $condition = '';
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
  static function announcement_unread($memberId)
  {
    $result = '';
    $res = db_query("SELECT COUNT(far.id_announcement) AS total
    FROM ftt_announcement_recipients AS far
    INNER JOIN ftt_announcement fa ON fa.id = far.id_announcement
    WHERE far.member_key = '$memberId' AND far.date IS NULL AND fa.date <= DATE(NOW())");
    while ($row = $res->fetch_assoc()) $result = $row['total'];
    return $result;
  }
}


?>
