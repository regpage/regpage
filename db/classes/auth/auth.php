<?php
/**
 * Класс аутификации
 * Auth::by_link($member_key) // аутификация под юзером по кнопке
 * // логин по ссылке
 * // db_getMemberIdBySessionId
 * // логин
 * // логоут
 * // регистрация
 */
class Auth
{
  static function by_link($member_key)
  {
    $member_key = db_real_escape_string($member_key);

    $result = db_query ("UPDATE `admin_session` SET `admin_key`='{$member_key}' WHERE `id_session`='".session_id()."'");
    if ($result) {
      return 'OK';
    } else {
      return "FAILURE";
    }
  }

  static function get_member_key_by_session($sessionId)
  {
    $sessionId = db_real_escape_string($sessionId);

    $res=db_query ("SELECT admin_key from admin_session where id_session='{$sessionId}'");
    if ($row = $res->fetch_assoc()) return $row['admin_key'];
    return NULL;
  }

  function last_visit_time_update ($sessionId)
  {
      global $db;
      $datatime = date("Y-m-d H:i:s");
      $sessionId = db_real_escape_string($sessionId);
      db_query ("UPDATE admin_session SET time_last_visit = '{$datatime}' WHERE id_session='{$sessionId}'");
  }
}
