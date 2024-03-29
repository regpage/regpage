<?php
// Ajax
include_once "ajax.php";

// подключаем запросы
include_once "../db/ftt/ftt_reading_db.php";
include_once '../db/classes/ftt_reading/bible.php';

$adminId = db_getMemberIdBySessionId (session_id());

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
  echo json_encode(["result"=>get_start_position($_GET['member_key'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'check_read_book') {
  echo json_encode(["result"=>checkReadBook($_GET['member_key'], $_GET['book'], $_GET['footnotes'], $_GET['ot'])]);
  exit();
}
