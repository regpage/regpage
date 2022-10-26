<?php
/**
 * isMoreThanCurrent($date) Передаваемая дата больше чем текущая
 */
class DatesCompare
{
  static function isMoreThanCurrent($date)
  {
    if (strtotime($date) > strtotime(date("Y-m-d"))) {
      return true;
    } else {
      return false;
    }
  }
  static function isMoreThanCurrentTime($date_time)
  {
    if (strtotime($date_time) > strtotime(date("Y-m-d H:i"))) {
      return true;
    } else {
      return false;
    }
  }
}



?>
