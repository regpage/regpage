<?php
// инфо для экранов на ПВОМ
require_once 'db/classes/common/db_query.php';
/**
 *
 */
class fttInfoboard extends DBQuery
{

  function getToday()
  {
      $result = [];
      $res = db_query("SELECT * FROM `ftt_infoboard` WHERE `date`=CURDATE() ORDER BY `type`, `position`");
      while ($row = $res->fetch_assoc()) $result[] = $row;
      return $result;
  }

}
