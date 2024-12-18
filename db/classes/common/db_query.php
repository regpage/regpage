<?php
/**
 * класс DBQuery однотабличный запрос к базе данных одного поля с одиним условием, доп условие дописывается в пареметр $fieldCondition напр. 'type = '1' AND name'
 * возвращает массив или строку
 * условия по умолчанию возвратят все строки таблицы (WHERE 1)
 * по умолчанию в условии используется "=", возможно передать иное в параметре $equal='='
 * сортировка не реализована
 * ПАРАМЕТРЫ:
 * str $type 'str'/ any метод вернёт строку / массив
 * str $table имя запрашиваемой таблицы
 * str $field имя возвращаемого столбца
 * str $fieldCondition='' имя столбца для условия выборки по умолчанию пустая строка (вернёт весь набор значений WHERE 1)
 * str $valueCondition='' значение для условия выборки по умолчанию пустая строка
 * str $equal='=' знак для сравнения (напр LIKE, >, < и тп) по умолчанию "="
 * str $sort='' поле для сортировки и направление напр. "name DESC"
 */
class DBQuery
{
  static function get($type, $table, $field, $fieldCondition='', $valueCondition='', $equal='=', $sort='', $desc=false)
  {
    $type = db_real_escape_string($type);
    $table = db_real_escape_string($table);
    $field = db_real_escape_string($field);
    $fieldCondition = db_real_escape_string($fieldCondition);
    $valueCondition = db_real_escape_string($valueCondition);
    $equal = db_real_escape_string($equal);
    $sort = db_real_escape_string($sort);

    if (!empty($fieldCondition)) {
      $fieldCondition = " `{$fieldCondition}` {$equal} '{$valueCondition}' ";
    } else {
      $fieldCondition = 1;
    }

    if (!empty($sort)) {
      $sort = " ORDER BY `{$sort}`";
      if ($desc) {
        $sort .= " DESC";
      }
    }

    $res=db_query ("SELECT {$field} FROM {$table} WHERE {$fieldCondition} {$sort}");
    if ($type === 'str') {
      $result = '';
      while ($row = $res->fetch_assoc()) $result=$row[$field];
    } elseif ($type === 'list') {
      $result = [];
      while ($row = $res->fetch_assoc()) $result[]=$row;
    } else {
      $result = [];
      while ($row = $res->fetch_assoc()) $result[]=$row[$field];
    }

    return $result;
  }
  static function getKeyValue($table) {
    $table = db_real_escape_string($table);
    $result = [];
    $res = db_query("SELECT m.key, m.name
      FROM {$table} tb
      INNER JOIN member m ON m.key = tb.member_key
      ORDER BY m.name");
    while ($row = $res->fetch_assoc()) $result[$row['key']] = short_name::no_middle($row['name']);

    return $result;
  }
  static function dlt($table, $field, $value) {
    $table = db_real_escape_string($table);
    $field = db_real_escape_string($field);
    $value = db_real_escape_string($value);

    $res = db_query("DELETE FROM {$table} WHERE {$field} = '{$value}'");

    return $res;
  }

  static function set($table, $field, $value, $condition_field, $condition_value)
  {
    // {$changed_field}{$equal}{$changed}
    $table = db_real_escape_string($table);
    $field = db_real_escape_string($field);
    $value = db_real_escape_string($value);
    $condition_field = db_real_escape_string($condition_field);
    $condition_value = db_real_escape_string($condition_value);

    $res = db_query("UPDATE `{$table}` SET `{$field}` = '{$value}'  WHERE `{$condition_field}` = '{$condition_value}'");

    return $res;
  }
}
