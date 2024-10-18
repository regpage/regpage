<?php
$info = db_getEventMemberByLink ($_GET["link"]);
$memberName = short_name::short($info['name']);
if (empty($info['arr_time'])) {
  $arrTime = $info['arr_time'];
} else {
  $arrTime = substr($info['arr_time'],0,5);
}

if (empty($info['dep_time'])) {
  $depTime = $info['dep_time'];
} else {
  $depTime = substr($info['dep_time'],0,5);
}
