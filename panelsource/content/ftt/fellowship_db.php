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
function db_addFttFellowshipTmpl($memberKey, $day, $time, $duration){
  $memberKey = db_real_escape_string($memberKey);
  $day = db_real_escape_string($day);
  $time = db_real_escape_string($time);
  $duration = db_real_escape_string($duration);

  $res=db_query ("INSERT INTO `ftt_fellowship_tmpl` (`serving_one`, `day`, `time`, `duration`) VALUES ('{$memberKey}', '{$day}', '{$time}', '{$duration}')");

	return $res;
}

// обновляем шаблон для раздела общение
function db_updFttFellowshipTmpl($memberKey, $day, $time, $duration, $cond_memberKey, $cond_day, $cond_time, $cond_duration){
  $memberKey = db_real_escape_string($memberKey);
  $day = db_real_escape_string($day);
  $time = db_real_escape_string($time);
  $duration = db_real_escape_string($duration);
  $cond_memberKey = db_real_escape_string($cond_memberKey);
  $cond_day = db_real_escape_string($cond_day);
  $cond_time = db_real_escape_string($cond_time);
  $cond_duration = db_real_escape_string($cond_duration);
  
  $res=db_query ("UPDATE `ftt_fellowship_tmpl`
    SET `serving_one`='{$memberKey}', `day`='{$day}', `time`='{$time}', `duration`='{$duration}'
    WHERE `serving_one` = '{$cond_memberKey}' AND `time` = '{$cond_time}' AND `day` = '{$cond_day}' AND `duration` = '{$cond_duration}' LIMIT 1");

	return $res;
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
     $res=db_query ("DELETE FROM `ftt_fellowship_tmpl` WHERE `serving_one` = '{$memberKey}' AND `time` = '{$time}' AND `day` = '{$day}' AND `duration` = '{$duration}' LIMIT 1");
   }

  //global $adminId;
  //write_to_log::info($adminId, 'Удалены шаблоны раздела Общение');

	return $res;
}
