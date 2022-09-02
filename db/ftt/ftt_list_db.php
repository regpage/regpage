<?php
/* Заменено универсальным классом DbOperation
function save_blank($data)
{
  global $db;
  $data = json_decode($data);
  $member_key = $db->real_escape_string($data->member_key);
  // убрано из запроса
  //$semester = $db->real_escape_string($data->semester);
  $query_set = '';
  $result;

  foreach ($data as $key => $value) {
    if ($key !== 'member_key') { // && $key !== 'semester'
      *//*if ($query_set) {
        $query_set .= ', ';
      }*//*
      $key = $db->real_escape_string($key);
      $value = $db->real_escape_string($value);
      $query_set .= ' `'.$key."`='$value', ";
    }
  }

  $result = db_query("UPDATE `member` SET {$query_set} `changed` = 1  WHERE `key` = '$member_key'");

  *//*if ($result) { //, `changed` = 1
    $result = db_query("UPDATE `ftt_trainee` SET `semester` = '$semester'  WHERE `member_key` = '$member_key'");
  } *//*

  $result;
}
*/
?>
