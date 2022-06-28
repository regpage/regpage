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

  // Дней до конца обучения / дней после окончания (отрицательное число)
  static function days_to_end() {
    $different = strtotime(date_convert::ddmmyyyy_to_yyyymmdd(self::param('attendance_end'))) - self::now_mls();
    return $different / (24*60*60);
  }
}

?>
