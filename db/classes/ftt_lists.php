<?php
if (isset($GLOBALS['global_root_path'])) {
  include_once $GLOBALS['global_root_path'].'db/classes/short_name.php';
} else {
  include_once __DIR__.'/../classes/short_name.php';
}

/**
 * Списки
 * Все Служащие
 * Все обучающиеся
 * Обучающиеся по служащему
 */

class ftt_lists {
  // получаем служащих
  static function serving_ones()  {
    $result = [];

    $res = db_query("SELECT fso.member_key, m.key, m.name
      FROM ftt_serving_one fso
      INNER JOIN member m ON m.key = fso.member_key
      WHERE 1 ORDER BY m.name");
      while ($row = $res->fetch_assoc()) $result[$row['key']]=short_name::no_middle($row['name']);

      return $result;
  }
  // братья
  static function serving_ones_brothers()  {
    $result = [];

    $res = db_query("SELECT fso.member_key, m.key, m.name, m.male
      FROM ftt_serving_one fso
      INNER JOIN member m ON m.key = fso.member_key
      WHERE m.male = 1 ORDER BY m.name");
      while ($row = $res->fetch_assoc()) $result[$row['key']]=short_name::no_middle($row['name']);

      return $result;
  }

  static function serving_ones_full()  {
    $result = [];

    $res = db_query("SELECT fso.member_key, fso.gospel_team, m.key, m.name, m.male
      FROM ftt_serving_one fso
      INNER JOIN member m ON m.key = fso.member_key
      WHERE 1");
      while ($row = $res->fetch_assoc()) $result[$row['key']]=[short_name::no_middle($row['name']), $row['male'], $row['gospel_team']];

      return $result;
  }

  static function serving_ones_list()  {
    $result = [];

    $res = db_query("SELECT fso.member_key, fso.time_zone, fso.gospel_team, m.new_locality,
      m.name, m.male, m.locality_key, m.birth_date, m.cell_phone, m.email, m.attend_meeting, m.changed,
      l.name AS locality_name
      FROM ftt_serving_one fso
      INNER JOIN member m ON m.key = fso.member_key
      LEFT JOIN locality l ON l.key = m.locality_key
      WHERE 1
      ORDER BY m.name");
      while ($row = $res->fetch_assoc()) $result[$row['member_key']]=$row;

      return $result;
  }

  // получаем обучающихся
  static function trainee()  {
    $result = [];

    $res = db_query("SELECT ft.member_key, m.key, m.name
      FROM ftt_trainee ft
      INNER JOIN member m ON m.key = ft.member_key
      WHERE 1 ORDER BY m.name");
      while ($row = $res->fetch_assoc()) $result[$row['key']]=short_name::no_middle($row['name']);

      return $result;
  }
  static function trainee_full()  {
    $result = [];

    $res = db_query("SELECT ft.member_key, ft.gospel_group, ft.gospel_team, ft.semester, m.key, m.name, m.male, ft.time_zone
      FROM ftt_trainee ft
      INNER JOIN member m ON m.key = ft.member_key
      WHERE 1 ORDER BY m.name");
      while ($row = $res->fetch_assoc()) $result[$row['key']]=[short_name::no_middle($row['name']), $row['male'], $row['gospel_group'], $row['gospel_team'], $row['semester'], $row['time_zone']];

      return $result;
  }
  static function trainee_list()  {
    $result = [];
    //  left & right join LOCALITY NAME ect
    $res = db_query("SELECT ft.member_key, ft.gospel_group, ft.gospel_team,
      ft.semester, ft.serving_one, ft.coordinator, ft.time_zone, ft.apartment,
      m.name, m.male, m.locality_key, m.birth_date, m.cell_phone, m.email,
      m.attend_meeting, m.category_key, m.changed, m.new_locality,
      l.name AS locality_name
      FROM ftt_trainee ft
      INNER JOIN member m ON m.key = ft.member_key
      LEFT JOIN locality l ON l.key = m.locality_key
      WHERE 1
      ORDER BY m.name");
      while ($row = $res->fetch_assoc()) $result[$row['member_key']]=$row;

      return $result;
  }

  // получаем обучающихся по админу
  static function get_trainees_by_staff($serving_one_id) {

    $result = [];
    if (empty($serving_one_id)) {
      return $result;
    }

    global $db;
    $serving_one_id = $db->real_escape_string($serving_one_id);
    $condition;
    if ($serving_one_id === "_all_") {
      $condition = "1";
    } else {
      $condition = "tra.serving_one='$serving_one_id'";
    }

    $res = db_query("SELECT tra.member_key, tra.serving_one, m.name
      FROM ftt_trainee AS tra
      INNER JOIN member m ON m.key = tra.member_key
      WHERE {$condition} ORDER BY m.name");
    while ($row = $res->fetch_assoc()) $result[$row['member_key']] = short_name::no_middle($row['name']);
    return $result;
  }
}

 ?>
