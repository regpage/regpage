<?php
include_once 'config.php';

if (isset($_GET['get'])) {
  $chatId = [];
  $contactId = [];
  $result = [];
  $resultTxt = '';
  // get chat
  $res=db_query ("SELECT DISTINCT `group_id` FROM `chat` WHERE `group_id` != 0"); //
  while ($rows = $res->fetch_assoc()) $chatId[]=$rows['group_id'];

  $res2=db_query ("SELECT `id` FROM `contacts` WHERE 1");
  while ($rows = $res2->fetch_assoc()) $contactId[]=$rows['id'];

  // New version code
  /*$res=db_query ("SELECT DISTINCT `group_id` FROM `chat` WHERE `group_id` NOT IN (SELECT `id` FROM `contacts`) AND `group_id` != 0");
  while ($rows = $res->fetch_assoc()) $result[]=$rows['group_id'];
*/

  $result = array_diff($chatId, $contactId);
  $resultTmp = [];
  $count = 0;
  $res = [];
  $counterloop = 0;
  for ($i = 0; $i < count($result); $i++) {
    if ($counterloop > 4) {
      break;
    }
    $resultTmp[] = $result[$i];
    if ($count === 1000) {
      foreach ($resultTmp as $value) {
        if (!empty($value)) {
          if (empty($resultTxt)) {
            $resultTxt .= " `group_id` = {$value} ";
          } else {
            $resultTxt .= " OR `group_id` = {$value} ";
          }
        }
      }
      $sql = "DELETE FROM `chat` WHERE {$resultTxt}";
      $res[] = db_query($sql);
      $resultTxt = '';
      $count = 0;
      $counterloop++;
      //break;
    } elseif (($i+1) === count($result)) {
      foreach ($resultTmp as $value) {
        if (!empty($value)) {
          if (empty($resultTxt)) {
            $resultTxt .= " `group_id` = {$value} ";
          } else {
            $resultTxt .= " OR `group_id` = {$value} ";
          }
        }
      }
      $res[] = db_query ("DELETE FROM `chat` WHERE {$resultTxt}");
      break;
    }

    $count++;
  }
  $counter = count($result);


  echo json_encode(array("result" => $sql));
  exit();
}

if (isset($_GET['dlt'])) {
  $condition = $_GET['cnd'];
  db_query ("DELETE FROM `chat` WHERE `group_id` = '{$condition}'");
  exit();
}

/*
$counter = 0;
$condition = '';
foreach ($result as $key => $value) {
  if ($counter === 100) {
    if (empty($condition)) {
      $condition = $value;
    } else {
      $condition .= ',' . $value;
    }
    $res3=db_query ("DELETE FROM `chat` WHERE `group_id` IN ({$condition})");
    $counter = 0;
    $condition = '';
  } else {
    if (empty($condition)) {
      $condition = $value;
    } else {
      $condition .= ',' . $value;
    }
    $counter++;
  }
}

*/
