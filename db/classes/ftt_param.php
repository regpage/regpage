<?php
/**
 * данные из таблицы парам для ПВОМ
 * fttParam::get('field_name'); --- получить данные
 * fttParam::set('field_name', 'value'); --- записать данные
 */
class fttParam
{
  //
  static function get($field_name) {
    global $db;
    $field_name = $db->real_escape_string($field_name);
    $field_value = '';
    $res = db_query("SELECT `value` FROM `ftt_param` WHERE `name` = '$field_name'");
    while ($row = $res->fetch_assoc()) $field_value=$row['value'];

    return $field_value;
  }

  static function set($field_name, $value) {
    global $db;
    $field_name = $db->real_escape_string($field_name);
    $res = db_query("UPDATE `ftt_param` SET `value`='$value'  WHERE `name` = '$field_name'");

    return $res;
  }
}
