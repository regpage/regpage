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

  static function extra_help_data ($memberId)
  {
    global $db;
    //$memberId = $db->real_escape_string($memberId);
    $result = [];
    $condition = '';
    if (is_array($memberId)) {
      if (count($memberId) > 0) {
        foreach ($memberId as $key => $value) {
          $key = $db->real_escape_string($key);
          $res = db_query("SELECT COUNT(`id`) AS total FROM `ftt_extra_help` WHERE `member_key`='$key' AND `archive`=0");
          while ($row = $res->fetch_assoc()) $row['total'] ? $result[$key] = $row['total'] : '';
        }
      } else {
        return $result;
      }
    } else {
      return $result;
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

  static function permissions_data ($memberId)
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

    $result = [];
    if ($trainee) {
      $res = db_query("SELECT * FROM ftt_permission_sheet WHERE `member_key`= '$memberId' AND `notice`=1");
      while ($row = $res->fetch_assoc()) $result[] = $row;

    } else {
      $res = db_query("SELECT * FROM ftt_permission_sheet WHERE $condition");
      while ($row = $res->fetch_assoc()) $result[] = $row;
    }

    return $result;
  }

  // Объявления
  static function announcement_unread($memberId)
  {
    global $db;
    $memberId = $db->real_escape_string($memberId);
    $result = '';
    $res = db_query("SELECT COUNT(far.id_announcement) AS total
    FROM ftt_announcement_recipients AS far
    INNER JOIN ftt_announcement fa ON fa.id = far.id_announcement
    WHERE far.member_key = '$memberId' AND far.date IS NULL AND fa.date <= DATE(NOW())");
    while ($row = $res->fetch_assoc()) $result = $row['total'];
    return $result;
  }

  static function announcement_unread_data($memberId)
  {
    global $db;
    $memberId = $db->real_escape_string($memberId);
    $result = [];
    $res = db_query("SELECT far.id_announcement, far.date AS far_date, far.member_key AS far_member_key, fa.*
    FROM ftt_announcement_recipients AS far
    INNER JOIN ftt_announcement fa ON fa.id = far.id_announcement
    WHERE far.member_key = '$memberId' AND far.date IS NULL AND fa.date <= DATE(NOW())");
    while ($row = $res->fetch_assoc()) $result[] = $row;
    return $result;
  }

  // посещаемость
  static function attendanceFour($memberId)
  {
    global $db;
    $result = [];
    if (is_array($memberId)) {
      if (count($memberId) > 0) {
        foreach ($memberId as $key => $value) {
          $key = $db->real_escape_string($key);
          //`date` >= CURDATE() - INTERVAL 4 DAY `date` != CURDATE() AND DATE_ADD(DATE(NOW()), INTERVAL -4 DAY)
          $condition = " `member_key`='$key' AND `status`= 0 AND `date` <= CURDATE() - INTERVAL 4 DAY";
          $res = db_query("SELECT DISTINCT `date` FROM ftt_attendance_sheet WHERE {$condition} ORDER BY `date` DESC");
          while ($row = $res->fetch_assoc()) $result[$key] = $row['date'];
        }
      } else {
        $condition=0;
      }
    }

    return $result;
  }

  // бланки отчёта благовестия за неделю
  static function gospelBlanksPeriod($day=7)
  {
    global $db;
    $day = $db->real_escape_string($day);
    $result = [];

    foreach ($memberId as $key => $value) {
      $condition = " `date` >= CURDATE() - INTERVAL {$day} DAY AND `date` != CURDATE()";
      $res = db_query("SELECT `id` FROM `ftt_gospel` WHERE {$condition}");
      while ($row = $res->fetch_assoc()) $result[] = $row['id'];
    }

    return $result;
  }

  // личная статистика по благовестию
  static function gospelPersonal($memberId)
  {
    global $db;
    $blanksId = self::gospelBlanksPeriod();
    $result = [];
    $conditionBlanks = '';
    $and = '';
    if (is_array($blanksId)) {
      if (count($blanksId) > 0) {
        foreach ($blanksId as $key => $value) {
          if ($key == 0) {
            $conditionBlanks = " (`blank_id` = '{$value}' ";
          } else {
            $conditionBlanks .= " OR `blank_id` = '{$value}' ";
          }
        }
      }
    }
    if ($conditionBlanks) {
      $and = ' AND ';
      $conditionBlanks .= ')';
    }

    if (is_array($memberId)) {
      if (count($memberId) > 0) {
        foreach ($memberId as $key => $value) {
          $key = $db->real_escape_string($key);
          $condition = " `member_key`='$key' AND `date` >= NOW() - INTERVAL 14 DAY AND `date` != CURDATE()";
          $res = db_query("SELECT * FROM `ftt_gospel_members` WHERE {$condition} {$and} {$conditionBlanks}");
          while ($row = $res->fetch_assoc()) $result[] = $row;
        }
      } else {
        $condition=0;
      }
    }
    return $result;
  }

  // ВАРИАНТ личная статистика по благовестию
  static function gospelPersonalSeven($memberId)
  {
    global $db;
    $result = [];
    $and = '';
    $conditionBlanks = '';
    if (is_array($memberId)) {
      if (count($memberId) > 0) {
        foreach ($memberId as $key => $value) {
          if ($key == 0) {
            $conditionBlanks = " (fgm.member_key = '{$value}' ";
          } else {
            $conditionBlanks .= " OR fgm.member_key = '{$value}' ";
          }
        }
      } else {
        return $result;
      }
    } else {
      return $result;
    }
    if ($conditionBlanks) {
      $and = ' AND ';
      $conditionBlanks .= ')';
    }

    $res = db_query("SELECT fgm.*
      FROM `ftt_gospel_members` AS fgm
      INNER JOIN ftt_gospel fg ON fg.id = fgm.blank_id
      WHERE fg.date >= CURDATE() - INTERVAL 7 DAY AND fg.date != CURDATE() {$and} {$conditionBlanks}");
      while ($row = $res->fetch_assoc()) $result[] = $row;

      return $result;
  }

}


?>
