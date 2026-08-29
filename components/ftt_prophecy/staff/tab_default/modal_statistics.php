<?php
require_once '../private/vendor/autoload.php';

use App\Controllers\Ftt\Trainee\TraineeCtrl;
use App\Services\Ftt\Param\FttParamService;
use App\Repositories\Ftt\Param\FttParamReadRepository;
use App\Controllers\Ftt\Reports\ProphecyReport;
use App\Ui\Components\Modal\ModalRenderer;
use App\Ui\Components\Element\ButtonCloseRenderer;

// убрать в контроллер
$prophecyTraineesFilter='';
$prophecyStaffFilter='';
if (!empty($_COOKIE['prophecy_staff-flt_list_trainees'])) {
  $prophecyTraineesFilter = $_COOKIE['prophecy_staff-flt_list_trainees'];
}

if (!empty($_COOKIE['prophecy_staff-flt_list_servingone'])) {
  $prophecyStaffFilter = $_COOKIE['prophecy_staff-flt_list_servingone'];
}

$traineesListForStatistics = [];
if (!empty($_COOKIE['prophecy_staff-flt_list_trainees']) && $_COOKIE['prophecy_staff-flt_list_trainees'] !== '_all_') {
  $traineesListForStatistics = [$_COOKIE['prophecy_staff-flt_list_trainees']];
} elseif (!empty($_COOKIE['prophecy_staff-flt_list_servingone']) && $_COOKIE['prophecy_staff-flt_list_servingone'] !== '_all_') {
  $traineesListForStatistics = (new TraineeCtrl())->getTraineesListByServingone($_COOKIE['prophecy_staff-flt_list_servingone']);
}

$fttCurrentPeriod = (new FttParamService(new FttParamReadRepository()))->getPeriodScheduleCurrentSemester(true);

$modalStatistic = (new ProphecyReport(['start' => $fttCurrentPeriod['schedule_start'],'end' => $fttCurrentPeriod['schedule_end']], $traineesListForStatistics))->render();

echo (new ModalRenderer('modal_statistics_md', 'Статистика пророчествования', $modalStatistic, (new ButtonCloseRenderer)->render()))->render();
