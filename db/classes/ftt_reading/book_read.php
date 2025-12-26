<?php

/**
 *
 */
class BookRead
{
  static function get_all($member_key)
  {
    global $db;
    $member_key = $db->real_escape_string($member_key);
    $result = array('books' => [], 'notes_ot' => "", 'notes_nt' => "");

    $res = db_query("SELECT `book_ot`, `read_footnotes_ot` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' AND `book_ot` != ''");
    while ($row = $res->fetch_assoc()) {
      if (empty($result['notes_ot'])) {
        $result['notes_ot'] = $row['read_footnotes_ot'];
      }
      $result['books'][] = $row['book_ot'];
    }

    $res2 = db_query("SELECT `book_nt`, `read_footnotes_nt` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' AND `book_nt` != ''");
    while ($row = $res2->fetch_assoc()) {
      if (empty($result['notes_nt'])) {
        $result['notes_nt'] = $row['read_footnotes_nt'];
      }
      $result['books'][] = $row['book_nt'];
    }

    return $result;
  }
  static function get_according_last_start($memberKey)
  {
    global $db;
    $memberKey = $db->real_escape_string($memberKey);
    $result = array('books' => [], 'notes_ot' => "", 'notes_nt' => "");
    $lastStartOT = '_none_';
    $lastStartNT = '_none_';
    // получить старт и от него отталкиваться с прим без прим.
    $startOT = db_query("SELECT `read_footnotes_ot` FROM `ftt_bible` WHERE `member_key` = '{$memberKey}' AND `date` != '0000-00-00' AND `book_ot` != '' AND `start` = 1 ORDER BY date DESC LIMIT 1");
    while ($row = $startOT->fetch_assoc()) $lastStartOT = $row["read_footnotes_ot"];
    // проверить на пустую строки и запросить
    if ($lastStartOT !== '_none_') {
      $res = db_query("SELECT `book_ot`, `read_footnotes_ot` FROM `ftt_bible` WHERE `member_key` = '{$memberKey}' AND `date` = '0000-00-00' AND `book_ot` != '' AND `read_footnotes_ot` = {$lastStartOT}");
      while ($row = $res->fetch_assoc()) {
        if (empty($result['notes_ot'])) {
          $result['notes_ot'] = $row['read_footnotes_ot'];
        }
        $result['books'][] = $row['book_ot'];
      }
    }
    $startNT = db_query("SELECT `read_footnotes_nt` FROM `ftt_bible` WHERE `member_key` = '{$memberKey}' AND `date` != '0000-00-00' AND `book_nt` != '' AND `start` = 1 ORDER BY date DESC LIMIT 1");
    while ($row = $startNT->fetch_assoc()) $lastStartNT = $row["read_footnotes_nt"];
    // проверить на пустую строки и запросить
    if ($lastStartNT !== '_none_') {
      $res2 = db_query("SELECT `book_nt`, `read_footnotes_nt` FROM `ftt_bible` WHERE `member_key` = '{$memberKey}' AND `date` = '0000-00-00' AND `book_nt` != '' AND `read_footnotes_nt` = {$lastStartNT}");
      while ($row = $res2->fetch_assoc()) {
        if (empty($result['notes_nt'])) {
          $result['notes_nt'] = $row['read_footnotes_nt'];
        }
        $result['books'][] = $row['book_nt'];
      }
    }

    return $result;
  }
  static function get_percent($books, $memberKey, $testament)
  {
    global $db;
    // $books = $db->real_escape_string($books); // МАССИВ
    $memberKey = $db->real_escape_string($memberKey);
    $testament = $db->real_escape_string($testament);
    $read = [];
    $lastStart = '_none_';
    $percent = 0;

    // получить старт и от него отталкиваться с прим без прим.
    $start = db_query("SELECT `read_footnotes_{$testament}` FROM `ftt_bible` WHERE `member_key` = '{$memberKey}' AND `date` != '0000-00-00' AND `book_{$testament}` != '' AND `start` = 1 ORDER BY date DESC LIMIT 1");
    while ($row = $start->fetch_assoc()) $lastStart = $row["read_footnotes_{$testament}"];
    // проверить на пустую строки и запросить
    if ($lastStart === '_none_') {
      return '0%';
    }

    $res = db_query("SELECT DISTINCT `book_{$testament}` FROM `ftt_bible` WHERE `member_key` = '{$memberKey}' AND `date` = '0000-00-00' AND `book_{$testament}` != '' AND read_footnotes_{$testament} = {$lastStart}");
    while ($row = $res->fetch_assoc()) {
      $read[] = $row["book_{$testament}"];
    }

    foreach ($read as $value) {
      $result = array_filter($books, function($item) use ($value) {
        return isset($item[0]) && $item[0] === $value;
      });
      foreach ($result as $element) {
        $percent += $element[2];
      }
    }
    // OT = 99.98 NT = 99.99
    if ($percent > 99.00 && $percent < 99.98) {
      return floor($percent) . '%';
    } else {
      return round($percent, 0) . '%';
    }
  }
}
