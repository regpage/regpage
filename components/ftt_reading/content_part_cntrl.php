<?php
require_once 'db/classes/ftt_info.php';
include_once 'db/classes/statistic/biblecounter.php';

$read_bible_books = get_read_book($memberId);
$bible_books = $bible_obj->get();
$book_current = get_reading_data($memberId, date('Y-m-d'));
$bible_reading_calculate = BibleCounter::calculateTheDifference($memberId, $trainee_data['semester']);
$disabled_ot = '';
$disabled_nt = '';
$disabled = '';
if (empty($book_current['book_ot'])) {
  $disabled_ot = 'disabled';
}
if (empty($book_current['book_nt'])) {
  $disabled_nt = 'disabled';
}
if ($book_current['start_today'] == 1) {
  $disabled = 'disabled';
  $disabled_ot = 'disabled';
  $disabled_nt = 'disabled';
}
