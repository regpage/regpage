<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


global $CRON_ROOT_PATH;
if (!empty($CRON_ROOT_PATH)) {
  require_once "{$CRON_ROOT_PATH}/extensions/PHPMailer/src/Exception.php";
  require_once "{$CRON_ROOT_PATH}/extensions/PHPMailer/src/PHPMailer.php";
  require_once "{$CRON_ROOT_PATH}/extensions/PHPMailer/src/SMTP.php";
} elseif (isset($GLOBALS['global_root_path'])) {
  require_once 'extensions/PHPMailer/src/Exception.php';
  require_once 'extensions/PHPMailer/src/PHPMailer.php';
  require_once 'extensions/PHPMailer/src/SMTP.php';
} else {
  global $ajaxPath;
  $ajaxPath = $ajaxPath ?? '';
  require_once "{$ajaxPath}extensions/PHPMailer/src/Exception.php";
  require_once "{$ajaxPath}extensions/PHPMailer/src/PHPMailer.php";
  require_once "{$ajaxPath}extensions/PHPMailer/src/SMTP.php";
}

//include_once 'utils/emailing/EmailingSMTP.php';
/**
 * Отправить письмо
 * Получаем данные об участние
 * Получаем емейл
 */

class Emailing
{
  static function checkDomain()
  {
    $currentDomain = $_SERVER['HTTP_HOST'] ?? '';
    $allowedDomain = 'reg-page.ru';
    //нормализация домена (удаляет 'www.' если он есть)
    // Приводим к нижнему регистру
    $currentDomain = strtolower($currentDomain);
    // Удаляем 'www.' в начале, если он есть
    if (substr($currentDomain, 0, 4) === 'www.') {
      $currentDomain = substr($currentDomain, 4);
    }
    if ($currentDomain === $allowedDomain) {
      return true;
    }
    return false;
  }
  // send email
  static function send($email, $topic, $text, $replyTo = 'noreply@reg-page.ru', $fromName = 'Уведомление с сайта регистрации')
  {
    global $db;
    global $CRON_ROOT_PATH;
    $email = $db->real_escape_string($email);
    if (empty($email)) {
      return false;
    }

    $men = $email;
    //$headers = self::get_header($replyTo, $fromName);
    $to = $men;
    $subject = $topic;
    $message = $text; // for Windows $text = str_replace("\n.", "\n..", $text);
    // письмо reg-page
    if (self::checkDomain() || $member_key === '000005716' || !empty($CRON_ROOT_PATH)) {
      return EmailingSMTP::sendSMTP($to, $subject, $message, $replyTo, $fromName);
    } else {
      return false;
    }
    //$mail = mail($to, $subject, $message, $headers);
  }

  // send email by key
  static function send_by_key($member_key, $topic, $text, $replyTo = 'noreply@reg-page.ru', $fromName = 'Уведомление с сайта регистрации')
  {

    global $db;
    global $CRON_ROOT_PATH;
    $member_key = $db->real_escape_string($member_key);

    // письмо reg-page
    //$headers = self::get_header($replyTo, $fromName);
    $to = self::get_email($member_key);
    $subject = $topic;
    $message = $text; //.date("H:i:s").' '.date("d.m.Y") // for Windows $text = str_replace("\n.", "\n..", $text);
    if (self::checkDomain() || $member_key === '000005716' || !empty($CRON_ROOT_PATH)) {
      return EmailingSMTP::sendSMTP($to, $subject, $message, $replyTo, $fromName);
    } else {
      return false;
    }
    // $mail = mail($to, $subject, $message, $headers);
  }

  // получаем header
  static function get_header($replyTo = 'noreply@reg-page.ru', $fromName = 'reg-page.ru')
  {
    return "From: {$fromName} <noreply@reg-page.ru>\r\n" .
    'Content-Type: text/html; charset=utf-8' . "\r\n" .
    "Reply-To: {$replyTo}\r\n" .
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

/**
 *
 */
class EmailingSMTP
{

  static function sendSMTP($email, $topic, $body, $replyTo = 'noreply@reg-page.ru', $fromName = 'Уведомление с сайта регистрации')
  {
    global $mailCnfg;

    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_LOWLEVEL; // SMTP::DEBUG_SERVER                      //Enable verbose debug output
        // Настройка кодировки
        $mail->CharSet = PHPMailer::CHARSET_UTF8; // Устанавливаем кодировку для библиотеки
        $mail->Encoding = PHPMailer::ENCODING_BASE64; // Метод кодирования содержимого (для переноса строк)

        // Языковые заголовки
        $mail->setLanguage('ru');
        /*$mail->addCustomHeader('Content-Language: ru-RU'); // Явное указание языка в заголовках
        $mail->addCustomHeader('Accept-Language: ru-RU, ru;q=0.9'); // Дополнительный заголовок для лучшей поддержки*/

        // Настройка SMTP
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $mailCnfg['host']; //                      //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $mailCnfg['username'];  //                      //SMTP username
        $mail->Password   = $mailCnfg['password'];  //                                //SMTP password
        $mail->SMTPSecure =  PHPMailer::ENCRYPTION_STARTTLS; // 'ssl'    PHPMailer::ENCRYPTION_SMTPS             //Enable implicit TLS encryption
        $mail->Port       = $mailCnfg['port'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        // Отправитель и получатель
        //Recipients // От кого (имя можно указать на русском)
        $mail->setFrom('noreply@reg-page.ru', $fromName);
        // Кому
        //$mail->addAddress('zhichkinroman@gmail.com', 'Joe User');     //Add a recipient
        $emails = array_filter(array_map('trim', explode(',', $email)));
        foreach ($emails as $emailElem) {
          if (filter_var($emailElem, FILTER_VALIDATE_EMAIL)) {
            $mail->addAddress($emailElem);               //Name is optional
          }
        }

        $mail->addReplyTo($replyTo, $fromName);
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        // Вложение
        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        // Тема и тело письма
        $bodyHTML = '<!DOCTYPE html><html lang="ru"><head><meta charset="UTF-8"><title>' . $topic . '</title></head><body>' . $body . '</body></html>';
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $topic;
        $mail->Body    = $bodyHTML;
        $mail->AltBody = preg_replace('<br>', '\r\n', $body);

        $mail->SMTPOptions = array(
          'ssl' => array(
            'verify_peer' => false,       // Отключает проверку сертификата
            'verify_peer_name' => false,  // Отключает проверку имени хоста в сертификате
            'allow_self_signed' => true   // Разрешает самоподписанные сертификаты
          )
        );
        $mail->send();

    } catch (Exception $e) {
        echo "Ошибка. Письмо не отправлено. PHPMailer Error: {$mail->ErrorInfo}";
    }
  }
}
