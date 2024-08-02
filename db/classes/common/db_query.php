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

    $res=db_query ("SELECT `{$field}` FROM {$table} WHERE {$fieldCondition} {$sort}");
    if ($type === 'str') {
      $result = '';
      while ($row = $res->fetch_assoc()) $result=$row[$field];
    } else {
      $result = [];
      while ($row = $res->fetch_assoc()) $result[]=$row[$field];
    }

    return $result;
  }
}
