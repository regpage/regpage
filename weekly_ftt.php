<?php
//Автоматическое удаление опозданий
// строку ниже заменить на config.php
include_once 'db.php';
//include_once 'logWriter.php';

function db_checkweeklyLate() {
  $res = db_query("UPDATE `ftt_late` SET `done` = 1 WHERE (`date` < DATE_FORMAT(NOW(), '%Y-%m-%d')) AND `done`=0");

  return $res;
}

db_checkweeklyLate();
?>
