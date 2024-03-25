<?php
/**
 * Пророчествование в воскресенье
 * by_serving_one() получить данные за прошедшее воскресение по служащему
 *
 *
 */

class Prophecy
{
  static function by_serving_one($trainees, $date)
  {
    global $db;
    $result=[];

    $condition = '';
    foreach ($trainees as $key => $value) {
      $value = $db->real_escape_string($value);
      if (empty($condition)) {
        $condition .= "(fas.member_key = '{$key}' ";
      } else {
        $condition .= " OR fas.member_key = '{$key}' ";
      }
    }
    if (!empty($condition)) {
      $condition .= ')';
      $res = db_query("SELECT fas.prophecy, m.name, fas.status
        FROM ftt_attendance_sheet AS fas
        LEFT JOIN member m ON m.key = fas.member_key
        WHERE {$condition} AND fas.date = '{$date}'
        ORDER BY m.name");
      while ($row = $res->fetch_assoc()) $result[] = ['name' => $row['name'], 'prophecy' => $row['prophecy'], 'status' => $row['status']];
    }

    return $result;
  }
}
