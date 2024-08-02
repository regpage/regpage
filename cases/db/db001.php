<?php
/**
* КЕЙС DB
* db001
*/
require_once 'db/classes/common/db_query.php';

echo "<div><b>Test db001</b></div>";
// получаем строку c =
$case = 'db001->case 1';
$res = DBQuery::get('str', 'member', 'key', 'key', '000005716', '=');
$expected = '000005716';

// проверка
if ($res === $expected) {
  RenderingResult::ok($case);
} else {
  RenderingResult::failure($case, $expected, $res);
}

// получаем массив c "LIKE"
$case = 'db001->case 2';
$res = DBQuery::get('arr', 'member', 'key', 'key', '000005716', 'LIKE');
$expected = 'is_array($res) === true && count($res) === 1';

// проверка
if (is_array($res) && count($res) === 1) {
  RenderingResult::ok($case);
} else {
  RenderingResult::failure($case, $expected, $res);
}

// получаем строку значения по умолчанию "="
$case = 'db001->case 3';
$res = DBQuery::get('str', 'member', 'key', 'key', '000005716');
$expected = '000005716';

// проверка
if ($res === $expected) {
  RenderingResult::ok($case);
} else {
  RenderingResult::failure($case, $expected, $res);
}

// получаем массив cо значениями по умолчанию
$case = 'db001->case 4';
$res = DBQuery::get('arr', 'bible', 'id');
$expected = 'is_array($res) === true && count($res) === 66';

// проверка
if (is_array($res) && count($res) === 66) {
  RenderingResult::ok($case);
} else {
  RenderingResult::failure($case, $expected, $res);
}

// получаем массив проверяем сортировку убывание
$case = 'db001->case 5';
$res = DBQuery::get('arr', 'bible', 'id', '', '', '', 'id', true);
$expected = 'is_array($res) === true && count($res) === 66 && $res[0] === "66"';

// проверка
if (is_array($res) && count($res) === 66 && $res[0] === '66') {
  RenderingResult::ok($case);
} else {
  RenderingResult::failure($case, $expected, $res);
}

// получаем массив проверяем сортировку возрастание
$case = 'db001->case 6';
$res = DBQuery::get('arr', 'bible', 'id', '', '', '', 'id');
$expected = 'is_array($res) === true && count($res) === 66 && $res[0] === "1"';

// проверка
if (is_array($res) && count($res) === 66 && $res[0] === '1') {
  RenderingResult::ok($case);
} else {
  RenderingResult::failure($case, $expected, $res);
}

//дописывается в пареметр $fieldCondition напр. 'type = '1' AND name'

// ошибочный запрос запрашивается нсуществующая таблица, ПРЕРЫВАЕТ ВЫПОЛНЕНИЕ КОДА, ошибка появляется в журнале, альтернатива перехват
/*
$case = 'db001->case 7';
$res = DBQuery::get('', 'member_member', 'key');
$expected = '000005716';

// проверка
if ($res === $expected) {
  RenderingResult::ok($case);
} else {
  RenderingResult::failure($case, $expected, $res);
}
*/
