<?php
/**
 * Статистика, те кто посещают собрания в церковной жизни
 */
class AttendanceStatistic
{
  // кроме тех, что посещают только видеообучение
  /*static function getMemberAtMeetingsOLD($membersKeys)
  {
    global $db;
    // убрать экран с используемых ковычек или разбить и собрать строку заново (тогда удалить добавление кавычек в js)
    //$condition = $db->real_escape_string($membersKeys);

    $statistic = array('12_17' => 0, '18_25' => 0, '26_60' => 0, 'older_60' => 0, 'average_age' => 0);

    $res=db_query ("SELECT a.attend_meeting meeting, a.attend_pm pm, a.attend_gm gm, a.attend_am am,
      mem.category_key category, DATEDIFF(CURRENT_DATE, STR_TO_DATE(mem.birth_date, '%Y-%m-%d'))/365 as age
      FROM attendance a
      LEFT JOIN member mem ON mem.key = a.member_key
      WHERE a.member_key IN ({$membersKeys}) AND (a.attend_meeting = 1 OR a.attend_pm = 1  OR a.attend_gm = 1  OR a.attend_am = 1)
      UNION
      SELECT m.attend_meeting meeting, 0 pm, 0 gm, 0 am,
      m.category_key category, DATEDIFF(CURRENT_DATE, STR_TO_DATE(m.birth_date, '%Y-%m-%d'))/365 as age
      FROM member m
      WHERE m.key IN ({$membersKeys}) AND m.attend_meeting = 1
      ");
    while ($row = $res->fetch_assoc()) {

      if (isset($statistic[$row['category']])) {
        $statistic[$row['category']]++;
      } else {
        $statistic[$row['category']]=1;
      }
      if (!empty($row['age']) && $row['age'] > 0) {
        $statistic['average_age'] += $row['age'];
      }
      if ($row['age'] >= 12 AND $row['age'] <= 17) {
        $statistic['12_17']++;
      } elseif ($row['age'] >= 18 AND $row['age'] <= 25) {
        $statistic['18_25']++;
      } elseif ($row['age'] >= 26 AND $row['age'] <= 60) {
        $statistic['26_60']++;
      } elseif ($row['age'] > 60) {
        $statistic['older_60']++;
      }
    }

    return $statistic;
  }

  // LT statistics
  static function getMemberAtLT($membersKeys)
  {
    global $db;
    // убрать экран с используемых ковычек или разбить и собрать строку заново (тогда удалить добавление кавычек в js)
    //$condition = $db->real_escape_string($membersKeys);

    $statistic = array('12_17' => 0, '18_25' => 0, '26_60' => 0, 'older_60' => 0, 'average_age' => 0);

    $res=db_query ("SELECT a.attend_meeting meeting,
      mem.category_key category, DATEDIFF(CURRENT_DATE, STR_TO_DATE(mem.birth_date, '%Y-%m-%d'))/365 as age
      FROM attendance a
      LEFT JOIN member mem ON mem.key = a.member_key
      WHERE a.member_key IN ({$membersKeys}) AND a.attend_meeting = 1
      UNION
      SELECT m.attend_meeting meeting,
      m.category_key category, DATEDIFF(CURRENT_DATE, STR_TO_DATE(m.birth_date, '%Y-%m-%d'))/365 as age
      FROM member m
      WHERE m.key IN ({$membersKeys}) AND m.attend_meeting = 1
      ");
    while ($row = $res->fetch_assoc()) {

      if (isset($statistic[$row['category']])) {
        $statistic[$row['category']]++;
      } else {
        $statistic[$row['category']]=1;
      }
      if (!empty($row['age']) && $row['age'] > 0) {
        $statistic['average_age'] += $row['age'];
      }
      if ($row['age'] >= 12 AND $row['age'] <= 17) {
        $statistic['12_17']++;
      } elseif ($row['age'] >= 18 AND $row['age'] <= 25) {
        $statistic['18_25']++;
      } elseif ($row['age'] >= 26 AND $row['age'] <= 60) {
        $statistic['26_60']++;
      } elseif ($row['age'] > 60) {
        $statistic['older_60']++;
      }
    }

    return $statistic;
  }*/

  // Статистика посещаемости
  static function getMemberAtMeetings($membersKeys)
  {
    global $db;
    // убрать экран с используемых ковычек или разбить и собрать строку заново (тогда удалить добавление кавычек в js)
    //$condition = $db->real_escape_string($membersKeys);

    $statistic = array('12_17' => 0, '18_25' => 0, '26_60' => 0, 'older_60' => 0, 'average_age' => 0); // 'younger_12' => 0

    $res=db_query ("SELECT mem.attend_meeting, a.attend_meeting meeting, a.attend_pm pm, a.attend_gm gm, a.attend_am am,
      mem.category_key category, DATEDIFF(CURRENT_DATE, STR_TO_DATE(mem.birth_date, '%Y-%m-%d'))/365 as age
      FROM member mem
      LEFT JOIN attendance a ON a.member_key = mem.key
      WHERE mem.key IN ({$membersKeys}) AND (mem.attend_meeting = 1 OR a.attend_meeting = 1 OR a.attend_pm = 1 OR a.attend_gm = 1 OR a.attend_am = 1) AND mem.active = 1
      ");
    while ($row = $res->fetch_assoc()) {

      if (isset($statistic[$row['category']])) {
        $statistic[$row['category']]++;
      } else {
        $statistic[$row['category']]=1;
      }
      if (!empty($row['age']) && $row['age'] > 0) {
        $statistic['average_age'] += $row['age'];
      }
      if ($row['age'] >= 12 AND $row['age'] <= 17) {
        $statistic['12_17']++;
      } elseif ($row['age'] >= 18 AND $row['age'] <= 25) {
        $statistic['18_25']++;
      } elseif ($row['age'] >= 26 AND $row['age'] <= 60) {
        $statistic['26_60']++;
      } elseif ($row['age'] > 60) {
        $statistic['older_60']++;
      } /*elseif ($row['age'] >= 0 AND $row['age'] <= 11) {
        $statistic['younger_12']++;
      }*/
    }

    return $statistic;
  }
}
