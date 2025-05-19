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
  // удаляем строку таблицы Пророчество по id
  static function dltLine($id)
  {
    return DBQuery::dlt('ftt_prophecy', 'id', $id);
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
  static function setLineGetId()
  {
    global $db;
    $res = db_query("INSERT INTO `ftt_prophecy` (`file`) VALUES ('')");
    if ($res) {
      return $db->insert_id;
    } else {
      return "ERROR: NO ID";
    }
  }
}
