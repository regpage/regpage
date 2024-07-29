<?php
/**
 *
 */
class DBQuery
{
  static function get($result, $table, $field, $fieldCondition='', $valueCondition='', $equal='=')
  {
    $str = db_real_escape_string($str);
    $table = db_real_escape_string($table);
    $field = db_real_escape_string($field);
    $fieldCondition = db_real_escape_string($fieldCondition);
    $valueCondition = db_real_escape_string($valueCondition);

    if (!empty($fieldCondition)) {
      $fieldCondition = " `{$fieldCondition}` {$equal} '{$valueCondition}' ";
    } else {
      $fieldCondition = 1;
    }

    $res=db_query ("SELECT {$field} FROM {$table} WHERE {$fieldCondition}");
    if ($result === 'str') {
      $result = '';
      while ($row = $res->fetch_assoc()) $result=$row[$field];
    } else {
      $result = [];
      while ($row = $res->fetch_assoc()) $result[]=$row[$field];
    }

    return $result;
  }
}
