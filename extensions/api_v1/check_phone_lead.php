<?php
// получаем все невзятые в работу лиды
$link = 'https://bibleforall.envycrm.com/crm/api/v1/lead/list/?api_key=ecdfd3e079da4ab92942a50d8dd67991b5878f21';
// данные для запроса в срм
$data = [
  'limit' => 0,
  'offset' => 0,
  'date_start' => "2025-01-01",
  'date_end' => date('Y-m-d'),
  'date_type' => 'created',
  'stage_id' => 67773
];
// подключаем curl
require 'extensions/api_v1/sender.php';
// разбираем ответ
echo $out;
