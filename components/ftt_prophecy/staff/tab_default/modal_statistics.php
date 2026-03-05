<?php
require '../private/src/model/ftt/ftt_prophecy/ftt_prophecy_statistic.php';
require '../private/src/ui/base/base_list_render.php';
require '../private/src/ui/components/list/render_list_by_template.php';
require '../private/src/ui/base/html_components.php';
require '../private/src/ui/components/modal/render_modal.php';
require '../private/src/utils/tolog.php';
require '../private/src/utils/sanitizer.php';
require '../private/src/ui/components/render_button.php';

$modalStatisticsData = new FttProphecyStatistic(['attendance_start' => '2025-09-01','attendance_end' => '2025-12-17']);
 //$modalStatisticsDataList = (new RenderListByTemplate((new FttProphecyStatistic(['attendance_start' => '2025-09-01','attendance_end' => '2025-12-17']))->getStatistic(), '<div>{name} — {has_prophecy}/{total}</div>'))->get();

$modalStatistic = '<h5>Братья</h5>';
$modalStatistic .= (new RenderListByTemplate($modalStatisticsData->getBrothers(), '<div>{name} — {has_prophecy}/{total}</div>'))->get();
$modalStatistic .= '<h5 class="mt-2">Сёстры</h5>';
$modalStatistic .= (new RenderListByTemplate($modalStatisticsData->getSisters(), '<div>{name} — {has_prophecy}/{total}</div>'))->get();
$modalStatistic .= '<hr>';
$modalStatistic .= (new RenderListByTemplate($modalStatisticsData->getCroupStatistic(), '<div class="mt-2">{text} {names}</div>'))->get();

echo (new ModalRenderer('modal_statistics_md', 'Статистика пророчествования', $modalStatistic, (new ButtonCloseRenderer)->render()))->render();
