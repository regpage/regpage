<?php

// COMPLETED get serviceones who has trainees
// get data for serviceones
// send email
header('Content-Type: text/html; charset=utf-8');
session_start ();
require_once 'config.php';
require_once 'db/classes/statistics.php';
require_once 'db/classes/emailing.php';
require_once 'db/classes/ftt_lists.php';
require_once 'db/classes/member.php';
require_once 'db/classes/short_name.php';

function getServiceOnesWithTrainees ()
{
  $result = [];
  $res = db_query("SELECT DISTINCT `serving_one` FROM ftt_trainee");
  while ($row = $res->fetch_assoc()) $result[] = $row['serving_one'];

  foreach ($result as $key => $value) {
    echo $value."<br>";
    //Emailing::send_by_key()

    Emailing::send('A.rudanok@gmail.com', 'Статистика', short_name::no_middle(Member::get_name($value)).'<br>Статистика: <br>Листы отсутствия в ожидании - ' . statistics::permission_count(ftt_lists::get_trainees_by_staff($memberId)).'.<br>Доп. заданий - '.statistics::extra_help_count(ftt_lists::get_trainees_by_staff($value)).'.<br>Непрочитанных объявлений - '. statistics::announcement_unread($value));
    break;
  }

  return $result;
}
getServiceOnesWithTrainees ();
//global $db;
//$member_key = $db->real_escape_string($member_key);

?>
