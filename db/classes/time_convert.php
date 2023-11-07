<?php
/**
 * Приводим даты к нужному виду
 * time tt.mm + m
 */
class time_convert {
  //tt.mm + m
  static function sum ($time, $duration)  {
    if (empty($time) || !is_numeric($duration)) {
      return 'No time';
    }
    $time = explode(':', $time);
    if (!isset($time[1])) {
      return 'No time';
    }
    $sum = $time[0] * 60 + $time[1] + $duration;
    $hours = intdiv($sum, 60);
    $minutes = $sum - ($hours * 60);
    if ($minutes === 0) {
      $minutes = '00';
    } elseif ($minutes < 10) {
      $minutes = '0' + strval($minutes);
    }

    return $hours . ':' . $minutes;
  }
}
