<?php
/**
 * Приводим даты к нужному виду
 * date_convert::yyyymmdd_to_ddmmyyyy($date)
 */
class date_convert {
  //dd.mm.yyyy_to_yyyy-mm-dd
  static function ddmmyyyy_to_yyyymmdd ($date)  {
    if (!$date) {
      return 'No date';
    }
    $date = explode('.', $date);
    if (isset($date[2])) {
      return $date[2].'-'.$date[1].'-'.$date[0];
    } else {
      return 'Date is incorrect.';
    }
  }
  // yyyy-mm-dd_to_dd.mm.yyyy
  static function yyyymmdd_to_ddmmyyyy ($date)  {
    if (!$date) {
      return 'No date';
    }

    $date = explode('-', $date);
    if (isset($date[2])) {
      $date = $date[2].'.'.$date[1].'.'.$date[0];
    } else {
      return 'Date is incorrect.';
    }

    return $date;
  }

  // yyyy-mm-dd_to_dd.mm.yyyy + time
  static function yyyymmdd_time_to_ddmmyyyy_time ($date)  {
    if (!$date) {
      return 'No date';
    }
    $time;
    $check = explode(':', $date);
    if (count($check) > 1) {
      $time = explode(' ', trim($date));
      $date = $time[0];
      if (isset($time[1])) {
        $time = $time[1];
        $time = explode(':', $time);
        $time = $time[0].':'.$time[1];
      } else {
        $time = '';
      }
    }

    $date = explode('-', $date);
    if (isset($date[2])) {
      $date = $date[2].'.'.$date[1].'.'.$date[0];
    } else {
      return 'Date is incorrect.';
    }
    if (!$time) {
      return $date;
    } else {
      return $date.' '.$time;
    }
  }

  static function yyyymmdd_to_ddmm ($date)  {
    if (!$date) {
      return 'No date';
    }
    $date = explode('-', $date);
    if (isset($date[2])) {
      return $date[2].'.'.$date[1];
    } else {
      return 'Date is incorrect.';
    }
  }

  static function week_days($date='', $short=false) {
		$day;
		if ($date) {
			$day = date('w', strtotime($date));
		} else {
			$day = date('w');
		}

	  $weekday = [];
	  if ($short) {
	    $weekday[0] = "вс";
	    $weekday[1] = "пн";
	    $weekday[2] = "вт";
	    $weekday[3] = "ср";
	    $weekday[4] = "чт";
	    $weekday[5] = "пт";
	    $weekday[6] = "сб";
	  } else {
	    $weekday[0] = "Воскресенье";
	    $weekday[1] = "Понедельник";
	    $weekday[2] = "Вторник";
	    $weekday[3] = "Среда";
	    $weekday[4] = "Четверг";
	    $weekday[5] = "Пятница";
	    $weekday[6] = "Суббота";
	  }
	  return $weekday[$day];
	}

  static function get_age($birthDate){
      $date = strtotime ($birthDate);
      $age =  (int)date("Y") - (int)strftime("%Y",$date);
      $m = (int)date("m") - (int)strftime("%m",$date);

      if ($m < 0 || ($m === 0 && (int)date("e") - (int)strftime("%e",$date))) {
          $age--;
      }
      return $age;
  }
}

 ?>
