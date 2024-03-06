<?php
// get new id
function db_getNewContactIdApi ()
{
    $res=db_query ("SELECT `id` FROM contacts ORDER BY `id` DESC LIMIT 1");
    $row = $res->fetch_object();
    $key = "100000";
    if ($row && strlen($row->id)==6) $key = (string)($row->id + 1);
    return $key;
}
// Create or update a contact
function db_newContactByApi($data){

  global $db;
  $newId = db_getNewContactIdApi();
  $name = $db->real_escape_string($data['name']);
  $email = $db->real_escape_string($data['email']);
  $phone = $db->real_escape_string($data['phone']);
  $project = '24 урока';
  $status='';
  $responsible = '000010642';
  $svaz = '';
  // связь с подписчиком
  if (!empty($email)) {
    $svaz = 'Емайл: '.$email . '<br>';
  }
  if (!empty($phone)) {
    $svaz .= 'Тел.: '.$phone . '<br>';
  }
  // добавить всю инфу в комментарий + дата и время обращения
  $byMsgr = $db->real_escape_string($data['by_messanger']);
  $byPhone = $db->real_escape_string($data['by_phone']);
  $byEmail = $db->real_escape_string($data['by_email']);
  $comment = $db->real_escape_string($data['comment']);
  if (empty($comment)) {
    $comment = 'Дата и время подписки — ' . date('d.m.Y H:i') . "\r\n";
    $comment_mail = 'Дата и время подписки — ' . date('d.m.Y H:i') . "<br>";
  } else {
    $comment_mail = 'Дата и время подписки — ' . date('d.m.Y H:i') . "<br>Комментарий: " . $comment . "<br>";
    $comment = 'Дата и время подписки — ' . date('d.m.Y H:i') . "\r\nКомментарий: " . $comment . "\r\n";
  }

  if ($byMsgr) {
    $comment .= "Способ связи — мессенджер\r\n";
    $comment_mail .= "Способ связи — мессенджер<br>";
  }
  if ($byPhone) {
    $comment .= "Способ связи — телефон\r\n";
    $comment_mail .= "Способ связи — телефон<br>";
  }
  if ($byEmail) {
    $comment .= "Способ связи — емайл\r\n";
    $comment_mail .= "Способ связи — емайл<br>";
  }

  $res = db_query("INSERT INTO `contacts` (`id`, `name`, `phone`, `status`, `email`, `responsible`, `comment`, `project`) VALUES ('$newId', '$name', '$phone', '$status', '$email', '$responsible', '$comment', '$project')");

  if ($res) {
    $topic = 'Новый подписчик на 24 урока добавлен в раздел «Контакты»';
    $body = "Подписчик {$name} отметил поля в форме на bibleforall.ru для совместного изучения.<br>";
    $body .= $svaz;
    $body .= "Доп инфо: {$comment_mail}<br><br>";
    $body .= "<a href='https://reg-page.ru/contacts'>Перейти в раздел «Контакты»</a>";
    Emailing::send_by_key('000001679', $topic, $body); // $responsible
    Emailing::send_by_key('000010642', $topic, $body); // $responsible
  }

  return $res;
}

$result = db_newContactByApi($_POST);

echo json_encode("STATUS CONNECTION IS OK<br><br>RESULT IS $result<br>");
