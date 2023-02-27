<?php
// Расписание
include 'config.php';
function getSchedule(){
  $result = [];
  $res = db_query("SELECT `id` FROM ftt_session");
  while ($row = $res->fetch_assoc()) $result[] = $row['id'];

  foreach ($result as $key => $value) {
    $new_value = '00'.$value;
    $res2=db_query("UPDATE `ftt_session` SET `id`='$new_value' WHERE `id`='$value'");
    echo "ID $value -> $res2\n";
  }
}

getSchedule();
