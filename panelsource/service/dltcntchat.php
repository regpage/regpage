<?php
include_once '../../config.php';

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
  //print_r(count($result));
  //exit();
  $resultTmp = [];
  $count = 0;
  $res = [];
  $sql = '';
  //$counterloop = 0;

  for ($i = 0; $i < count($result); $i++) {
    /*if ($counterloop > 4) {
      break;
    }*/
    $resultTmp[] = $result[$i];
    if ($count === 5000) {
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
      //$res[] = db_query($sql);
      $resultTxt = '';
      $count = 0;
      //$counterloop++;
      break;
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
      $sql = "DELETE FROM `chat` WHERE {$resultTxt}";
      //$res[] = db_query ($sql);
      break;
    }

    $count++;
  }
  $counter = count($result);

  echo json_encode(array("result" => $sql));
  exit();
}
/* не используется
if (isset($_GET['dlt'])) {
  $condition = $_GET['cnd'];
  db_query ("DELETE FROM `chat` WHERE `group_id` = '{$condition}'");
  exit();
}
*/
