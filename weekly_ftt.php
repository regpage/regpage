<?php
//Автоматическое удаление опозданий
include_once 'config.php';
include_once 'logWriter.php';

function db_checkweeklyLate() {
  $res = db_query("UPDATE `ftt_late` SET `done` = 1 WHERE (`date` < DATE_FORMAT(NOW(), '%Y-%m-%d')) AND `done`=0");
  logFileWriter(false, 'Еженедельное списание опозданий. Результат - '.$res, 'DEBUG');

  $faleName = $_SERVER['PHP_SELF'];
  db_query("INSERT INTO `cron` (`date`,`script`, `status`, `comment`) VALUES (CURRENT_DATE(),'{$faleName}', '1', '')");

  echo 'Еженедельное списание опозданий. Результат - '.$res;
}

db_checkweeklyLate();
?>
