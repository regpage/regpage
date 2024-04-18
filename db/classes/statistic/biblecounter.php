<?php
/**
 * Получаем кол-во глав обоих заветом и берём за 100% каждый
 * получаем кол-во прочитанных глав заветов
 * вычисляем остаток
 * получаем кол-во дней до конца семестра
 * даём рекоммендацию на день = оставшиеся главы/дни
 */

class BibleCounter
{
  static function sumChapters ()
  {
    $bible_obj = new Bible;
    $totalChapters = array('ot' => 0, 'nt' => 0);

    foreach ($bible_obj->get() as $key => $value) {
      if ($key < 39) {
        $totalChapters['ot'] += $value[1];
      } else {
        $totalChapters['nt'] += $value[1];
      }
    }
    return $totalChapters;
  }

  static function getRead($member_key)
  {
    // get ot read books
    $result = array('chapters_ot' => 0, 'chapters_nt' => 0);
    $res = db_query("SELECT `chapter_ot` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' AND `book_ot` != ''");
    while ($row = $res->fetch_assoc()) $result['chapters_ot'] += $row['chapter_ot'];

    // get nt read books
    $res2 = db_query("SELECT `chapter_nt` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' AND `book_nt` != ''");
    while ($row = $res2->fetch_assoc()) $result['chapters_nt'] += $row['chapter_nt'];

    return $result;
  }
  // рассчёт
  static function calculateTheDifference($member_key, $semester)
  {
    global $db;
    $member_key = $db->real_escape_string($member_key);
    $sumChapters = self::sumChapters();
    $readBook = self::getRead($member_key);
    $modificator = self::semesterModificator($semester);
    $startPosition = self::get_start_position($member_key);
    if (count($startPosition) === 0) {
      $startPosition = array('book_ot' => '0', 'read_footnotes_nt' => 0,'book_nt' => '','read_footnotes_ot' => 0);
    }

    $daysToEnd = ftt_info::days_to_end();
    $deffOt = $sumChapters['ot'] - $readBook['chapters_ot'];
    $deffNt = $sumChapters['nt'] - $readBook['chapters_nt'];
    if ($semester === '1' || $semester === '2') { // нз и вз без примечаний за 1 год обучения
      if ($startPosition['book_ot'] && empty($startPosition['book_nt'])) {
        $deffOt += $deffNt;
      } elseif (empty($startPosition['book_ot']) && $startPosition['book_nt']) {
        $deffNt += $deffOt;
      }
    } elseif ($semester === '3' || $semester === '4' || $semester === '5' || $semester === '6') {

    } else {
      return 'error A001';
    }

    $deffOt = $deffOt / ($daysToEnd + $modificator);
    $deffNt = $deffNt / ($daysToEnd + $modificator);

    $result = [
      'ot_deff'=>round($deffOt, 1),
      'nt_deff'=>round($deffNt,1),
      'ot_total'=>$sumChapters['ot'],
      'nt_total'=>$sumChapters['nt'],
      'left_days'=>$daysToEnd,
      'ot_complete'=> $readBook['chapters_ot'],
      'nt_complete'=>$readBook['chapters_nt'],
      'ot_current'=> $startPosition['book_ot'],
      'nt_current'=>$startPosition['book_nt'],
      'semester'=>$semester
    ];

    return $result;
  }
  // модификатор для разных семестров
  static function semesterModificator($semester)
  {
    $modificator = 0;
    if ($semester % 2 !== 0) {
      $modificator = 120 + 60;
    }
    return $modificator;
  }
  // start position
  static function get_start_position($member_key)
  {
    global $db;
    $member_key = $db->real_escape_string($member_key);
    $result = [];
    $res = db_query("SELECT DISTINCT `book_ot`, `read_footnotes_nt`, `book_nt`, `read_footnotes_ot` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `start` = 1 ORDER BY `date` ASC");
    while ($row = $res->fetch_assoc()) $result = $row;
    return $result;
  }
}
