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
  $start_date;
  $start_today = 0;
  $start_data = [];

  // получаем последнюю стартовую позицию
  $res = db_query("SELECT * FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `start` = 1 ORDER BY `date` DESC");
  while ($row = $res->fetch_assoc()) {
    $start_data = $row;
    $start_data['start'] = 0;
    break;
  }
  // если старт не указан возвращаем 0
  if (count($start_data) === 0) {
    return 0;
  }
  // если указанную дата больше старта
  if (strtotime($date) > strtotime($start_data['date'])) {
    $start_date = $start_data['date'];
  } else {
    $start_date = '0000-00-00';
  }

  // ИСТИНА если в указанную дату имеется стартовая позиция
  if ($start_data['date'] === $date) {
    $start_today = 1;
  }

  // запрашиваем данные на указанную дату
  $res = db_query("SELECT DISTINCT * FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '{$date}' AND `start` != 1");
  while ($row = $res->fetch_assoc()) $result = $row;

  // если на указанную дату поля заполненны
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

  // ВЗ получаем последнюю строку с заполненными даннными при условии что дата строки больше даты старта
  if (!isset($result['today_ot']) || (isset($result['chapter_ot']) && $result['chapter_ot'] === 0)) {

    $res_ot = db_query("SELECT DISTINCT *
      FROM `ftt_bible`
      WHERE `member_key` = '{$member_key}' AND `chapter_ot` <> 0 AND `date` > '{$start_date}' AND `date` <= '{$date}'
      ORDER BY `date` DESC");
    while ($row = $res_ot->fetch_assoc()){
      $result2 = $row;
      break;
    }
    // полученные данные записываем в результат если оба массива существуют
    if (isset($result2['book_ot']) && isset($result['book_nt'])) {
      $result['book_ot'] = $result2['book_ot'];
      $result['chapter_ot'] = $result2['chapter_ot'];
    }
    // сверка книг
    if (isset($result['book_ot']) || isset($result2['book_ot'])) {
      $sim = 0;
      if (isset($result2['book_ot']) && !empty($result2['book_ot'])) {
        $sim = 1;
      }
      if (isset($result['book_ot']) && !empty($result['book_ot'])) {
        $sim = 1;
      }
      if ($sim === 0) {
        if (isset($result['book_ot'])) {
          $result['book_ot'] = $start_data['book_ot'];
          $result['chapter_ot'] = $start_data['chapter_ot'];
        }
        if (isset($result2['book_ot'])) {
          $result2['book_ot'] = $start_data['book_ot'];
          $result2['chapter_ot'] = $start_data['chapter_ot'];
        }
      }
    }
  }

  if (count($result2) === 0 && count($result) === 0) {
    $result = $start_data;
  }
  // НЗ получаем последнюю строку с заполненными даннными при условии что дата строки больше даты старта
  if (!isset($result['today_nt']) || (isset($result['chapter_nt']) && $result['chapter_nt'] === 0)) {
    $res_nt = db_query("SELECT DISTINCT *
      FROM `ftt_bible`
      WHERE `member_key` = '$member_key' AND `chapter_nt` <> 0 AND `date` > '{$start_date}' AND `date` <= '{$date}'
       ORDER BY `date` DESC");
    while ($row = $res_nt->fetch_assoc()) {
      $result3 = $row;
      break;
    }

    if (isset($result3['book_nt']) && isset($result['book_ot'])) {
      $result['book_nt'] = $result3['book_nt'];
      $result['chapter_nt'] = $result3['chapter_nt'];
    } elseif(isset($result3['book_nt']) && !isset($result['book_ot']) && !isset($result2['book_nt'])) {
      $result = $result3;
    }
    // сверка книг
    if (isset($result['book_nt']) || isset($result2['book_nt'])) {
      $sim = 0;
      if (isset($result2['book_nt']) && !empty($result2['book_nt'])) {
        $sim = 1;
      }
      if (isset($result['book_nt']) && !empty($result['book_nt'])) {
        $sim = 1;
      }
      if ($sim === 0) {
        if (isset($result['book_nt'])) {
          $result['book_nt'] = $start_data['book_nt'];
          $result['chapter_nt'] = $start_data['chapter_nt'];
        }
        if (isset($result2['book_nt'])) {
          $result2['book_nt'] = $start_data['book_nt'];
          $result2['chapter_nt'] = $start_data['chapter_nt'];
        }
      }
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

// start position
function get_start_position($member_key)
{
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $result = [];
  $res = db_query("SELECT DISTINCT `book_ot`, `read_footnotes_nt`, `book_nt`, `read_footnotes_ot` FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `start` = 1 ORDER BY `date` ASC");
  while ($row = $res->fetch_assoc()) $result = $row;
  return $result;
}

function get_start_position_by_date($member_key, $date)
{
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $date = $db->real_escape_string($date);
  $result = [];
  $res = db_query("SELECT DISTINCT * FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `start` = 1 AND `date` = '{$date}' ORDER BY `date` ASC");
  while ($row = $res->fetch_assoc()) $result = $row;
  return $result;
}

function dlt_history_reading_bible($member_key, $ot, $nt)
{
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $ot = $db->real_escape_string($ot);
  $nt = $db->real_escape_string($nt);
  $condition = "";

  if (!empty($ot)) {
    $condition = " AND `book_ot` != ''";
  }
  if (!empty($nt)) {
    $condition .= " AND `book_nt` != ''";
  }

  if (!empty($ot) && !empty($nt)) {
    $condition = " AND (`book_nt` != '' OR `book_ot` != '')";
  }

  $res = db_query("DELETE FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `date` = '0000-00-00' {$condition}");
  return $res;
}

/**** СЛУЖАЩИЕ ****/
function getDataReadingForStaff($member_key)
{
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $result = [];
  $curent_date = [];
  $condition = "";
  $condition_old_str = "";
  $condition_trainee = "1";
  global $trainee_list_list;

  if ($member_key != '_all_') {
    $condition = " ft.serving_one = '{$member_key}' AND ";
    $condition_old_str = " AND ft.serving_one = '{$member_key}' ";
    $condition_trainee = " tr.serving_one = '{$member_key}' ";
  }

  $res = db_query("SELECT tr.member_key, m.name
    FROM ftt_trainee AS tr
    LEFT JOIN member m ON m.key = tr.member_key
    WHERE {$condition_trainee}
    ORDER BY m.name ASC");
  while ($row = $res->fetch_assoc()) $result[$row['member_key']] = [];

  for ($i=0; $i < 7; $i++) {
    $day_text = 6 - $i;
    $curent_date[date('Y-m-d', strtotime("-{$day_text} days"))] = '';
  }

  $res = db_query("SELECT fb.*, m.name, ft.serving_one
    FROM ftt_bible AS fb
    LEFT JOIN member m ON m.key = fb.member_key
    LEFT JOIN ftt_trainee ft ON ft.member_key = fb.member_key
    WHERE {$condition} fb.start != 1 AND fb.date != '0000-00-00' AND (fb.date > CURDATE() - INTERVAL 7 DAY) ORDER BY m.name ASC, fb.date ASC");
  while ($row = $res->fetch_assoc()) {
    if (empty($result[$row['member_key']])) {
      $result[$row['member_key']] = $curent_date;
    }
    $result[$row['member_key']][$row['date']] = $row;
  }

  $resLastDate = db_query("SELECT fb.*, m.name, ft.serving_one
    FROM ftt_bible AS fb
    LEFT JOIN member m ON m.key = fb.member_key
    LEFT JOIN ftt_trainee ft ON ft.member_key = fb.member_key
    WHERE fb.start != 1 AND fb.date != '0000-00-00' {$condition_old_str} ORDER BY fb.date DESC"); //m.name ASC,
  while ($row = $resLastDate->fetch_assoc()) {
    if (empty($result[$row['member_key']])) {
      $result[$row['member_key']][$row['date']] = $row;
    }
  }

  foreach ($result as $key => $value) {
    if (empty($value)) {
      $result[$key] = array('0000-00-00' => array(
        'name' => $trainee_list_list[$key]['name'], 'serving_one' => $trainee_list_list[$key]['serving_one'], 'id' =>'', 'member_key' =>'', 'book_nt' =>'',
        'chapter_nt' =>'', 'read_footnotes_nt' =>'', 'book_ot' =>'', 'chapter_ot' =>'',
        'read_footnotes_ot' =>'', 'date' =>'', 'start' =>''
      ));
    }
  }

  return $result;
}

function getHistoryReadingTrainee($member_key)
{
  global $db;
  $member_key = $db->real_escape_string($member_key);
  $result = [];
  $res = db_query("SELECT * FROM `ftt_bible` WHERE `member_key` = '{$member_key}' AND `start` != 1 AND `date` != '0000-00-00' ORDER BY `date`");
  while ($row = $res->fetch_assoc()) $result[] = $row;

  return $result;
}
