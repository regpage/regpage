<?php
require_once  '../private/vendor/autoload.php'; //ROOT_PATH .
use App\Infrastructure\Database\DbQuery;
$dbConnect = new DbQuery($db);
use App\Repositories\Ftt\Reading\FttReadingReadRepository;


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
  $read_book_arr = (new FttReadingReadRepository($dbConnect))->getAccordingLastStart($memberId);
  $read_book_arr = $read_book_arr['books'];
}
