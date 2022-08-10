<?php
/** Принимает строку с ФИО
* Сокращаем имена, убираем отчество
 */
class short_name {
  // что будет если между именами будет два или больше знаков пробелов
  // что будет если не применёт trim к входящей строке
  // убираем отчество
  static function no_middle ($fio)   {
    $pieces = explode(" ", $fio);
    if (isset($pieces[2])) {
      return $pieces[0].' '.$pieces[1];
    } else {
      return $fio;
    }
  }

  // Сокращаем типа Иванов А.
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
  static function short_n_p($fio) {
    $pieces = explode(" ", $fio);
    if (isset($pieces[2])) {
      $name = $pieces[1];
      $patro = $pieces[2];
      return $pieces[0].' '.$name[0].'. '.$patro[0].'. ';
    } else if (isset($pieces[1])) {
      $name = $pieces[1];
      return $pieces[0].' '.$name[0].'. ';
    } else {
      return $fio;
    }
  }
}

?>
