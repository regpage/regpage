<?php
// COMMUNICATION
function get_communication_list($past=0)
{
  global $db;
  $past = $db->real_escape_string($past);

  $result = [];
  $res = db_query("SELECT *
    FROM `ftt_communication`
    WHERE `past` = '$past'
    ORDER BY `date`, `time`");
  while ($row = $res->fetch_assoc()) {
    if (isset($result[$row['serving_one']])) {
      $result[$row['serving_one']][] = $row;
    } else {
      $result[$row['serving_one']] = [];
      $result[$row['serving_one']][] = $row;
    }

  }
  return $result;
}

function get_communication_records($trainee)
{
  global $db;
  $trainee = $db->real_escape_string($trainee);

  $result = [];
  $res = db_query("SELECT *
    FROM `ftt_communication`
    WHERE `trainee` = '$trainee'
    ORDER BY `date`, `time`");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

function set_communication_record($trainee, $id)
{
  global $db;
  $trainee = $db->real_escape_string($trainee);
  $id = $db->real_escape_string($id);

  $res = db_query("UPDATE `ftt_communication` SET `trainee`= '$trainee', `date_trainee`=NOW(), `changed`= 1 WHERE `id` = $id");
}
