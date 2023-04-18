<?php
if (!isset($_GET['msg'])) {
	exit;
}

# to
if (isset($_GET['debug'])) {
	$men = 'zhichkinroman@gmail.com, info@zhichkinroman.ru';
} else {
	$men = 'zhichkinroman@gmail.com, and1ievsky@gmail.com'; //a.rudanok@gmail.com, info@new-constellation.ru zhichkinroman@gmail.com,  info@zhichkinroman.ru
}
# topic
//$subject = 'Проверка почтовых отправлений';
$subject = '=?utf-8?B?'.base64_encode('Проверка почтовых отправлений').'?=';

# headers
//bibleforall.ru
//'Content-Type: text/html; charset=utf-8' . "\r\n" .
//'Content-Type: text/plain; charset=utf-8' . "\r\n" .
$headers = 'From: noreply@reg-page.ru' . "\r\n" .
'Content-Type: text/html; charset=utf-8' . "\r\n" .
'Reply-To: zhichkinroman@gmail.com' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
$to = $men;

# message
$message = file_get_contents("php://input"); // for Windows $text = str_replace("\n.", "\n..", $text);
$message = wordwrap($message, 70, "\r\n");

# send
mail($to, $subject, $message, $headers);
//echo $message;
