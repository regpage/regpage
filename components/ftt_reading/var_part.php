<?php
// РАЗДЕЛ ЧТЕНИЕ
// DB
include_once 'db/classes/ftt_reading/book_read.php';
// Classes
include_once 'db/classes/ftt_reading/bible.php';
$bible_obj = new Bible;
$trainee_data = [];
$read_book_arr = [];
$book_current = [];
$disabled_ot = '';
$disabled_nt = '';
if ($ftt_access['group'] === 'trainee') {
  $trainee_data = trainee_data::get_data($memberId);
  //bible books
  $read_book_arr = BookRead::get_all($memberId);
}
