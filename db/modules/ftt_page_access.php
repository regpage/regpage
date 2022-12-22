<?php
// Доступ до раздела ЗАЯВЛЕНИЯ
include_once 'db/classes/ftt_lists.php';
$serviceones_pvom = ftt_lists::serving_ones();
foreach ($serviceones_pvom as $key => $value) {
  if ($memberId === $key) {
    $accessToPage = 3;
  }
}

// Проверка разработчика
if ($memberId === '000005716') {
  $accessToPage = 4;
}

?>
