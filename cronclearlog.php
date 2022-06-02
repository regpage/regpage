<?php
//Автоматическое добавление строк для учёта практик (practices) выполняется по заданию (cron)
// строку ниже заменить на config.php
include_once 'db.php';
include_once 'logWriter.php';

function db_deleteSameStrLogs(){

  //logFileWriter(false, 'АКТИВНОСТЬ АДМИНИСТРАТОРОВ. Автоматическое удаление близких по времени строк активности администраторов.', 'WARNING');

//
  $members = [];

  $res=db_query ("SELECT DISTINCT admin_key FROM activity_log");
  while ($row = $res->fetch_assoc()) $members['admin_key']=$res;
  print_r($members);
  $memberStrings = array();
  foreach ($members as $a){

    $res1=db_query ("SELECT * FROM activity_log WHERE `admin_key` = '$a'");
    while ($row1 = $res1->fetch_assoc()) $memberStrings[]=$row1;

      for ($i=0; $i < count($memberStrings); $i++) {
        if ($memberStrings[$i+1]) {
          $date1 = new DateTime($memberStrings[$i+1]['time_create']);
          $date2 = new DateTime($memberStrings[$i]['time_create']);
          $diff = $date1->diff($date2);
          return $diff['days'];
          //echo $memberStrings[$i+1]['time_create'] - $memberStrings[$i]['time_create'];
          //break;
        }
      }
    }

/*
  $currentDate = date("Y-m-d");
  $yesterday = date("Y-m-d", strtotime("-1 days"));
  $result = array();
  $res=db_query ("SELECT `member_key` FROM user_setting WHERE `setting_key` = '9'");
  while ($row = $res->fetch_assoc()) $result[]=$row['member_key'];

  $resultat = array();
  foreach ($result as $a){
    $resu=db_query ("SELECT `member_id` FROM practices WHERE `member_id` = '$a' AND `date_practic` = '$currentDate'");
    while ($rows = $resu->fetch_assoc()) $resultat[]=$rows['member_id'];
  }

  foreach ($result as $aa){
    if (!in_array($aa, $resultat)){
      //$resultat
      echo "$aa, ";
      db_query("INSERT INTO practices (`date_create`, `member_id`, `date_practic`) VALUES (NOW(), '$aa', '$currentDate')");
      logFileWriter($aa, 'ПРАКТИКИ. АВТОМАТИЧЕСКОЕ ОБСЛУЖИВАНИЕ СЕРВЕРА. Добавлена строка учёта практик для данного пользователя.', 'WARNING');
    }
  }
  */
}

//db_deleteSameStrLogs();
?>
