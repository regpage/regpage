<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if (true) { // isset($GLOBALS['global_root_path'])
  require 'extensions/PHPMailer/src/Exception.php';
  require 'extensions/PHPMailer/src/PHPMailer.php';
  require 'extensions/PHPMailer/src/SMTP.php';
} else {
  require '../extensions/PHPMailer/src/Exception.php';
  require '../extensions/PHPMailer/src/PHPMailer.php';
  require '../extensions/PHPMailer/src/SMTP.php';
}

/**
 *
 */
class EmailingSMTP
{

  static function sendSMTP($email, $topic, $body)
  {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_LOWLEVEL; // SMTP::DEBUG_SERVER                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.reg-page.ru'; //                      //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'noreply@reg-page.ru';  //                      //SMTP username
        $mail->Password   = 'xAENVhLVxh';  //                                //SMTP password
        $mail->SMTPSecure =  PHPMailer::ENCRYPTION_STARTTLS; // 'ssl'    PHPMailer::ENCRYPTION_SMTPS             //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


        $mail->CharSet = PHPMailer::CHARSET_UTF8; // Устанавливаем кодировку для библиотеки
        $mail->Encoding = PHPMailer::ENCODING_BASE64; // Метод кодирования содержимого (для переноса строк)

        //Recipients // От кого (имя можно указать на русском)
        $mail->setFrom('noreply@reg-page.ru', 'Уведомление с сайта регистрации');
        // Кому
        //$mail->addAddress('zhichkinroman@gmail.com', 'Joe User');     //Add a recipient
        $mail->addAddress($email);               //Name is optional
        $mail->addReplyTo('noreply@reg-page.ru', 'Автоматическая рассылка');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        // Вложение
        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $email;
        $mail->Body    = $body;
        $mail->AltBody = $body;

        $mail->SMTPOptions = array(
          'ssl' => array(
            'verify_peer' => false,       // Отключает проверку сертификата
            'verify_peer_name' => false,  // Отключает проверку имени хоста в сертификате
            'allow_self_signed' => true   // Разрешает самоподписанные сертификаты
          )
        );
        $mail->send();
        echo 'Письмо отправлено';
    } catch (Exception $e) {
        echo "Ошибка. Письмо не отправлено. PHPMailer Error: {$mail->ErrorInfo}";
    }

    // ВЕРСИЯ ОТ ИИ
    /*

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        // Настройки сервера
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your@gmail.com';
        $mail->Password = 'your_app_password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // --- КРИТИЧЕСКИ ВАЖНЫЕ НАСТРОЙКИ КОДИРОВКИ ---
        $mail->CharSet = PHPMailer::CHARSET_UTF8; // Устанавливаем кодировку для библиотеки
        $mail->Encoding = PHPMailer::ENCODING_BASE64; // Метод кодирования содержимого (для переноса строк)

        // От кого (ВАЖНО: имя можно указать на русском)
        $mail->setFrom('your@gmail.com', 'Иван Иванов'); // Кириллица в имени
        // Кому
        $mail->addAddress('client@example.com', 'Петр Петров'); // Кириллица в имени

        // Тема письма на русском
        $mail->Subject = 'Заявка с сайта'; // Тема будет корректно закодирована автоматически

        // Тело письма
        $mail->isHTML(true);

        // HTML-версия письма
        $htmlBody = "
        <!DOCTYPE html>
        <html lang='ru'>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'> <!-- Важно! -->
            <title>Заголовок страницы</title>
        </head>
        <body>
            <h1>Здравствуйте!</h1>
            <p>Это письмо на <strong>русском языке</strong> с симолами: й, ё, ë.</p>
            <p>Кодировка работает корректно.</p>
        </body>
        </html>
        ";

        $mail->Body = $htmlBody;

        // Альтернативная Plain Text-версия письма для почтовых клиентов, не поддерживающих HTML
        $textBody = "Здравствуйте!\r\nЭто письмо на русском языке. Кодировка работает корректно.";
        $mail->AltBody = $textBody;

        $mail->send();
        echo 'Письмо отправлено!';
    } catch (Exception $e) {
        echo "Ошибка отправки: {$mail->ErrorInfo}";
    }

    */

  }
}
