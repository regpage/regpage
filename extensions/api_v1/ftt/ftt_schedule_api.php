<?php
include_once __DIR__.'/../../../db/classes/ftt_param.php';
require_once __DIR__.'/../../../db/classes/schedule_class.php';
// расписание 1-4 семестра сегодня
if (isset($_GET['condition']) && $_GET['condition'] = 'today') {
  echo json_encode(["result"=>schedule_class::get(1, '02', date('Y-m-d'), 'day' . date('N'))]);
}
