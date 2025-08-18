<?php
//include __DIR__.'/../../../db/classes/ftt_param.php';

// инфо для экранов на ПВОМ
if (isset($_GET['condition']) && $_GET['condition'] = 'today') {
  function getInfoboardToday()
  {
      $result = [];
      $res = db_query("SELECT * FROM `ftt_infoboard` WHERE `active`=1 ORDER BY `type`, `position`");
      while ($row = $res->fetch_assoc()) $result[] = $row;
      return $result;
  }
  echo json_encode(["result"=>getInfoboardToday()]);
}
