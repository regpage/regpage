<?php
/**
 * Складываем и вычитаем даты
 *
 */
class date_plus {
  // вычитаем дни из даты
  static function sub_d($date, $days) {
    if (empty($date) || empty($days)) {
      return 'No date';
    }
    $date = new DateTimeImmutable($date);
    $newDate = $date->sub(new DateInterval("P{$days}D"));
    return $newDate->format('Y-m-d');
  }
}
