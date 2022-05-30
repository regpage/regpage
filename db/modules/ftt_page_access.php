<?php
// Доступ до раздела ПВОМ
foreach (db_getServiceonesPvomZone() as $key => $value) {
  if ($memberId === $key) {
    //$Serviceones_pvom = $key;
    $accessToPage = 3;
  }
}

// Проверка рекомендатора
if ($accessToPage === 0 && db_getRecommender($memberId)) {
  $accessToPage = 1;
}

// Проверка собеседующего
if ($accessToPage === 0 &&  db_getInterviewer($memberId)) {
  $accessToPage = 2;
}

// Проверка разработчика
if ($accessToPage === 0 && ($memberId === '000005716' || $memberId === '000001679')) {
  $accessToPage = 4;
}

?>
