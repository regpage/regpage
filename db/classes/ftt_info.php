<?php
/**
 * Информация о ПВОМ
 * Можно добавить не статичные элементы что бы хранить в переменной ? подумать
 */
 if (isset($GLOBALS['global_root_path'])) {
   include_once $GLOBALS['global_root_path'].'db/classes/date_convert.php';
 } else {
   include_once __DIR__.'/../classes/date_convert.php';
 }

class ftt_info {
  // текущая дата timestamp (без учёта текущего времени)
  static function now_mls() {
    $date_today_tmp = date('Y-m-d', time());
    return strtotime($date_today_tmp);
  }

  // данные из таблицы парам для ПВОМ
  static function param($field_name) {
    global $db;
    $name = $db->real_escape_string($field_name);
    $field_value = '';
    $res = db_query("SELECT `value` FROM ftt_param WHERE `name` = '$field_name'");
    while ($row = $res->fetch_assoc()) $field_value=$row['value'];

    return $field_value;
  }

  // Начало семестра
  static function begin() {
    return self::param('attendance_start');
  }

  // Начало семестра в секундах
  static function begin_mls() {
    return strtotime(date_convert::ddmmyyyy_to_yyyymmdd(self::param('attendance_start')));
  }

  // окончание семестра
  static function end() {
    return self::param('attendance_end');
  }

  // окончание семестра в секундах
  static function end_mls() {
    return strtotime(date_convert::ddmmyyyy_to_yyyymmdd(self::param('attendance_end')));
  }

  // Перерыв в обучении
  static function pause() {
    $date_today = self::now_mls();
    if ($date_today < strtotime(date_convert::ddmmyyyy_to_yyyymmdd(self::param('attendance_start'))) || $date_today > strtotime(date_convert::ddmmyyyy_to_yyyymmdd(self::param('attendance_end')))) {
      return 1;
    }
  }

  // Перерыв в создании бланков общения
  static function pauseForFellowship() {
    $date_today = self::now_mls();
    $start = strtotime(date_convert::ddmmyyyy_to_yyyymmdd(self::param('attendance_start'))) - 604800 * 2;
    $end = strtotime(date_convert::ddmmyyyy_to_yyyymmdd(self::param('attendance_end'))) - 604800 * 2;
    if ($date_today < $start || $date_today > $end) {
      return 1;
    }
  }

  // Дней до конца обучения / дней после окончания (отрицательное число)
  static function days_to_end() {
    $different = strtotime(date_convert::ddmmyyyy_to_yyyymmdd(self::param('attendance_end'))) - self::now_mls();
    return $different / (24*60*60);
  }

  // Дней до конца обучения / дней после окончания (отрицательное число)
  static function days_to_end_of_year() {
    if ((date('m') == 6 && date('d') > 16) || date('m') > 6){
      $yyyy = date('Y') + 1;
    } else {
      $yyyy = date('Y');
    }
    $different = strtotime($yyyy . '-06-16') - self::now_mls();
    return $different / (24*60*60);
  }
}

?>
