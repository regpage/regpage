<?php
//Автоматическое удаление отметок о прочтении объявлений
include_once 'config.php';
include_once 'logWriter.php';

function dbAnnouncementRecipientsDelete() {
  $res = db_query ("DELETE FROM `ftt_announcement_recipients`");
  logFileWriter(false, 'Автоматическое удаление отметок о прочтении объявлений в конце семестра. Результат - '.$res, 'DEBUG');
  echo 'Автоматическое удаление отметок о прочтении объявлений в конце семестра. Результат - '.$res;
}

dbAnnouncementRecipientsDelete();
?>
