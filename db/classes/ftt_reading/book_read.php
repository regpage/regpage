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
}
