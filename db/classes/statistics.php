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


  // статистика по благовестию, команда.
  static function gospelTeamReport($memberId, $period=7)
  {
    global $db;
    $memberId = $db->real_escape_string($memberId);
    $period = $db->real_escape_string($period);
    $team = '';
    $blanks = [];
    if ($period === '_all_') {
      $condition = '';
    } else {
      $condition = " AND `date` >= CURDATE() - INTERVAL {$period} DAY AND `date` != CURDATE() ";
    }
    $res = db_query("SELECT `gospel_team` FROM `ftt_serving_one` WHERE `member_key`='$memberId'");
    while ($row = $res->fetch_assoc()) $team = $row['gospel_team'];
    if ($team) {
      $res = db_query("SELECT * FROM `ftt_gospel` WHERE `gospel_team`='$team' {$condition} ORDER BY `gospel_group`");
      while ($row = $res->fetch_assoc()) $blanks[] = $row;
    }

    return $blanks;

  }
  // личная статистика по благовестию
  static function gospelPersonalSeven($memberId, $period=7)
  {
    global $db;
    $period = $db->real_escape_string($period);
    $result = [];
    $and = '';
    $conditionBlanks = '';
    if (is_array($memberId)) {
      if (count($memberId) > 0) {
        $count = 0;
        foreach ($memberId as $key => $value) {
          if ($count == 0) {
            $count++;
            $conditionBlanks = " (fgm.member_key = '{$key}' ";
          } else {
            $conditionBlanks .= " OR fgm.member_key = '{$key}' ";
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

    $res = db_query("SELECT fgm.*, m.name FROM ftt_gospel_members AS fgm
      INNER JOIN ftt_gospel fg ON fgm.blank_id = fg.id
      LEFT JOIN member m ON fgm.member_key = m.key
      WHERE fg.date >= CURDATE() - INTERVAL {$period} DAY AND fg.date != CURDATE() {$and} {$conditionBlanks}");
      while ($row = $res->fetch_assoc()) $result[] = $row;

      return $result;
  }

}


?>
