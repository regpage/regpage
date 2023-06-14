<?php
/**
 * get() получить кандидатов
 * исключены статусы: принят, отклонён
 * add() добавить кандидата
 * dlt() удалить кандидата
 * check() проверка наличия заявления у кандидата по ключу участника
 * list() список кандидатов (участников с заявлениями)
 * members() список администраторов сайта
 */

class FttCandidates
{
  static function get()
  {
    $result = [];
    $res = db_query("SELECT fr.member_key, m.name
      FROM ftt_request AS fr
      LEFT JOIN member m ON m.key=fr.member_key
      WHERE fr.stage >= 0 AND fr.notice != 2");
    while ($row = $res->fetch_assoc()) $result[] = $row['member_key'];

    return $result;
  }
  static function add($member_key, $is_guest = 0)
  {
      global $db;
      $member_key = $db->real_escape_string($member_key);
      $is_guest = $db->real_escape_string($is_guest);
      $list = self::get();
      if (!in_array($member_key, $list)) {
        $res = db_query("INSERT INTO `ftt_request` (`member_key`, `guest`) VALUES ('$member_key', '$is_guest')");
        return true;
      } else {
        return false;
      }
  }
  static function dlt($member_key)
  {
      global $db;
      $member_key = $db->real_escape_string($member_key);
      $list = self::get();
      if (($key = array_search($member_key, $list)) !== false) {
        $res = db_query("DELETE FROM `ftt_request` WHERE `member_key` = '$member_key'");
        return true;
      } else {
        return false;
      }
  }
  static function check($member_key)
  {
      $list = self::get();
      if (in_array($member_key, $list)) {
        return true;
      } else {
        return false;
      }
  }
  static function list()
  {
    $result = [];
    $res = db_query("SELECT fr.member_key, m.name
      FROM ftt_request AS fr
      LEFT JOIN member m ON m.key=fr.member_key
      WHERE stage = 0");
    while ($row = $res->fetch_assoc()) $result[$row['member_key']] = $row['name'];

    return $result;
  }
  static function members()
  {
      $result = [];
      $res = db_query("SELECT a.member_key, m.name, l.name AS locality
        FROM admin AS a
        LEFT JOIN member m ON m.key=a.member_key
        LEFT JOIN locality l ON l.key=m.locality_key
        WHERE a.member_key NOT LIKE '99%'
        ORDER BY m.name");
      while ($row = $res->fetch_assoc()) $result[$row['member_key']] = $row['name'];
      return $result;
  }
}
