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
  $condition_updates = '';
  $result='';

  if ($chosen_book == 3) {
    $condition_fields = " `book_ot`, `chapter_ot`, `read_footnotes_ot`, ";
    $condition_value = " '$book_ot', '$chapter_ot', '$footnotes_ot', ";
    $condition_fields .= " `book_nt`, `chapter_nt`, `read_footnotes_nt` ";
    $condition_value .= " '$book_nt', '$chapter_nt', '$footnotes_nt' ";
    $condition_updates = ", `book_nt` = '$book_nt', `chapter_nt` = '$chapter_nt', `read_footnotes_nt` = '$footnotes_nt' ";
    $condition_updates .= ", `book_ot` = '$book_ot', `chapter_ot` = '$chapter_ot', `read_footnotes_ot` = '$footnotes_ot' ";
  } elseif ($chosen_book == 1) {
    $condition_fields = " `book_ot`, `chapter_ot`, `read_footnotes_ot` ";
    $condition_value = " '$book_ot', '$chapter_ot', '$footnotes_ot' ";
    $condition_updates .= ", `book_ot` = '$book_ot', `chapter_ot` = '$chapter_ot', `read_footnotes_ot` = '$footnotes_ot' ";
  } elseif($chosen_book == 2) {
    $condition_fields .= " `book_nt`, `chapter_nt`, `read_footnotes_nt` ";
    $condition_value .= " '$book_nt', '$chapter_nt', '$footnotes_nt' ";
    $condition_updates = ", `book_nt` = '$book_nt', `chapter_nt` = '$chapter_nt', `read_footnotes_nt` = '$footnotes_nt' ";
  } else {
    return 'e001';
  }

  $res = db_query("SELECT `id` FROM `ftt_bible` WHERE `member_key` = '$member_key' AND `date` = '$date' AND `start` = 1");
  while ($row = $res->fetch_assoc()) $result = $row['id'];
  
  if (empty($result)) {
    $res = db_query("INSERT INTO `ftt_bible` (`member_key`, `date`, `start`, {$condition_fields}) VALUES ('$member_key', '$date', 1, {$condition_value})");
  } else {
    $res = db_query("UPDATE `ftt_bible`
      SET `member_key` = '$member_key' {$condition_updates}
      WHERE `member_key` = '$member_key' AND `date` = '$date' AND `start` = 1");
  }
  return $res;
}

function set_reading_bible($member_key, $date, $book_field, $book, $chapter)
{
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $date = $db->real_escape_string($date);
  $book_field = $db->real_escape_string($book_field);
  $book = $db->real_escape_string($book);
  $chapter = $db->real_escape_string($chapter);
  $result = '';
  $result2;
  $result3;
  $start_extra_field = '';
  $start_extra_value = '';
  // проверяем наличие записи
  $res = db_query("SELECT `id`, `book_nt`, `book_ot` FROM `ftt_bible` WHERE `member_key` = '$member_key' AND `date` = '$date' AND `start` != 1");
  while ($row = $res->fetch_assoc()) $result = $row;
  // заполняем второй блок если он пустой (при создании)
  if ($book_field === 'book_ot') {
    $chapter_field = 'chapter_ot';

  } else {
    $chapter_field = 'chapter_nt';
  }

  if (!isset($result['id'])) {
    $res = db_query("INSERT INTO `ftt_bible` (`member_key`, `date`, `$book_field`, `$chapter_field`)
     VALUES ('$member_key', '$date', '$book', '$chapter')");
  } else {
    $res = db_query("UPDATE `ftt_bible`
      SET `member_key` = '$member_key', `$book_field` = '$book', `$chapter_field` = '$chapter'
      WHERE `member_key` = '$member_key' AND `date` = '$date' AND `start` != 1");
  }

  return $res;
}

?>
