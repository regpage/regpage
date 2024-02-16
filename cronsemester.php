<?php
//Автоматическое удаление отметок о прочтении объявлений
include_once 'config.php';
include_once 'logWriter.php';

function dltCron() {
  $res = db_query ("DELETE FROM `cron`");
  logFileWriter(false, 'Автоматическое удаление отметок исполнения крон в конце семестра. Результат - '.$res, 'DEBUG');
  echo 'Автоматическое удаление отметок исполнения крон в конце семестра. Результат - '.$res.'<br>';
}

dltCron();

function dbAnnouncementRecipientsDelete() {
  $res = db_query ("DELETE FROM `ftt_announcement_recipients`");
  $faleName = $_SERVER['PHP_SELF'];
  db_query("INSERT INTO `cron` (`date`,`script`, `status`, `comment`) VALUES (CURRENT_DATE(),'{$faleName}', '1', '')");
  logFileWriter(false, 'Автоматическое удаление отметок о прочтении объявлений в конце семестра. Результат - '.$res, 'DEBUG');
  echo 'Автоматическое удаление отметок о прочтении объявлений в конце семестра. Результат - '.$res.'<br>';
}

dbAnnouncementRecipientsDelete();
