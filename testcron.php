<?php
// ТЕСТ можно удалить
// добавляем расписание в управление электронной доской
require_once 'config.php';
include_once 'db/classes/ftt_param.php';
require_once 'db/classes/schedule_class.php';

require_once 'db/classes/emailing.php';
require_once 'db/classes/ftt_lists.php';
include_once 'db/classes/ftt_fellowship/fellowship.php';
require_once 'db/classes/short_name.php';

function addTodayScheduleToInfoboard() {
  $dayN = 'day' . date('N');
  $dateToday = date('Y-m-d');
  // расписание 1-4 семестра сегодня
  $result = schedule_class::get(1, '02', date('Y-m-d'), $dayN);
  // Обработка полученных данных и формирование расписания
  $scheduleHTML = '';

  foreach ($result as $key => $value) {
      if ($value[$dayN]) {
        // продолжительность, время окончания мероприятия
        $finishTime = '';
        if ($value['duration'] && $value['duration'] !== '0') {
          $finishTime = '-' . (new DateTime($dateToday . ' ' . $value[$dayN] . ':00'))->modify("+{$value['duration']} minutes")->format('H:i');
        }
         $scheduleHTML .= '<div>' . $value[$dayN] . $finishTime . ' — ' . $value['session_name'] . "</div>";
      }
  }
  $res = db_query("UPDATE `ftt_infoboard` SET `text` = '{$scheduleHTML}' WHERE `type`='schedule'");
}

// addTodayScheduleToInfoboard();

function emailToBBDBrothers()
{
  foreach (ftt_lists::kbk_brothers() as $key => $value) {
    // общения на сегодня
    $fellowship_today = Fellowship::now_serving_one($key);
    $fellowship_text = '';
    $fellowship_text_name = '';
    if (count($fellowship_today) > 0) {
      $fellowship_text = '<b>Общение сегодня:</b><br>';

      foreach ($fellowship_today as $key_5 => $value_5) {
        if ($value_5['name']) {
          $name_f = short_name::no_middle($value_5['name']);
          $fellowship_text_name .= $name_f . " — {$value_5['time']}<br>";
          if (!empty($value_5['comment_train'])) {
            $fellowship_text_name .= "Комментарий: {$value_5['comment_train']}<br>";
          }
        }
      }
      if (count($fellowship_today) > 0) {
        $fellowship_text .= "<span> {$fellowship_text_name} </span><br>";
      }
    }

    $fellowship_cancel_today = Fellowship::canceled_serving_one($key);
    $fellowship_cancel_text_name = '';
    if (count($fellowship_cancel_today) > 0) {
      if (empty($fellowship_text)) {
        $fellowship_text = '<b>Отменено общение сегодня:</b><br>';
      } else {
        $fellowship_text .= '<br><b>Отменено общение сегодня:</b>';
      }
      foreach ($fellowship_cancel_today as $key_6 => $value_6) {
        $name_c = short_name::no_middle($value_6['name']);
        $fellowship_cancel_text_name .= $name_c . " — {$value_6['time']}<br>";
      }
      if (count($fellowship_cancel_today) > 0) {
        $fellowship_text .= "<span> {$fellowship_cancel_text_name} </span><br>";
      }
    }

    /*if (!empty($fellowship_text)) {
       $fellowship_text .= "<a href='https://reg-page.ru/ftt_fellowship.php'>Перейти в раздел «Общение»</a><br>";
    }*/
    // emailing
    if (!empty($fellowship_text)) {
      if (!empty($key)) {
        Emailing::send_by_key($key, 'Общение с обучающимися  ' . date('d.m.Y'), $fellowship_text);
        echo "КБК  {$value}, есть записи на сегодня, отправлено уведомление по емайл. \r\n";
        //Emailing::send_by_key('000005716', $topic, $body);
      } else {
        echo "Не получен емайл брата из КБК. \r\n";
      }
    } else {
      echo "КБК {$value}, Записи на сегодня отсутствуют. \r\n";
    }
  }
}

// emailToBBDBrothers();

require 'utils/emailing/EmailingSMTP.php';

EmailingSMTP::sendSMTP('constellationnew@gmail.com','Тестирование рассылки VPS','Это тестирование рассылки с VPS сервера.<br>');
/*
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'extensions/PHPMailer/src/Exception.php';
require 'extensions/PHPMailer/src/PHPMailer.php';
require 'extensions/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $mail->CharSet = PHPMailer::CHARSET_UTF8; // Устанавливаем кодировку для библиотеки
    $mail->Encoding = PHPMailer::ENCODING_BASE64; // Метод кодирования содержимого (для переноса строк)

    //Recipients // От кого (имя можно указать на русском)
    $mail->setFrom('info@new-constellation.ru', 'Уведомление с сайта регистрации');
    //$mail->addAddress('zhichkinroman@gmail.com', 'Joe User');     //Add a recipient
    $mail->addAddress('info@zhichkinroman.ru');               //Name is optional
    $mail->addReplyTo('info@new-constellation.ru', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Проверка рассылки с  VPS';
    $mail->Body    = 'Это тестовое письмо с <b>VPS!</b>';
    $mail->AltBody = 'Это текст не для HTML клиентов';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

// ВЕРСИЯ ОТ ИИ


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
