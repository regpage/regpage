<?php
// инфо для экранов на ПВОМ
require_once 'db/classes/common/db_query.php';
/**
 *
 */
class fttInfoboard extends DBQuery
{

  function getToday() {
    $result = [];
    $res = db_query("SELECT * FROM `ftt_infoboard` WHERE `active` = 1 ORDER BY `position`"); // `date`=CURDATE()
    while ($row = $res->fetch_assoc()) $result[] = $row;
    return $result;
  }

  static function getPosition($id) {
    return parent::get('list', 'ftt_infoboard', '*', 'id', $id);
  }

  static function setPosition($id, $data) {
    $data = json_decode($data);
    $id = db_real_escape_string($id);
    $text = db_real_escape_string($data->text);
    $comment = db_real_escape_string($data->comment);
    return db_query("UPDATE `ftt_infoboard` SET `text` = '{$text}', `comment` = '{$comment}' WHERE `id` = '{$id}'");
  }
}
