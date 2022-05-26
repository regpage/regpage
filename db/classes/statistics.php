<?php
/**  Статистики
*  statistics::extra_help_count($memberId) - Количество активных допзаданий
*
**/
class statistics {
  //Количество активных допзаданий
  static function extra_help_count ($memberId) {
    global $db;
    $memberId = $db->real_escape_string($memberId);
    $result = '';
    $res = db_query("SELECT COUNT(`id`) AS total FROM ftt_extra_help WHERE `member_key`= '$memberId' AND `archive`=0");
    while ($row = $res->fetch_assoc()) $result = $row['total'];
    return $result;
  }
}


?>
