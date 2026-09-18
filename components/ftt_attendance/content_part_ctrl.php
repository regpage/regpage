<?php
require_once  '../private/vendor/autoload.php'; //ROOT_PATH .
use App\Infrastructure\Database\DbQuery;
$dbConnect = new DbQuery($db);
use App\Repositories\Ftt\Reading\FttReadingReadRepository;
use App\Repositories\Ftt\Reading\FttReadingWriteRepository;
use App\Repositories\Ftt\Param\FttParamReadRepository;

use App\Services\Ftt\Reading\FttReadingProgressService;
use App\Services\Ftt\Param\FttParamService;
use App\Services\Ftt\FttInfo\FttInfo;
use App\Support\Dates\DateConvert;

$semsterDateBegin = (new FttInfo(new FttParamService(new FttParamReadRepository($dbConnect))))->begin();
$fttReadingProgressService = new FttReadingProgressService(new FttReadingReadRepository($dbConnect), new FttReadingWriteRepository($dbConnect), $memberId);

// Устанавливаем Фильтр периода для получения листов посещаемости
$filter_period_att = 'week';
if (isset($_COOKIE['filter_period_att'])) {
  $filter_period_att = $_COOKIE['filter_period_att'];
}
// получаем листов посещаемости
$chaptersRead = $fttReadingProgressService->getChaptersRead($filter_period_att, DateConvert::ddmmyyyy_to_yyyymmdd($semsterDateBegin)); // ChaptersRead::get($memberId, $filter_period_att);
