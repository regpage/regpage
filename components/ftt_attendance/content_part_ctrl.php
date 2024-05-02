<?php
// Устанавливаем Фильтр периода для получения листов посещаемости
$filter_period_att = 'week';
if (isset($_COOKIE['filter_period_att'])) {
  $filter_period_att = $_COOKIE['filter_period_att'];
}
// получаем листов посещаемости
$chaptersRead = ChaptersRead::get($memberId, $filter_period_att);
