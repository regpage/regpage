<?php
/**
 * getCall() - получаем 1 звонок по id
 * getCalls() - получаем все звонк отсотрированные по дате добавления
 * getUsers() - список пользователей раздела Зввонки
 */

class CallsDB extends DBQuery
{
  static function getCall($id)
  {
    return parent::get('list', 'calls', '*', 'id', $id);
  }

  static function getCalls($conditionField = '', $conditionValue = '', $sortField = 'created_date', $sortType='DESC')
  {
    $conditionField = db_real_escape_string($conditionField);
    $conditionValue = db_real_escape_string($conditionValue);
    $sortField = db_real_escape_string($sortField);
    $sortType = db_real_escape_string($sortType);
    $result = [];

    if (empty($conditionField)) {
      $condition = 1;
    } else {
      $condition = "{$conditionField} = '{$conditionValue}'";
    }

    $res=db_query ("SELECT c.*, m.name operator_name
    FROM calls c
    LEFT JOIN member m ON m.key = c.operator
    WHERE {$condition} ORDER BY {$sortField} {$sortType}");
    while ($row = $res->fetch_assoc()) $result[]=$row;

    return $result;
  }

  // Часовые пояса для которых есть расписание для комбобоксов
  static function getUsers() {
    return parent::getKeyValue('calls_users');
  }

  static function saveCall($data)
  {
    $data = json_decode($data);

    if (isset($data->id)) {
      $setQuery = '';
      foreach ($data as $key => $value) {
        $key = db_real_escape_string($key);
        $value = db_real_escape_string($value);
        if ($key !== 'id') {
          if (empty($setQuery)) {
            if ($value === 'NULL') {
              $setQuery = "$key = {$value}";
            } else {
              $setQuery = "$key = '{$value}'";
            }
          } else {
            if ($value === 'NULL') {
              $setQuery .= ", $key = {$value}";
            } else {
              $setQuery .= ", $key = '{$value}'";
            }
          }
        }
      }

      $res=db_query("UPDATE calls SET {$setQuery} WHERE id='{$data->id}'");
    } else {
      $keys = '';
      $values = '';
      foreach ($data as $key => $value) {
        $key = db_real_escape_string($key);
        $value = db_real_escape_string($value);

        if (empty($keys)) {
          $keys .= $key;
          if ($value === 'NULL') {
            $values .= "{$value}";
          } else {
            $values .= "'{$value}'";
          }

        } else {
          $keys .= ", {$key}";
          if ($value === 'NULL') {
            $values .= ", {$value}";
          } else {
            $values .= ", '{$value}'";
          }
        }
      }

      $res=db_query("INSERT INTO `calls` ({$keys}) VALUES ({$values})");
    }

    return $res;
  }

  static function dltCall($id)
  {
    return parent::dlt('calls', 'id', $id);
  }
}
