<?php
// **** ВОСКРЕСНЫЙ КРОН проверка бланков пророчествования cronprophecy.php ****//
// право доступа
//require_once 'cronkey.php';

// нужные классы
include_once 'config.php';
include_once 'db/classes/ftt_info.php';

function prophecyCheck()
{
  // добавить в отчёт об исполнении кронов
  // поведение на перерыве
  if (ftt_info::pause()) {
    // отметка о выполнении
    db_query("INSERT INTO `cron` (`date`,`script`, `status`, `comment`) VALUES (CURRENT_DATE(),'{$_SERVER['PHP_SELF']}', '1', 'Вне периода')");
    echo "Вне периода проведения обучения";
    exit();
  }

  $traineeKeysToCreateExtrahelp = [];
  // получаем тех кто не на паузе и не отправил бланк на текущее число
  $res = db_query("SELECT ft.member_key FROM ftt_trainee ft WHERE NOT EXISTS (SELECT fp.member_key FROM ftt_prophecy fp WHERE ft.member_key = fp.member_key AND (DATE_FORMAT(fp.send_date, '%Y-%m-%d') = (CURDATE() - INTERVAL 1 DAY) OR DATE_FORMAT(fp.send_date, '%Y-%m-%d') = CURDATE())) AND (ft.pause_start IS NULL OR ft.pause_start > (CURDATE() - INTERVAL 1 DAY) OR ft.pause_stop < (CURDATE() - INTERVAL 1 DAY))");
  while ($row = $res->fetch_assoc()) $traineeKeysToCreateExtrahelp[]=$row['member_key'];

  // нет ключе обучающихся для создания доп помощи
  if (count($traineeKeysToCreateExtrahelp) === 0) {
    echo "Не добавлены доп. задания при проверке бланко пророчествования";
    exit();
  }

  // нет ключе обучающихся для создания доп помощи
  if (count($traineeKeysToCreateExtrahelp) > 0) {
    echo "Проверка сдачи бланка пророчества (воскресенье до 18:00). Создана доп. помощь (" . count($traineeKeysToCreateExtrahelp) . ") для обучающихся: ";
    foreach ($traineeKeysToCreateExtrahelp as $value) {
      $reason = "Не отправлен вовремя бланк пророчествования " . date('d.m');
      db_query("INSERT INTO ftt_extra_help (`date`, `member_key`, `reason`, `changed`)
      VALUES (NOW(), '{$value}', '{$reason}', 1)");
      echo "{$value}, ";
    }
    // отметка об исполнении
    db_query("INSERT INTO `cron` (`date`,`script`, `status`, `comment`) VALUES (CURRENT_DATE(),'{$_SERVER['PHP_SELF']}', '1', 'Проверка сдачи бланка пророчества')");
    exit();
  }
  echo "Непредвиденная ошибка.";
}

prophecyCheck();
