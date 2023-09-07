<?php
// Ajax
include_once "ajax.php";

// подключаем запросы
include_once "../db/ftt/ftt_reading_db.php";

$adminId = db_getMemberIdBySessionId (session_id());

// bible reading
if (isset($_GET['type']) && $_GET['type'] === 'set_start_reading_bible') {
  echo json_encode(["result"=>set_start_reading_bible($_GET['member_key'], $_GET['date'], $_GET['chosen_book'], $_GET['book_ot'], $_GET['chapter_ot'], $_GET['footnotes_ot'], $_GET['book_nt'], $_GET['chapter_nt'], $_GET['footnotes_nt'])]);
  exit();
}

// bible reading set book & chapter
if (isset($_GET['type']) && $_GET['type'] === 'set_reading_bible') {
  echo json_encode(["result"=>set_reading_bible($_GET['member_key'], $_GET['date'], $_GET['book_field'], $_GET['book'], $_GET['chapter'])]);
  exit();
}

?>
