<?php
// Ajax
include_once "ajax.php";

// подключаем запросы
include_once '../db/classes/ftt_info.php';
include_once '../db/classes/ftt_reading/bible.php';
include_once '../db/classes/ftt_reading/book_read.php';
include_once '../db/classes/statistic/biblecounter.php';
include_once "../db/ftt/ftt_reading_db.php";
include_once '../db/classes/ftt_lists.php';

$adminId = db_getMemberIdBySessionId (session_id());
if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// bible reading start position
if (isset($_GET['type']) && $_GET['type'] === 'set_start_reading_bible') {
  echo json_encode(["result"=>set_start_reading_bible($_GET['member_key'], $_GET['date'], $_GET['chosen_book'], $_GET['book_ot'], $_GET['chapter_ot'], $_GET['footnotes_ot'], $_GET['book_nt'], $_GET['chapter_nt'], $_GET['footnotes_nt'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'get_start_reading_bible') {
  echo json_encode(["result"=>get_start_position_by_date($_GET['member_key'], $_GET['date'])]);
  exit();
}

// bible reading set book & chapter
if (isset($_GET['type']) && $_GET['type'] === 'set_reading_bible') {
  echo json_encode(["result"=>set_reading_bible($_GET['member_key'], $_GET['date'], $_GET['book_field'], $_GET['book'], $_GET['chapter'], $_GET['notes_ot'], $_GET['notes_nt'])]);
  exit();
}

// bible reading get book & chapter statistics
if (isset($_GET['type']) && $_GET['type'] === 'get_read_book') {
  echo json_encode(["result"=>get_read_book($_GET['member_key'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'get_reading_data') {
  echo json_encode(["result"=>get_reading_data($_GET['member_key'], $_GET['date'])]);
  exit();
}

// bible reading set book statistics
if (isset($_GET['type']) && $_GET['type'] === 'set_read_book') {
  echo json_encode(["result"=>set_read_book($_GET['member_key'], $_GET['part'], $_GET['book'], $_GET['chapter'], $_GET['checked'])]);
  exit();
}

// bible reading set book statistics
if (isset($_GET['type']) && $_GET['type'] === 'set_read_book_by_book') {
  echo json_encode(["result"=>set_read_book_by_book($_GET['member_key'], $_GET['part'], $_GET['books'], $_GET['notes'], $_GET['set'])]);
  exit();
}

// delete history bible reading
if (isset($_GET['type']) && $_GET['type'] === 'dlt_history_reading_bible') {
  echo json_encode(["result"=>dlt_history_reading_bible($_GET['member_key'], $_GET['ot'], $_GET['nt'])]);
  exit();
}
// get history bible reading for trainee
if (isset($_GET['type']) && $_GET['type'] === 'get_history_reading_bible') {
  echo json_encode(["result"=>getHistoryReadingTrainee($_GET['member_key'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'get_start_position') {
  if (isset($_GET['both'])) {
    echo json_encode(["result"=>get_start_position($_GET['member_key'], $_GET['both'])]);
  } else {
    echo json_encode(["result"=>get_start_position($_GET['member_key'])]);
  }
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'check_read_book') {
  echo json_encode(["result"=>checkReadBook($_GET['member_key'], $_GET['book'], $_GET['footnotes'], $_GET['ot'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'get_read_books') {
  echo json_encode(["result"=>BookRead::get_all($_GET['member_key'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'get_reading_statistic_semester') {
  $bibleBooks = new Bible();
  $results = [];
  foreach (ftt_lists::trainee_full_by_staff($_GET['filter']) as $key => $value) {
    $results[$key] = ['trainee'=>$value, 'reading'=>BookRead::get_all($key) , 'books' => $bibleBooks->get(), 'start' => get_start_position($key)];
  }
  echo json_encode(["result"=>$results]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'get_bible_deff') {
  echo json_encode(["result"=>BibleCounter::calculateTheDifference($_GET['trainee_id'], $_GET['semester'])]);
  exit();
}
