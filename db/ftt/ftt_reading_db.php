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

/*** bible reading GET ***/
function get_reading_data($member_key, $date)
{
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $date = $db->real_escape_string($date);
  $result = [];
  $result2 = [];
  $result3 = [];
  $start_date = "";
  $start_today = 0;

  // START
  $res = db_query("SELECT DISTINCT * FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `start` = 1 ORDER BY `date` ASC");
  while ($row = $res->fetch_assoc()) $start_date = $row['date'];
  if ($start_date === $date) {
    $start_today = 1;
  }
  $res = db_query("SELECT DISTINCT * FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '{$date}' AND `start` != 1");
  while ($row = $res->fetch_assoc()) $result = $row;
  // если сегодня поля заполненны
  if ((isset($result['chapter_ot']) && $result['chapter_ot'] > 0) && (isset($result['chapter_nt']) && $result['chapter_nt'] > 0)) {
    $result += ['today_ot' => 1];
    $result += ['today_nt' => 1];
  } else {
    if (isset($result['chapter_ot']) && $result['chapter_ot'] > 0) {
      $result += ['today_ot' => 1];
    } elseif (isset($result['chapter_nt']) && $result['chapter_nt'] > 0) {
      $result += ['today_nt' => 1];
    }
  }

  // Проверяем старт
  if (!isset($result['today_ot']) || (isset($result['chapter_ot']) && $result['chapter_ot'] === 0)) {

    // ВЗ // AND `start` = 1
    $res_ot = db_query("SELECT DISTINCT *
      FROM `ftt_bible`
      WHERE `member_key` = '{$member_key}' AND `chapter_ot` <> 0 AND `date` <= '{$date}' AND `date` >= '{$start_date}'
      ORDER BY `date` ASC, `id` ASC");
    while ($row = $res_ot->fetch_assoc()) $result2 = $row;

    if (isset($result2['book_ot']) && isset($result['book_nt'])) {
      $result['book_ot'] = $result2['book_ot'];
      $result['chapter_ot'] = $result2['chapter_ot'];
    }
  }

  if (!isset($result['today_nt']) || (isset($result['chapter_nt']) && $result['chapter_nt'] === 0)) {
    // НЗ `start` = 1
    $res_nt = db_query("SELECT DISTINCT *
      FROM `ftt_bible`
      WHERE `member_key` = '$member_key' AND `chapter_nt` <> 0 AND `date` <= '{$date}' AND `date` >= '{$start_date}'
       ORDER BY `date` ASC, `id` ASC");
    while ($row = $res_nt->fetch_assoc()) $result3 = $row;

    if (isset($result3['book_nt']) && isset($result['book_ot'])) {
      $result['book_nt'] = $result3['book_nt'];
      $result['chapter_nt'] = $result3['chapter_nt'];
    } elseif(isset($result3['book_nt']) && !isset($result['book_ot']) && !isset($result2['book_nt'])) {
      $result = $result3;
    }

  }

if (count($result2) > 0 && !isset($result['chapter_ot'])) {
  $result = $result2;
  if (count($result3) > 0) {
    $result['book_nt'] = $result3['book_nt'];
    $result['chapter_nt'] = $result3['chapter_nt'];
  }
}

  if (count($result) === 0) {
    $result = 0;
  } else {
    $result += ['start_today' => $start_today];
  }

  return $result;
}

?>
