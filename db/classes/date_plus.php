<?php
/**
 * Складываем и вычитаем даты
 *
 */
class date_plus {
  //dd.mm.yyyy_to_yyyy-mm-dd
  static function sub_d($date, $days) {
    if (empty($date) || empty($days)) {
      return 'No date';
    }
    $date = new DateTimeImmutable($date);
    $newDate = $date->sub(new DateInterval("P{$days}D"));
    return $newDate->format('Y-m-d');
  }
}
