<?php

// получаем шаблоны для раздела общение
function db_getFttFellowshipTmpl(){
  $fellowshipTmpl = array ();

  $res=db_query ("SELECT fft.*, m.name
    FROM ftt_fellowship_tmpl AS fft
    LEFT JOIN member AS m ON m.key = fft.serving_one
    ORDER BY m.name, fft.time");

		while ($row = $res->fetch_assoc()) $fellowshipTmpl[]=$row;
		return $fellowshipTmpl;
}

// добавляем шаблоны для раздела общение
function db_addFttFellowshipTmpl(){
  $fellowshipTmpl = array ();

  $res=db_query ("INSERT INTO `ftt_fellowship_tmpl`  `member_key`, `time`");

		while ($row = $res->fetch_assoc()) $fellowshipTmpl[]=$row;
		return $fellowshipTmpl;
}

// обновляем шаблон для раздела общение
function db_updFttFellowshipTmpl(){
  $fellowshipTmpl = array ();

  $res=db_query ("UPDATE * FROM `ftt_fellowship_tmpl` ORDER BY `member_key`, `time`");

		while ($row = $res->fetch_object()) $fellowshipTmpl[]=$row;
		return $fellowshipTmpl;
}

// Удалить  шаблон для раздела общение
function db_dltFttFellowshipTmpl($memberKey, $day='', $time='', $duration=''){
  $memberKey = db_real_escape_string($memberKey);
  $day = db_real_escape_string($day);
  $time = db_real_escape_string($time);
  $duration = db_real_escape_string($duration);

   if ($memberKey === '_all_') {
     $res=db_query ("DELETE FROM `ftt_fellowship_tmpl`");
   } else {
     $res=db_query ("DELETE FROM `ftt_fellowship_tmpl` WHERE `serving_one` = '$memberKey' AND `time` = '$time' AND `day` = '$day' AND `duration` = '$duration'");
   }

  //global $adminId;
  //write_to_log::info($adminId, 'Удалены шаблоны раздела Общение');

	return $res;
}
