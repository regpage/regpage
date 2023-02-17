<?php
/** Принимает строку с ФИО
* ВИД: РЕНДЕРИНГ ПЕРЕНЕСТИ В БЛОКИ
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
      $name = iconv_substr($pieces[1], 0, 1, 'UTF-8');
      return $pieces[0].' '.$name.'. ';
    } else {
      return $fio;
    }
  }

  // Сокращаем типа Иванов А. Б.
  static function short_n_p($fio) {
    $pieces = explode(" ", $fio);
    if (isset($pieces[2])) {
      $name = iconv_substr($pieces[1], 0, 1, 'UTF-8');
      $patro = iconv_substr($pieces[2], 0, 1, 'UTF-8');
      return $pieces[0].' '.$name.'. '.$patro.'. ';
    } else if (isset($pieces[1])) {
      $name = iconv_substr($pieces[1], 0, 1, 'UTF-8');
      return $pieces[0].' '.$name.'. ';
    } else {
      return $fio;
    }
  }
}

?>
