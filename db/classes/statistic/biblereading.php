<?php

/**
 *
 */
global $bible_obj;
$bible_obj = new Bible;
class BibleReading
{

  static function get($traineeId)
  {
    global $db;
    $traineeId = $db->real_escape_string($traineeId);
    $result = [];
    $res2 = db_query("SELECT `date`, `bible_book`, `bible_chapter`
      FROM `ftt_attendance_sheet`
      WHERE `member_key` = '$traineeId'
      ORDER BY `date`");
    while ($row = $res2->fetch_assoc()) $result[$row['date']] = [$row['bible_book'], $row['bible_chapter']];
    return $result;
  }

  static function get_books($traineeId)
  {
    global $db;
    $traineeId = $db->real_escape_string($traineeId);
    $result = [];
    $res2 = db_query("SELECT DISTINCT `bible_book`
      FROM `ftt_attendance_sheet`
      WHERE `member_key` = '$traineeId'
      ORDER BY `date`");
    while ($row = $res2->fetch_assoc()) $result[] = $row['bible_book'];
    return $result;
  }

  static function get_readed($traineeId)
  {
    global $db;
    $traineeId = $db->real_escape_string($traineeId);
    $readed = self::get($traineeId);
    global $bible_obj;
    $bible_books = $bible_obj->get();

    $result1 = [];
    $result2 = [];
    $result3 = [];
    foreach ($readed as $value) {
      foreach ($bible_books as $key => $value_bible) {
        if ($value[0] === $value_bible[0]) {
          $percent = $value[1] / $value_bible[1] * 100;
          //$result[$key]=[$value[0], $value[1], $percent];
          $result1[$key] = $value[0];
          $result2[$key] = $value[1];
          $result3[$key] = $percent;
        }
      }
    }
    $result = [$result1,$result2,$result3];
    return $result;
  }

  static function get_by_dates($traineeId)
  {
    global $db;
    $traineeId = $db->real_escape_string($traineeId);
    $readed = self::get($traineeId);
    global $bible_obj;
    $bible_books = $bible_obj->get();

    $result1 = [];
    $result2 = [];
    $result3 = [];
    $result4 = [];
    foreach ($readed as $key => $value) {

      foreach ($bible_books as $key_bible => $value_bible) {
        if ($value[0] === $value_bible[0]) {
          if (isset($result3[$key_bible]) && !empty($result3[$key_bible])) {
            $temp = explode('—', $result4[$key_bible]);
            if (isset($temp[1])) {
              $dates = $temp[0] . '—' . date_convert::yyyymmdd_to_ddmm($key);
            } else {
              $dates = $result4[$key_bible] . '—' . date_convert::yyyymmdd_to_ddmm($key);
            }
          } else {
            $dates = date_convert::yyyymmdd_to_ddmm($key);
          }

          $percent = $value[1] / $value_bible[1] * 100;
          //$result[$key]=[$value[0], $value[1], $percent];
          $result1[$key_bible] = $value[0];
          $result2[$key_bible] = $value[1];
          $result3[$key_bible] = $percent;
          $result4[$key_bible] = $dates;
        }
      }
    }
    $result = [$result1,$result2,$result3, $result4];
    return $result;
  }

}

?>
