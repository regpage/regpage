<?php
// **** ВОСКРЕСНЫЙ КРОН проверка бланков пророчествования cronprophecy.php ****//
// право доступа
require_once 'cronkey.php';

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
  // получаем спец. список с указанием причины отсутствия.
  // последовательность
  /*
    1. Исключаем сдавших
    2. исключаем на перерыве
    3. исключаем согласно листам отсутствия
  */
  // 1. Исключаем сдавших
  //  список исключений
  /*
  $traineeKeysWhoIsOK = [];
  $traineeKeysWhoIsOKText = '';
  $res5 = db_query(("SELECT DISTINCT `member_key` FROM `ftt_prophecy` WHERE DATE_FORMAT(`send_date`, '%Y-%m-%d') = CURDATE()");
    while ($row = $res5->fetch_assoc()) $traineeKeysWhoIsOK[]= "'{$row['member_key']}'";

  if (count($traineeKeysWhoIsOK) > 0) {
    $traineeKeysWhoIsOKText = ' NOT IN (' . implode(',', $traineeKeysWhoIsOK) . ') AND ';
  }
  // 2 исключаем на перерыве
  $traineeKeysOnPause=[];
  $res4 = db_query("SELECT `member_key` FROM `ftt_trainee`
    WHERE {$traineeKeysWhoIsOKText} `pause_start` IS NOT NULL AND `pause_start` <= CURDATE() AND (`pause_stop` IS NULL OR `pause_stop` >= CURDATE())");
    while ($row = $res4->fetch_assoc()) {
      // добавляем ключи обучающихся, кандидатов на доп. занание
      $traineeKeysOnPause[$row['member_key']]='';
      // дополняем список исключений
      $traineeKeysWhoIsOK[]="'{$row['member_key']}'";
    }

  if (count($traineeKeysOnPause) > 0) {
    $traineeKeysWhoIsOKText = ' NOT IN (' . implode(',', $traineeKeysWhoIsOK) . ') AND ';
  }

  // 3. исключаем согласно листам отсутствия
  $traineeKeysPermissions = [];
  $res3 = db_query(("SELECT DISTINCT `member_key`, `status` FROM `ftt_permission_sheet` WHERE NOT IN ({$traineeKeysWhoIsOKText}) AND DATE_FORMAT(absence_date, '%Y-%m-%d') = CURDATE() AND `status` = 2");
    while ($row = $res3->fetch_assoc()) {
      $traineeKeysPermissions[$row['member_key']]=$row['status'];
      $traineeKeysWhoIsOK[]="'{$row['member_key']}'";
    }

  if (count($traineeKeysPermissions) > 0) {
    $traineeKeysWhoIsOKText = ' NOT IN (' . implode(',', $traineeKeysWhoIsOK) . ') AND ';
  }

  $res6 = db_query(("SELECT `member_key` FROM `ftt_trainee` WHERE NOT IN {$traineeKeysWhoIsOKText}");
    while ($row = $res5->fetch_assoc()) $traineeKeysToCreateExtrahelp[]= $row['member_key'];
*/
//$traineeKeysToCreateExtrahelp
  // проверка в воскресенье
  $res = db_query("SELECT ft.member_key as ft_member_key FROM ftt_trainee ft
    WHERE NOT EXISTS (SELECT fp.member_key FROM ftt_prophecy fp WHERE fp.member_key = ft.member_key AND DATE_FORMAT(fp.send_date, '%Y-%m-%d') = CURDATE())
    AND (ft.pause_start IS NULL OR (ft.pause_start IS NOT NULL AND ft.pause_start > CURDATE()) OR (ft.pause_stop IS NOT NULL AND ft.pause_stop < CURDATE()))
    AND NOT EXISTS (SELECT fps.member_key FROM ftt_permission_sheet fps WHERE fps.member_key = ft.member_key AND DATE_FORMAT(fps.absence_date, '%Y-%m-%d') = CURDATE() AND fps.status = 2)");
    while ($row = $res->fetch_assoc()) $traineeKeysToCreateExtrahelp[]=$row['ft_member_key'];
  // проверка в понедельник
  // $res = db_query("SELECT ft.member_key FROM ftt_trainee ft WHERE NOT EXISTS (SELECT fp.member_key FROM ftt_prophecy fp WHERE ft.member_key = fp.member_key AND (DATE_FORMAT(fp.send_date, '%Y-%m-%d') = (CURDATE() - INTERVAL 1 DAY) OR DATE_FORMAT(fp.send_date, '%Y-%m-%d') = CURDATE())) AND (ft.pause_start IS NULL OR ft.pause_start > (CURDATE() - INTERVAL 1 DAY) OR ft.pause_stop < (CURDATE() - INTERVAL 1 DAY))");
  // ДОБАВИТЬ ПРОВЕРКУ ЛИСТОВ ОТСУТСТВИЯ НА ВОСКРЕСЕНЬЕ
  /* $res2 = db_query("SELECT ft.member_key FROM ftt_trainee ft
    WHERE NOT EXISTS (SELECT fp.member_key FROM ftt_prophecy fp WHERE ft.member_key = fp.member_key AND DATE_FORMAT(fp.send_date, '%Y-%m-%d') = CURDATE())
    AND (ft.pause_start IS NULL OR (ft.pause_start IS NOT NULL AND ft.pause_start > CURDATE()) OR (ft.pause_stop IS NOT NULL AND ft.pause_stop < CURDATE()))");
  while ($row = $res2->fetch_assoc()) $traineeKeysToCreateExtrahelp[]=$row['member_key'];*/

  // нет ключе обучающихся для создания доп помощи
  if (count($traineeKeysToCreateExtrahelp) === 0) {
    echo "Не добавлены доп. задания при проверке бланка пророчествования";
    exit();
  }

  // добавляем доп. помощь
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
