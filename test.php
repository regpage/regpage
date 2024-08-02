<?php
if ($_GET['key'] !== '115') {
  exit;
}

// тестированние классов работающих с базой данных
require_once 'config.php';
// вывод результатов на экран
require_once 'cases/rendering_result.php';
// DBQuery класс, однотабличный запрос к базе данных, обычно с одиним условием, возвращает массив или строку
require_once 'cases/db/db001.php';
