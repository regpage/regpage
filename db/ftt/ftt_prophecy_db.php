<?php
require_once 'db/classes/common/db_query.php';
/**
 * запросы для раздела пророчество
 * ProphecyDB::getListByMember($memberKey)
 * ProphecyDB::getLine($id)
 * ProphecyDB::dltLine($id)
 * ProphecyDB::setLine($id)
 */
class ProphecyDB extends DBQuery
{
  // получаем строку таблицы Пророчество по id
  static function getLine($id)
  {
    return DBQuery::get('list', 'ftt_prophecy', '*', 'id', $id);
  }
  // получаем строки таблицы Пророчество по ключу пользователя
  static function getListByMember($memberKey)
  {
    return DBQuery::get('list', 'ftt_prophecy', '*', 'member_key', $memberKey);
  }
  // получаем строки таблицы Пророчество для списка служащих
  static function getListForServingones($memberKey, $weekNumber)
  {
    $memberKey = db_real_escape_string($memberKey);
    $weekNumber = db_real_escape_string($weekNumber);
    $result = [];
    $condition = 1;
    if (!empty($memberKey) && $memberKey !== '_all_') {
      $condition = "fp.member_key = '{$memberKey}'";
    }
    if (!empty($weekNumber) && $weekNumber !== '_all_') {
      if ($condition === 1) {
        $condition = " fp.week_number = '{$weekNumber}' ";
      } else {
        $condition .= " AND fp.week_number = '{$weekNumber}' ";
      }
    }
    $res = db_query("SELECT fp.*, m.name
      FROM ftt_prophecy fp
      LEFT JOIN member m ON m.key = fp.member_key
      WHERE $condition");
    while ($row = $res->fetch_assoc()) $result[] = $row;

    return $result;
  }
  // удаляем строку таблицы Пророчество по id
  static function dltLine($id)
  {
    return DBQuery::dlt('ftt_prophecy', 'id', $id);
  }
  // удаляем строку таблицы Пророчество по id
  static function setChecked($data)
  {
    foreach ($data as $key => $value) {
      $data->$key = db_real_escape_string($value);
    }
    return DBQuery::set('ftt_prophecy', 'checked', $data->checked, 'id', $data->id);
  }
  // записываем новую / обновляем существующую строку
  static function setLine($data)
  {
    $keysTextQuery = '';
    $valuesTextQuery = '';
    $new = empty($data->id);
    foreach ($data as $key => $value) {
      $data->$key = db_real_escape_string($value);
      if ($new) { // вставка новой строки
        if ($key === 'id') {
          continue;
        }
        if (empty($keysTextQuery)) {
          $keysTextQuery = "`" . db_real_escape_string($key) . "`";
          $valuesTextQuery = "'{$data->$key}'";
        } else {
          $keysTextQuery .= ",`" . db_real_escape_string($key) . "`";
          $valuesTextQuery .= ",'{$data->$key}'";
        }
      } else { //  обновление существующей строки
        if ($key !== 'id') {
          if (empty($valuesTextQuery)) {
            $valuesTextQuery .=  "`" . db_real_escape_string($key) . "` = '{$data->$key}'";
          } else {
            $valuesTextQuery .=  ",`" . db_real_escape_string($key) . "` = '{$data->$key}'";
          }
        }
      }
    }

    /*$data->id = db_real_escape_string($data->id);
    $data->member_key = db_real_escape_string($data->member_key);
    $data->date = db_real_escape_string($data->date);
    $data->prophecy = db_real_escape_string($data->prophecy);*/
    if (empty($data->id)) {
      return db_query("INSERT INTO `ftt_prophecy` ({$keysTextQuery}) VALUES ({$valuesTextQuery})");
    } else {
      return db_query("UPDATE `ftt_prophecy` SET {$valuesTextQuery} WHERE  `id` = '{$data->id}'");
    }
  }
  /*
  static function getList($memberKey)
  {
    return DBQuery::get('list', 'ftt_prophecy', '*', 'member_key', $memberKey);
  }
  */
  // создание бланка при загрузке файла если бланк не существует
  static function setLineGetId($data)
  {
    global $db;
    foreach ($data as $key => $value) {
      $data->$key = db_real_escape_string($value);
    }
    $res = db_query("INSERT INTO `ftt_prophecy` (`date`, `member_key`) VALUES ('{$data->date}', '{$data->member_key}')");
    if ($res) {
      return $db->insert_id;
    } else {
      return "ERROR: NO ID";
    }
  }
}
