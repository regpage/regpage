<?php

// сброс значений полей взнос и комментарий участникам перечисленным в массиве
function resetFeeAndComment($members)
{
  $members = json_decode($members);

  if (count($members) === 0) {
    return 0;
  }
  
  $condition = "(";

  foreach ($members as $key => $value) {
    $value = db_real_escape_string($value);
    if ($condition !== '(') {
      $condition .= ",'{$value}'";
    } else {
      $condition .= "'{$value}'";
    }
  }

  $condition .= ")";

  $res = db_query ("UPDATE `attendance` SET `fee`='', comment='' WHERE `member_key` IN {$condition}");

  return $res;
}
