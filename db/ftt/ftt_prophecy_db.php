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
  static function getLine($id)
  {
    return DBQuery::get('list', 'ftt_prophecy', '*', 'id', $id);
  }
  static function getListByMember($memberKey)
  {
    return DBQuery::get('list', 'ftt_prophecy', '*', 'member_key', $memberKey);
  }
  static function dltLine($id)
  {
    return DBQuery::dlt('ftt_prophecy', 'id', $id);
  }
  static function setLine($data)
  {
    $data->id = db_real_escape_string($data->id);
    $data->member_key = db_real_escape_string($data->member_key);
    $data->date = db_real_escape_string($data->date);
    $data->prophecy = db_real_escape_string($data->prophecy);
    if (empty($data->id)) {
      return db_query("INSERT INTO `ftt_prophecy` (`member_key`, `date`, `prophecy`) VALUES ('{$data->member_key}', '{$data->date}', '{$data->prophecy}')");
    } else {
      return db_query("UPDATE `ftt_prophecy` SET `member_key` = '{$data->member_key}', `date` = '{$data->date}', `prophecy` = '{$data->prophecy}' WHERE  `id` = '{$data->id}'");
    }
  }
  /*
  static function getList($memberKey)
  {
    return DBQuery::get('list', 'ftt_prophecy', '*', 'member_key', $memberKey);
  }
  */
}
