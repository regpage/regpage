<?php
/* VIDEO TRAINING */
function vTApplication($id)
{
  global $db;
  $id = $db->real_escape_string($id);
  $result = '';

  $res=db_query ("SELECT `description` FROM `vt_application` WHERE `id` = '$id'");
  while ($row = $res->fetch_assoc()) $result=$row['description'];

  return $result;
}
/* VIDEO TRAINING */
