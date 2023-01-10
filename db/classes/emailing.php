<?php
/**
 * Отправить письмо
 * Получаем данные об участние
 * Получаем емейл
 */

class Emailing
{
  // send email
  static function send($email, $topic, $text)
  {
    global $db;
    $email = $db->real_escape_string($email);
    if (empty($email)) {
      return false;
    }

    /*if (true) { //debug
     $email .= 'zhichkinroman@gmail.com, info@new-constellation.ru';
    }*/
    // письмо reg-page
    $men = $email;
    $headers = self::get_header();
    $to = $men;
    $subject = $topic;
    $message = $text; // for Windows $text = str_replace("\n.", "\n..", $text);
    $mail = mail($to, $subject, $message, $headers);

    return $mail;
  }
  // send email by key
  static function send_by_key($member_key, $topic, $text)
  {
    global $db;
    $member_key = $db->real_escape_string($member_key);
    //$adminId = db_getMemberIdBySessionId (session_id());
    /*if (true) { //debug
     $men = 'zhichkinroman@gmail.com, info@new-constellation.ru';
    }*/

    // письмо reg-page
    $headers = self::get_header();
    $to = self::get_email($member_key);
    $subject = $topic;
    $message = $text; //.date("H:i:s").' '.date("d.m.Y") // for Windows $text = str_replace("\n.", "\n..", $text);
    $mail = mail($to, $subject, $message, $headers);

    return $mail;
  }

  // получаем header
  static function get_header()
  {
    return 'From: noreply@reg-page.ru' . "\r\n" .
    'Content-Type: text/html; charset=utf-8' . "\r\n" .
    'Reply-To: noreply@reg-page.ru' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
  }
  // получаем имя пользователя
  static function get_name($member_key)
  {
    global $db;
    $member_key = $db->real_escape_string($member_key);
    $user ='';
    $res=db_query("SELECT `name` FROM `member` WHERE `key` = '$member_key'");
    while ($row = $res->fetch_assoc()) $user = $row['name'];

    return $user;
  }

  static function get_email ($member_key)
  {
    // получаем имя пользователя
    global $db;
    $member_key = $db->real_escape_string($member_key);
    $email = '';
    $res=db_query ("SELECT `email` FROM `member` WHERE `key` = '$member_key'");
    while ($row = $res->fetch_assoc()) $email=$row['email'];

    return $email;
  }
}
 ?>
