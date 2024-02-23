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
    $result = [];

    $res = db_query("SELECT `book_ot` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' AND `book_ot` != ''");
    while ($row = $res->fetch_assoc()) $result[] = $row['book_ot'];

    $res2 = db_query("SELECT `book_nt` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' AND `book_nt` != ''");
    while ($row = $res2->fetch_assoc()) $result[] = $row['book_nt'];

    return $result;
  }
}
