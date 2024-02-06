<?php
/**
 * isMoreThanCurrent($date) Передаваемая дата больше чем текущая
 * isMoreThanCurrentTime тоже со временем
 * data - date = days
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

  // date - date = days
  static function diff($date1, $date2)
  {
    $date1 = new DateTime($date1);
    $date2 = new DateTime($date2);
    $diff = $date1->diff($date2);

    return $diff->days;
  }
}
