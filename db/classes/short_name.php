<?php
/** Принимает строку с ФИО
* Сокращаем имена, убираем отчество
 */
class short_name {
  // убираем отчество
  static function no_middle ($fio)   {
    $pieces = explode(" ", $fio);
    if (isset($pieces[2])) {
      return $pieces[0].' '.$pieces[1];
    } else {
      return $fio;
    }
  }
  // Сокращаем типа Иванов А. Б.
  static function short($fio) {
    $pieces = explode(" ", $fio);
    if (isset($pieces[1])) {
      $name = $pieces[1];
      return $pieces[0].' '.$name[0].'. ';
    } else {
      return $fio;
    }
  }
  // Сокращаем типа Иванов А. Б.
}


?>
