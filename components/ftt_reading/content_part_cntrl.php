<?php
require_once 'db/classes/ftt_info.php';
include_once 'db/classes/statistic/biblecounter.php';

//define('ROOT_PATH', dirname(__DIR__, 3));
require  '../private/vendor/autoload.php'; //ROOT_PATH .
use App\Infrastructure\Database\DbQuery;
$dbConnect = new DbQuery($db);
use App\Repositories\Ftt\Reading\FttReadingReadRepository;
use App\Repositories\Ftt\Reading\FttReadingWriteRepository;
use App\Repositories\Ftt\Reading\BibleReadRepository;
use App\Services\Ftt\Reading\FttReadingStartStopService;
use App\Services\Ftt\Reading\FttReadingLastService;
use App\Services\Ftt\Reading\FttReadingProgressService;
use App\Services\Ftt\Reading\FttReadingFinishService;
use App\Services\Ftt\Reading\BibleService;
use App\Services\Ftt\Reading\BibleCounterService;
use App\Services\Ftt\Param\FttParamService;
use App\Repositories\Ftt\Param\FttParamReadRepository;
use App\Services\Ftt\FttInfo\FttInfo;

$readRepository = new FttReadingReadRepository($dbConnect);
$writeRepository = new FttReadingWriteRepository($dbConnect);
$bibleRepository = new BibleReadRepository($dbConnect);
$paramRepository = new FttParamReadRepository($dbConnect);

$paramService = new FttParamService($paramRepository);
$fttInfo = new FttInfo($paramService);
$startService = new FttReadingStartStopService($readRepository, $memberId);
$read_bible_books = (new FttReadingFinishService($readRepository, $memberId))->getReadBooksForList();
$bible_obj = new BibleService($bibleRepository);
$bible_books = $bible_obj->get();
$book_current = (new FttReadingProgressService($readRepository, $writeRepository, $memberId))->getReadingPair(date('Y-m-d')); // get_reading_data($memberId, date('Y-m-d'))
$last_reading = (new FttReadingLastService($readRepository, $memberId))->getLastReadingPair(
  $startService->getLastPositionLessDateOt(date('Y-m-d')),
  $startService->getLastPositionLessDateNt(date('Y-m-d')),
  date('Y-m-d'));
$startReading = $startService->doesStartedLessDatePair(date('Y-m-d'));

$bible_reading_calculate = (new BibleCounterService($bibleRepository, $memberId))->calculateTheDifference($trainee_data['semester'], $fttInfo->daysLeftInAcademicYear(), $bible_obj);

$tempEmptyBookCurrent = ['book' => '', 'chapter' => '', 'footnotes' => '', 'id'=>''];
if (empty($book_current['ot'])) {
  $book_current['ot'] = $tempEmptyBookCurrent;
  if (isset($last_reading['ot']['book']) && $startReading['ot'] == 1) {
    $book_current['ot']['book'] = $last_reading['ot']['book'];
    $book_current['ot']['chapter'] = $last_reading['ot']['chapter'];
    $book_current['ot']['footnotes'] = $last_reading['ot']['footnotes'];
  }
}
if (empty($book_current['nt'])) {
  $book_current['nt'] = $tempEmptyBookCurrent;
  if (isset($last_reading['nt']['book']) && $startReading['nt'] == 1) {
    $book_current['nt']['book'] = $last_reading['nt']['book'];
    $book_current['nt']['chapter'] = $last_reading['nt']['chapter'];
    $book_current['nt']['footnotes'] = $last_reading['nt']['footnotes'];
  }
}

$disabled_ot = '';
$disabled_nt = '';
$disabled = '';
if ($startReading['ot'] != 1) {
  $disabled_ot = 'disabled';
}
if ($startReading['nt'] != 1) {
  $disabled_nt = 'disabled';
}
/*
if ($book_current['start_today'] == 1) {
  $disabled = 'disabled';
  $disabled_ot = 'disabled';
  $disabled_nt = 'disabled';
}
*/
