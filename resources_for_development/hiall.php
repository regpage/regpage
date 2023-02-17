<?php
// ВРЕМЕННЫЕ СЛУЖЕБНЫЕ ПРОЦЕДУРЫ
include_once 'config.php';
include_once 'logWriter.php';
echo "Запущена служба копирования данных.\n";
function db_hiAll(){

  logFileWriter(false, 'РАЗРАБОТКА. Копирование строк в таблицу attendance.', 'WARNING');

  $result = array();
  $res=db_query ("SELECT `key`, `attend_pm`, `attend_gm`, `attend_am`, `attend_vt`
    FROM `member`
    WHERE `attend_pm` = 1 OR `attend_gm` = 1 OR `attend_am` = 1 OR `attend_vt` = 1
    ORDER BY `key`");
  while ($row = $res->fetch_assoc()) $result[$row['key']]=$row;

  $count = count($result);

  echo "Всего получены данные {$count} строк. Начинается копирование.\n";
  foreach ($result as $key => $value){
    $attend_pm = $value['attend_pm'];
    $attend_gm = $value['attend_gm'];
    $attend_am = $value['attend_am'];
    $attend_vt = $value['attend_vt'];
    $res = db_query("INSERT INTO `attendance` (`date`, `member_key`, `attend_pm`, `attend_gm`, `attend_am`, `attend_vt`) VALUES (NOW(), '$key', '$attend_pm', '$attend_gm', '$attend_am', '$attend_vt')");
    echo "Пользователь {$key}, статус {$res}\n";
  }
  echo "Копирование завершено. Скопировано {$count} строк. Последний результат {$res}.\n";
  logFileWriter(false, 'РАЗРАБОТКА. ' . $count . ' СТРОК ДОБАВЛЕНЫ '. $res .'.', 'WARNING');
}

// db_hiAll();
