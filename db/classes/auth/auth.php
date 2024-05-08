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

    $res = db_query ("SELECT member_key from admin where session='{$sessionId}'");
    if ($row = $res->fetch_assoc()) return $row['member_key'];
    return NULL;
  }
}
