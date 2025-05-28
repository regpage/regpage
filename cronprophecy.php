<?php
// **** ВОСКРЕСНЫЙ КРОН проверка бланков пророчествования cronprophecy.php ****//
// право доступа
require_once 'cronkey.php';

// нужные классы
include_once 'config.php';

function prophecyCheck()
{
  $result = [];
  $res = db_query("SELECT ft.member_key, fp.send_date
    FROM  ftt_trainee ft
    LEFT JOIN ftt_prophecy fp ON fp.member_key = ft.member_key
    WHERE DATE_FORMAT(fp.send_date, '%Y-%m-%d') = CURDATE()");
  while ($row = $res->fetch_assoc()) $result[]=$row['member_key'];


  $condition = '';
  foreach ($result as $value) {
    if (empty($condition)) {
      $condition = "'{$value}'";
    } else {
      $condition .= ",'{$value}'";
    }
  }

  $extrahelp = [];
  $res2 = db_query("SELECT member_key FROM ftt_trainee WHERE member_key NOT IN ($condition)");
  while ($row = $res2->fetch_assoc()) $extrahelp[]=$row['member_key'];

  if (count($extrahelp) > 0) {
    echo "Проверка сдачи бланка пророчества (воскресенье до 18:00). Создана доп. помощь для обучающихся: ";
  }
  foreach ($extrahelp as $value) {
    echo "{$value}, ";
    $reason = '';
    $reason = "Не отправлен вовремя бланк пророчествования " . date('d.m');
    db_query("INSERT INTO ftt_extra_help (`date`, `member_key`, `reason`, `changed`)
    VALUES (NOW(), '{$value}', '{$reason}', 1)");
    echo "{$value}, ";
  }
}
prophecyCheck();
