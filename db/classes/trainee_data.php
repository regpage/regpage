<?php
/**
 * It's trainee's data
 * Получать все данные об обучающемся из таблицы ftt_trainee
 * Дополнительно
 **/
class trainee_data {
  // properties

  // Данные обучающегося
  static function get_data($member_key){
    global $db;
    $member_key = $db->real_escape_string($member_key);
    $result = [];
    $res = db_query("SELECT ft.member_key, ft.semester,	ft.gospel_team,	ft.gospel_group, ft.apartment, ft.coordinator,
       ft.study_group, ft.participation_type, ft.serving_one, ft.time_zone AS ft_time_zone,
       tz.id AS tz_id, tz.name AS tz_name_zone, tz.utc
      FROM ftt_trainee ft
      INNER JOIN time_zone tz ON tz.id = ft.time_zone
      WHERE ft.member_key = '$member_key'");
    while ($row = $res->fetch_assoc()) $result = $row;

    // устанавливаем semester_range
    if ($result['semester'] > 0 && $result['semester'] < 5) {
      $result['semester_range'] = '1';
    } elseif ($result['semester'] > 4 ) {
      $result['semester_range'] = '2';
    }
      return $result;
  }

   static function get_serving_one ($member_key) {
     global $db;
     $member_key = $db->real_escape_string($member_key);
     $result = '';
     $res = db_query("SELECT `serving_one` FROM ftt_trainee WHERE `member_key`= '$member_key'");
     while ($row = $res->fetch_assoc()) $result = $row['serving_one'];

     return $result;
  }
}

 ?>
