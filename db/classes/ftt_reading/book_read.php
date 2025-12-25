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

  static function get_percent($books, $memberKey, $testament)
  {
    $read = [];
    $percent = 0;
    $res = db_query("SELECT DISTINCT `book_{$testament}` FROM `ftt_bible` WHERE `member_key` = '{$memberKey}' AND `date` = '0000-00-00' AND `book_{$testament}` != ''");
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
    return round($percent, 0) . '%';
  }
}
