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
    $listTrainees = [];
    $condition = '';
    foreach ($trainees as $key => $value) {
      $value = $db->real_escape_string($value);
      $listTrainees[$key] = ['done'=>'2'];
      if (empty($condition)) {
        $condition .= "(p.member_key = '{$key}' ";
      } else {
        $condition .= " OR p.member_key = '{$key}' ";
      }
    }
    if (!empty($condition)) {
      $condition .= ')';
      /*$res = db_query("SELECT fas.prophecy, m.name, fas.status, fas.member_key
        FROM ftt_attendance_sheet AS fas
        LEFT JOIN member m ON m.key = fas.member_key
        WHERE {$condition} AND fas.date = '{$date}'
        ORDER BY m.name");*/
        $res = db_query("SELECT p.done, m.name, p.member_key, p.send_date
          FROM ftt_prophecy AS p
          LEFT JOIN member m ON m.key = p.member_key
          WHERE {$condition} AND p.date = '{$date}'
          ORDER BY m.name");
      while ($row = $res->fetch_assoc()) {
        $send = '1';
        if ($row['send_date'] === '0000-00-00 00:00:00') {
          $send = '0';
        }
        $listTrainees[$row['member_key']] = ['name' => $row['name'], 'done' => $row['done'], 'member_key' => $row['member_key'], 'send' => $send];
      }
    }

    return $listTrainees;
  }
}
