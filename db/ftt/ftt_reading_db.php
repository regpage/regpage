<?php
// reading bible page
function set_start_reading_bible($member_key, $date, $chosen_book='', $book_ot='', $chapter_ot='', $footnotes_ot='', $book_nt='', $chapter_nt='', $footnotes_nt='')
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
  $footnotes_nt = $db->real_escape_string($footnotes_nt);
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

function set_reading_bible($member_key, $date, $book_field, $book, $chapter, $notes_ot, $notes_nt)
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
    $notes_ot_field = 'read_footnotes_ot';
    $footnotes = $notes_ot;
  } else {
    $chapter_field = 'chapter_nt';
    $notes_ot_field = 'read_footnotes_nt';
    $footnotes = $notes_nt;
  }

  if (!isset($result['id'])) {
    $res = db_query("INSERT INTO `ftt_bible` (`member_key`, `date`, `$book_field`, `$chapter_field`, `$notes_ot_field`)
     VALUES ('$member_key', '$date', '$book', '$chapter', '$footnotes')");
  } else {
    $res = db_query("UPDATE `ftt_bible`
      SET `member_key` = '$member_key', `$book_field` = '$book', `$chapter_field` = '$chapter', `$notes_ot_field` = '$footnotes'
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

/*** bible read check GET ***/
// Данные с отметной С ПРИМЕЧАНИЯМИ, отдельная статистика?

function get_read_book($member_key)
{
  $bible_obj = new Bible;
  global $db;
  $member_key = $db->real_escape_string($member_key);

  $result = [];
  $res = db_query("SELECT * FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' AND `book_ot` != '' AND `chapter_ot` > 0");
  while ($row = $res->fetch_assoc()) $result[] = [$row['book_ot'], $row['chapter_ot'], 0];

  $res6 = db_query("SELECT * FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' AND `book_nt` != '' AND `chapter_nt` > 0");
  while ($row = $res6->fetch_assoc()) $result[] = [$row['book_nt'], $row['chapter_nt'], 0];

  $result2 = [];
  $res2 = db_query("SELECT DISTINCT `book_ot`  FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` != '0000-00-00' ");
  while ($row = $res2->fetch_assoc()) $result2[] = $row['book_ot'];

  $result3 = [];
  $res3 = db_query("SELECT DISTINCT `book_nt`  FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` != '0000-00-00' ");
  while ($row = $res3->fetch_assoc()) $result3[] = $row['book_nt'];

  // отбираем
  $result4 = [];
  $bible_books = $bible_obj->get();
  if (!empty($result2)) {
    foreach ($result2 as $value) {
      $id_book_ot = '';
      foreach ($bible_books as $key_2 => $value_2) {
        if ($value_2[0] === $value) {
          $id_book_ot = $value_2[1];
          break;
        }
      }
      /*$res4 = db_query("SELECT DISTINCT `chapter_ot`  FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` != '0000-00-00' AND `book_ot`= '{$value}' AND `chapter_ot`= '{$id_book_ot}'");
      while ($row = $res4->fetch_assoc()) $result4[] = [$value, $row['chapter_ot'], 1];*/
    }
  }

  if (!empty($result3)) {
    foreach ($result3 as $key => $value) {
      $id_book_nt = '';
      foreach ($bible_books as $key_2 => $value_2) {
        if ($value_2[0] === $value) {
          $id_book_nt = $value_2[1];
          break;
        }
      }

      /*$res5 = db_query("SELECT DISTINCT `chapter_nt`  FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` != '0000-00-00' AND `book_nt`= '{$value}' AND `chapter_nt`= '{$id_book_nt}'");
      while ($row = $res5->fetch_assoc()) $result4[] = [$value, $row['chapter_nt'], 1];*/
    }
  }
  //return $result4;

  $result = array_merge($result, $result4);
  return $result;
}

function set_read_book($member_key, $part, $book, $chapter, $checked)
{
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $part = $db->real_escape_string($part);
  $book = $db->real_escape_string($book);
  $chapter = $db->real_escape_string($chapter);
  $checked = $db->real_escape_string($checked);
  $id_check = '';
  $id_read = '';

  if ($part === 'ot') {
    $book_field = 'book_ot';
    $chapters_field = 'chapter_ot';
  } else {
    $book_field = 'book_nt';
    $chapters_field = 'chapter_nt';
  }

  $res = db_query("SELECT `id` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' AND `{$book_field}` = '{$book}'");
  while ($row = $res->fetch_assoc()) $id_check = $row['id'];
  /*if (empty($id_check)) {
    $res = db_query("SELECT `id` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` != '0000-00-00' AND `{$book_field}` = '{$book}' AND `{$chapters_field}` = '{$chapter}'");
    while ($row = $res->fetch_assoc()) $id_read = $row['id'];
  }*/

  if ($checked === 'true') {
    if (!$id_check) { // && !$id_read
      $res = db_query("INSERT INTO `ftt_bible` (`member_key`, `{$book_field}`, `{$chapters_field}`)
      VALUES ('{$member_key}', '{$book}', '{$chapter}')");
    }
  } else {
    if ($id_check) {
      $res = db_query("DELETE FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' AND `{$book_field}` = '{$book}'");
    }
  }
  return $res;
}

function set_read_book_by_book($member_key, $part, $books, $notes, $set)
{
  global $db;
  $bible_obj = new Bible;
  $member_key = $db->real_escape_string($member_key);
  $part = $db->real_escape_string($part);
  $books = $db->real_escape_string($books);
  $notes = $db->real_escape_string($notes);
  $set = $db->real_escape_string($set);
  $bible_books = $bible_obj->get();
  $books = explode(',', $books);

  if ($part === 'ot') {
    $book_field = 'book_ot';
    $chapters_field = 'chapter_ot';
    $notes_field = 'read_footnotes_ot';
  } else {
    $book_field = 'book_nt';
    $chapters_field = 'chapter_nt';
    $notes_field = 'read_footnotes_nt';
  }

  if ($set == 1) {
    for ($i=0; $i < count($books); $i++) {
      $id_check = '';
      $bible_book = $bible_books[$books[$i]];
      // check
      $res = db_query("SELECT `id`
        FROM `ftt_bible`
        WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' AND `{$book_field}` = '{$bible_book[0]}'
        AND `{$chapters_field}` = '{$bible_book[1]}' AND `{$notes_field}` = '{$notes}'");
      while ($row = $res->fetch_assoc()) $id_check = $row['id'];
      // set
      if (empty($id_check)) {
        $res = db_query("INSERT INTO `ftt_bible` (`member_key`, `{$book_field}`, `{$chapters_field}`, `{$notes_field}`) VALUES ('{$member_key}', '{$bible_book[0]}', '{$bible_book[1]}', '{$notes}')");
      }
    }
  } else {
    for ($i=0; $i < count($books); $i++) {
      $bible_book = $bible_books[$books[$i]];
      // dlt
      $res = db_query("DELETE FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' AND `{$book_field}` = '{$bible_book[0]}'
      AND `{$chapters_field}` = '{$bible_book[1]}' AND `{$notes_field}` = '{$notes}'");
    }
  }

  return $res;
}


function get_start_position($member_key)
{
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $result = [];
  $res = db_query("SELECT DISTINCT `book_ot`, `read_footnotes_nt`, `book_nt`, `read_footnotes_ot` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `start` = 1 ORDER BY `date` ASC");
  while ($row = $res->fetch_assoc()) $result = $row;
  return $result;
}
