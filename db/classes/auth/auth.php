<?php
/**
 * Класс аутификации
 * Auth::by_link($member_key) // аутификация под юзером по кнопке
 * // логин
 * // логоут
 * // регистрация
 */
class Auth
{
  static function by_link($member_key)
  {
    global $db;
    $member_key = $db->real_escape_string($member_key);

    $result = db_query ("UPDATE `admin_session` SET `admin_key`='{$member_key}' WHERE `id_session`='".session_id()."'");
    if ($result) {
      return 'OK';
    } else {
      return "FAILURE";
    }
  }
}
 ?>
