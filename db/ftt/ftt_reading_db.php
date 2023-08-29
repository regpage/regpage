<?php
// reading bible page
function set_start_reading_bible($member_key, $date, $chosen_book='', $book_ot='', $chapter_ot='', $footnotes_nt='', $book_nt='', $chapter_nt='', $footnotes_ot='')
{
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $date = $db->real_escape_string($date);
  $chosen_book = $db->real_escape_string($chosen_book);
  $book_ot = $db->real_escape_string($book_ot);
  $chapter_ot = $db->real_escape_string($chapter_ot);
  $footnotes_ot = $db->real_escape_string($footnotes_ot);
  $book_nt = $db->real_escape_string($book_nt);
  $chapter_nt = $db->real_escape_string($chapter_nt);
  $footnotes_ot = $db->real_escape_string($footnotes_ot);
  $condition_fields = '';
  $condition_value = '';

  if ($chosen_book == 3) {
    $condition_fields = " `book_ot`, `chapter_ot`, `read_footnotes_ot`, ";
    $condition_value = " '$book_ot', '$chapter_ot', '$footnotes_ot', ";
    $condition_fields .= " `book_nt`, `chapter_nt`, `read_footnotes_nt` ";
    $condition_value .= " '$book_nt', '$chapter_nt', '$footnotes_nt' ";
  } elseif ($chosen_book == 1) {
    $condition_fields = " `book_ot`, `chapter_ot`, `read_footnotes_ot` ";
    $condition_value = " '$book_ot', '$chapter_ot', '$footnotes_ot' ";
  } elseif($chosen_book == 2) {
    $condition_fields .= " `book_nt`, `chapter_nt`, `read_footnotes_nt` ";
    $condition_value .= " '$book_nt', '$chapter_nt', '$footnotes_nt' ";
  } else {
    return 'e001';
  }


  $res = db_query("INSERT INTO `ftt_bible` (`member_key`, `date`, `start`, {$condition_fields}) VALUES ('$member_key', '$date', 1, {$condition_value})");
  return $res;
}

?>
