<?php
// COMMUNICATION
function get_communication_list($serving_ones = '_all_', $sort='meet_sort_servingone-asc')
{
  // # для братьев не выводятся служащие сёстры
  // # Уточнить список КБК !!! служащие пвом и братья из КБК (как определить братьев из КБК.)
  // # 0. сделать запрос на текущю неделю и три будущих
  // # 1. определить текущий день недели
  // # 2. определить количество дней до начала текущей недели (до пн)
  // # 3. получить дату текущего понедельника (использовать >= при сравнении)
  // # 4. определить количество дней до начала следующей недели (до пн)
  // # 5. получить дату следующего понедельника
  // # 6. прибавить 28 дней (использовать >= при сравнении).

  global $db;
  $serving_ones = $db->real_escape_string($serving_ones);
  $sort = $db->real_escape_string($sort);

  // Сортировка
  // сортировка по name бывает по обучающимся и по служащим
  // менять поле в строке JOIN на нужное
  $order_by = ' m.name, ff.date ';
  if (!empty($sort) && $sort !== 'meet_sort_date-asc') {
    if ($sort === 'meet_sort_date-desc') {
      $order_by = ' ff.date DESC, m.name DESC ';
    } elseif ($sort === 'meet_sort_trainee-asc') {
      $order_by = ' m.name, ff.date ';
    } elseif ($sort === 'meet_sort_trainee-desc') {
      $order_by = ' m.name DESC, ff.date DESC ';
    } elseif ($sort === 'meet_sort_servingone-asc') {
      $order_by = ' m.name, ff.date ';
    } elseif ($sort === 'meet_sort_servingone-desc') {
      $order_by = ' m.name DESC, ff.date DESC ';
    }
  }

  // УСЛОВИЯ
  // дата
  $date_current = getdate();
  $days_to_future = 28 - $date_current['wday'];
  if ($date_current['wday'] > 0) {
    //$order_period = " ((ff.date >= (CURDATE() - INTERVAL {$date_current['wday']} DAY)) AND (ff.date <= (CURDATE() + INTERVAL {$days_to_future} DAY))) ";
    $order_period = " ((ff.date >= CURDATE()) AND (ff.date <= (CURDATE() + INTERVAL 28 DAY))) ";
  } else {
    $order_period = " ((ff.date >= CURDATE()) AND (ff.date <= (CURDATE() + INTERVAL 28 DAY))) ";
  }
  // служащие
  if ($serving_ones === '_all_') {
    $serving_ones = array_merge(ftt_lists::get_fellowship_list(), ftt_lists::kbk_brothers());
  } elseif ($serving_ones === 'pvom_br') {
    $serving_ones = array_merge(ftt_lists::serving_ones_fellowship_brothers(), ftt_lists::kbk_brothers());
  } else {
    $serving_ones = array($serving_ones => '');
  }
  $serving_ones_condition = '';
  foreach ($serving_ones as $key => $value) {
    if (empty($serving_ones_condition)) {
      $serving_ones_condition .= " ff.serving_one = '{$key}' ";
    } else {
      $serving_ones_condition .= " OR ff.serving_one = '{$key}' ";
    }
  }
  if (!empty($serving_ones_condition)) {
    $serving_ones_condition = ' AND ' . '(' . $serving_ones_condition . ')';
  }

  // condition
  $condition = $order_period . $serving_ones_condition;

  // запрос
  $result = [];
  $res = db_query("SELECT ff.*, m.name
    FROM ftt_fellowship AS ff
    LEFT JOIN member m ON m.key = ff.serving_one
    WHERE {$condition}
    ORDER BY {$order_by}");
  while ($row = $res->fetch_assoc()) {
    if (isset($result[$row['serving_one']])) {
      $result[$row['serving_one']][] = $row;
    } else {
      $result[$row['serving_one']] = [];
      $result[$row['serving_one']][] = $row;
    }
  }

  return $result;
}

// список записей обучающегося
function get_communication_records_staff($serving_one, $trainee, $active, $sort='meet_sort_servingone-asc')
{
  global $db;
  $serving_one = $db->real_escape_string($serving_one);
  $trainee = $db->real_escape_string($trainee);
  $active = $db->real_escape_string($active);
  $sort = $db->real_escape_string($sort);

  // Условия
  if ($active === '1') {
    $condition = " ff.date >= CURDATE() AND ";
  } else {
    $condition = " ff.date < CURDATE() AND ";
  }

  $servingList = [];
  if ($serving_one === '_all_' || empty($serving_one)) {
    $servingList = ftt_lists::get_fellowship_list();
  } elseif ($serving_one === '_allkbk_') {
    $servingList = ftt_lists::kbk_brothers();
  } else {
    $condition .= " ff.serving_one = '{$serving_one}'";
  }
  if (count($servingList) > 0) {
    $tempList = '';
    foreach ($servingList as $key => $value) {
      if (empty($tempList)) {
        $tempList .= "'$key'";
      } else {
        $tempList .= ",'$key'";
      }
    }
    $condition  .= ' (ff.serving_one IN (' . $tempList . ')) ';
  }

  if ($trainee !== '_all_' && !empty($trainee)) {
    $condition .= " AND ff.trainee = '{$trainee}'";
  }
  // echo $condition;
// return $condition;
  // Сортировка
  $order_by = 'ff.date, ff.time, m.name';
  if (!empty($sort) && $sort !== 'meet_sort_date-asc') {
    if ($sort === 'meet_sort_date-desc') {
      $order_by = ' ff.date DESC, ff.time DESC, m.name DESC';
    } elseif ($sort === 'meet_sort_servingone-asc') {
      $order_by = ' m.name, ff.date DESC ';
    } elseif ($sort === 'meet_sort_servingone-desc') {
      $order_by = ' m.name DESC, ff.date DESC ';
    } elseif ($sort === 'meet_sort_trainee-asc') {
      $order_by = ' m.name, ff.date DESC ';
    } elseif ($sort === 'meet_sort_trainee-desc') {
      $order_by = ' m.name DESC, ff.date DESC ';
    } elseif ($sort === 'meet_sort_time-asc') {
      $order_by = ' ff.time, ff.date DESC ';
    } elseif ($sort === 'meet_sort_time-desc') {
      $order_by = ' ff.time DESC, ff.date DESC ';
    }
  }

  $join = 'ff.serving_one';
  if ($sort === 'meet_sort_trainee-asc' || $sort === 'meet_sort_trainee-desc') {
    $join = 'ff.trainee';
  }

  $result = [];
  $res = db_query("SELECT ff.*, m.name
    FROM ftt_fellowship AS ff
    LEFT JOIN member m ON m.key = {$join}
    WHERE {$condition}
    ORDER BY {$order_by}");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

// список записей на общение обучающегося
function get_communication_records($trainee, $active, $sort='meet_sort_servingone-asc')
{
  global $db;
  $trainee = $db->real_escape_string($trainee);
  $active = $db->real_escape_string($active);
  $sort = $db->real_escape_string($sort);
  // Сортировка

  // Условия
  if ($active === '1') {
    $condition = " ff.date >= CURDATE() ";
  } else {
    $condition = " ff.date < CURDATE() ";
  }
  $order_by = 'ff.date, ff.time';
  if (!empty($sort) && $sort !== 'meet_sort_date-asc') {
    if ($sort === 'meet_sort_date-desc') {
      $order_by = ' ff.date DESC, ff.time DESC ';
    } elseif ($sort === 'meet_sort_servingone-asc') {
      $order_by = ' m.name, ff.date DESC ';
    } elseif ($sort === 'meet_sort_servingone-desc') {
      $order_by = ' m.name DESC, ff.date DESC ';
    }
  }

  $result = [];
  $res = db_query("SELECT ff.*, m.name
    FROM ftt_fellowship AS ff
    LEFT JOIN member m ON m.key = ff.serving_one
    WHERE ff.trainee = '{$trainee}' AND {$condition}
    ORDER BY {$order_by}");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

function set_communication_record($trainee, $id, $checked=0, $date='', $time_from='', $time_to='', $comment='')
{
  global $db;
  $trainee = $db->real_escape_string($trainee);
  $id = $db->real_escape_string($id);
  $checked = $db->real_escape_string($checked);
  $date = $db->real_escape_string($date);
  $time_from = $db->real_escape_string($time_from);
  $time_to = $db->real_escape_string($time_to);
  $comment = $db->real_escape_string($comment);
  $check_exist = '';
  $serving_one = '';
  $result = [];
  if ($checked == 1) {
    $res_extra = db_query("SELECT `trainee`, `serving_one` FROM `ftt_fellowship` WHERE `id` = '$id'");
    while ($row = $res_extra->fetch_assoc()) {
      $check_exist = $row['trainee'];
      $serving_one = $row['serving_one'];
    }
    if (!empty($check_exist)) {
      return 'error_busy_' . $check_exist;
    }
    // проверка времени SELECT * FROM `ftt_fellowship` WHERE `time` BETWEEN '11:00' AND '12:00'
    $res_extra = db_query("SELECT `serving_one` FROM `ftt_fellowship` WHERE (`trainee` = '$trainee' AND `date` = '$date') AND (`time` BETWEEN '$time_from' AND '$time_to')");
    while ($row = $res_extra->fetch_assoc()) $result[] = $row['serving_one'];
    if (count($result) > 0) {
      return 'error_intersection_' . $result[0];
    }
    // запрос
    $res = db_query("UPDATE `ftt_fellowship` SET `trainee`= '{$trainee}', `comment_train`='{$comment}', `changed`= 1 WHERE `id` = '$id'");

    // EMAILING
    if (!empty($serving_one)) {
      if (!empty($comment)) {
        $comment = 'Комменарий обучающегося: ' . preg_replace('/\\\\n|\n|\r\n|\r/', '<br>', $comment);
      } else {
        $comment = '';
      }
      $trainee_name = short_name::no_middle(Member::get_name($trainee));
      // проверка для братьев из КБК
      if (array_key_exists($serving_one, ftt_lists::kbk_brothers())) {
        $linkToSection = "<a href='https://{$_SERVER['SERVER_NAME']}/ftt_fellowship_bbd.php?bbd_key=forbbdbrothers&member_key={$serving_one}>Перейти в раздел «Общение»</a><br>";
      } else {
        $linkToSection = "https://{$_SERVER['SERVER_NAME']}/ftt_fellowship.php";
      }
      $email_text = 'Обучающийся: ' . $trainee_name . '.<br>Новая запись: ' . date_convert::yyyymmdd_to_ddmm($date). ', ' . date_convert::week_days($date, true) . ' — ' . $time_from . '-' . $time_to . '.<br>' . $comment . "<br><br>Ссылка на раздел: " . $linkToSection . '<br><br>Запись создана ' . date("d.m.y, H:i") . '.';
// '000005716'
      emailing::send_by_key($serving_one, 'Новая запись на общение: '.$trainee_name, $email_text);
    }
  } else {
    // добавить сравнение комментов
    if (!empty($comment)) {
      $comment = 'Комменарий обучающегося: ' . preg_replace('/\\\\n|\n|\r\n|\r/', '<br>', $comment);
    } else {
      $comment = '';
    }
    $res = db_query("UPDATE `ftt_fellowship` SET `trainee`= '', `comment_train`='', `changed`= 1 WHERE `id` = '$id'");
    // EMAILING
    if (!empty($serving_one)) {
      $trainee_name = short_name::no_middle(Member::get_name($trainee));
      // проверка для братьев из КБК
      if (array_key_exists($serving_one, ftt_lists::kbk_brothers())) {
        $linkToSection = "<a href='https://{$_SERVER['SERVER_NAME']}/ftt_fellowship_bbd.php?bbd_key=forbbdbrothers&member_key={$serving_one}>Перейти в раздел «Общение»</a><br>";
      } else {
        $linkToSection = "https://{$_SERVER['SERVER_NAME']}/ftt_fellowship.php";
      }
      $email_text = 'Обучающийся: ' . $trainee_name . '.<br>Отменена запись: ' . date_convert::yyyymmdd_to_ddmm($date) . ', ' . date_convert::week_days($date, true) . ' — ' . $time_from . '-' . $time_to . '.<br>' . $comment . "<br><br>Ссылка на раздел: " . $linkToSection . '<br><br>Запись отменена ' . date("d.m, H:i") . '.';
      emailing::send_by_key($serving_one, 'Отмена записи на общение: '.$trainee_name, $email_text);
    }
  }

  return $res;
}

function send_email_to_staff($id)
{
  global $db;
  $id = $db->real_escape_string($id);
  $result = [];
  $res;
  $res_extra = db_query("SELECT `trainee`, `serving_one`, `date`, `time`, `duration`, `comment_train` FROM `ftt_fellowship` WHERE `id` = '$id'");
  while ($row = $res_extra->fetch_assoc()) $result = $row;

  $time_to = time_convert::sum($result['time'], $result['duration']);
  if (isset($result['comment_train']) && !empty($result['comment_train'])) {
    $comment = "<br>Новый комментарий обучающегося: " . preg_replace('/\\\\n|\n|\r\n|\r/', '<br>', $result['comment_train']);
  } else {
    $comment = '';
  }
  // EMAILING
  if (isset($result['serving_one']) && !empty($result['serving_one'])) {
    $serving_one = $result['serving_one'];
    $trainee_name = short_name::no_middle(Member::get_name($result['trainee']));
    // проверка для братьев из КБК
    if (array_key_exists($serving_one, ftt_lists::kbk_brothers())) {
      $linkToSection = "<a href='https://{$_SERVER['SERVER_NAME']}/ftt_fellowship_bbd.php?bbd_key=forbbdbrothers&member_key={$serving_one}>Перейти в раздел «Общение»</a><br>";
    } else {
      $linkToSection = "https://{$_SERVER['SERVER_NAME']}/ftt_fellowship.php";
    }
    $email_text = 'Обучающийся: ' . $trainee_name . '.<br>Запись: ' . date_convert::yyyymmdd_to_ddmm($result['date']) . ', ' . date_convert::week_days($result['date'], true) . ' — ' . $result['time'] . '-' . $time_to . '.' . $comment . "<br><br>Ссылка на раздел: " . $linkToSection . '<br><br>Запись обновлена ' . date("d.m, H:i") . '.';

    $res = emailing::send_by_key($serving_one, 'Обновлён комментарий записи: '.$trainee_name, $email_text);
  }

 return $res;
}

function set_meet_staff_blank($data)
{
  global $db;
  $data = json_decode($data);
  $id = $db->real_escape_string($data->id);
  $serving_one = $db->real_escape_string($data->serving_one);
  $trainee = $db->real_escape_string($data->trainee);
  $date = $db->real_escape_string($data->date);
  $time = $db->real_escape_string($data->time);
  $duration = $db->real_escape_string($data->duration);
  $comment_train = $db->real_escape_string($data->comment_train);
  $comment_serv = $db->real_escape_string($data->comment_serv);
  $adminId = db_getMemberIdBySessionId (session_id());
  $prevFellowshipData = false;
  // сравнить полученные данные с имеющимися Дата Время Продолжительность Служащий Обучающийся, комментарии ??? и отправить письмо при наличии изменений
  $res_extra = db_query("SELECT `trainee`, `serving_one`, `date`, `time`, `duration`, `comment_train`  FROM `ftt_fellowship` WHERE `id` = '{$id}'");
  while ($row = $res_extra->fetch_assoc()) {
    $traineePrev = $row['trainee'];
    $servingOnePrev = $row['serving_one'];
    $timeFromPrev = $row['time'];
    $timeToPrev = time_convert::sum($timeFromPrev, $row['duration']);
    $datePrev = $row['date'];
    $durationPrev = $row['duration'];
    $prevFellowshipData = true;
    $prevComment = preg_replace('/\\\\n|\n|\r\n|\r/', '<br>', $row['comment_train']);
  }

  $res = db_query("UPDATE `ftt_fellowship`
    SET `serving_one`='$serving_one', `trainee`= '$trainee', `date`='$date', `time`='$time', `duration`='$duration', `comment_train`='$comment_train', `comment_serv`='$comment_serv', `changed`= 1
    WHERE `id` = '$id'");
    if (!empty($comment_train)) {
      $comment_train = preg_replace('/\\\\n|\n|\r\n|\r/', '<br>', $comment_train);
    }
    if ($prevFellowshipData) { // запись обнаружена в базе
      // добавить прошлую информацию
      if ((empty($trainee) && empty($traineePrev)) || ($traineePrev == $trainee && $servingOnePrev == $serving_one && $timeFromPrev == $time && $datePrev == $date && $durationPrev == $duration && $prevComment == $comment_train)) {
        // уведомление не требуется
        // если изменился только комментарий уведомление не требуется
      } elseif ($servingOnePrev != $serving_one) {
        // уведомить служащего в случае наличия обучающегося
        if (!empty($servingOnePrev) && !empty($traineePrev)) {
          // уведометь прошлого служащего об отмене
          emailingAddSetDltBlank('Отменена запись на общение:', 'Отменена запись:',  $servingOnePrev, $traineePrev, $datePrev, $timeFromPrev, $durationPrev);
        }
        if (!empty($serving_one) && !empty($trainee)) {
          // уведометь текущего служащего о назначении
          emailingAddSetDltBlank('Новая запись на общение:', 'Новая запись:',  $serving_one, $trainee, $date, $time, $duration, $comment_train);
        }
      } else {
        if (empty($traineePrev)) {
          // назначение
          emailingAddSetDltBlank('Новая запись на общение:', 'Новая запись:',  $serving_one, $trainee, $date, $time, $duration, $comment_train);
        } elseif (empty($trainee)) {
          // отмена
          emailingAddSetDltBlank('Отменена запись на общение:', 'Отменена запись:',  $serving_one, $traineePrev, $date, $time, $duration, $comment_train);
        } else {
          // Изменение
          $prevCommentText = '';
          if ($prevComment != $comment_train && !empty($prevComment)) {
            $prevCommentText = "<br>Комментарий: " . $prevComment;
          }

          $datePrevText = date_convert::yyyymmdd_to_ddmm($datePrev);
          $comment_train .= "<br>Прежняя запись: {$datePrevText} — {$timeFromPrev}-{$timeToPrev}.{$prevCommentText}";
          emailingAddSetDltBlank('Изменена запись на общение:', 'Новая запись:',  $serving_one, $trainee, $date, $time, $duration, $comment_train);
        }
      }
    }
   return $res;
}
// добавить новую запись
function add_meet_staff_blank($data)
{
  global $db;
  $data = json_decode($data);
  $serving_one = $db->real_escape_string($data->serving_one);
  $trainee = $db->real_escape_string($data->trainee);
  $date = $db->real_escape_string($data->date);
  $time = $db->real_escape_string($data->time);
  $duration = $db->real_escape_string($data->duration);
  $comment_train = $db->real_escape_string($data->comment_train);
  $comment_serv = $db->real_escape_string($data->comment_serv);

  $res = db_query("INSERT INTO `ftt_fellowship` (`serving_one`, `trainee`, `date`, `time`, `duration`, `comment_train`, `comment_serv`, `changed`)
    VALUES ('{$serving_one}', '{$trainee}', '{$date}', '{$time}', '{$duration}', '{$comment_train}', '{$comment_serv}', 1)");

  // EMAILING
  if (!empty($trainee)) {
    emailingAddSetDltBlank('Новая запись на общение:', 'Новая запись:', $serving_one, $trainee, $date, $time, $duration, $comment_train);
  }
  return $res;
}
// Отменить запись на общение
function cancel_communication_record($id, $comment='')
{
  global $db;
  $id = $db->real_escape_string($id);
  $comment = $db->real_escape_string($comment);

  $res_extra = db_query("SELECT `trainee`, `serving_one`, `date`, `time`, `duration`, `comment_train` FROM `ftt_fellowship` WHERE `id` = '$id'");
  while ($row = $res_extra->fetch_assoc()) {
    $trainee = $row['trainee'];
    $serving_one = $row['serving_one'];
    $time_from = $row['time'];
    $time_to = time_convert::sum($time_from, $row['duration']);
    $comment_prev = preg_replace('/\\\\n|\n|\r\n|\r/', '<br>', $row['comment_train']);
    $date = $row['date'];
  }

  if (empty($trainee)) {
    return 'error_missing_' . $check_exist;
  }

  $res = db_query("UPDATE `ftt_fellowship` SET `trainee`= '', `comment_train`='', `changed`= 1 WHERE `id` = '$id'");

  $comment = preg_replace('/\\\\n|\n|\r\n|\r/', '<br>', $comment);
    if (!empty($comment) && $comment !== $comment_prev) {
      $comment = 'Комменарий: ' . $comment;
    } else {
      $comment = '';
    }
    // EMAILING
    if (!empty($serving_one)) {
      $trainee_name = short_name::no_middle(Member::get_name($trainee));
      // проверка для братьев из КБК
      if (array_key_exists($serving_one, ftt_lists::kbk_brothers())) {
        $linkToSection = "<a href='https://{$_SERVER['SERVER_NAME']}/ftt_fellowship_bbd.php?bbd_key=forbbdbrothers&member_key={$serving_one}>Перейти в раздел «Общение»</a><br>";
      } else {
        $linkToSection = "https://{$_SERVER['SERVER_NAME']}/ftt_fellowship.php";
      }

      $email_text = 'Обучающийся: ' . $trainee_name . '.<br>Отменена запись: ' . date_convert::yyyymmdd_to_ddmm($date) . ', ' . date_convert::week_days($date, true) . ' — ' . $time_from . '-' . $time_to . '.<br>' . $comment . "<br><br>Ссылка на раздел: " . $linkToSection . '<br><br>Запись отменена ' . date("d.m, H:i") . '.';
//'000005716'
      emailing::send_by_key($serving_one, 'Отмена записи на общение: '.$trainee_name, $email_text);
    }
   return $res;
}
// Удалить запись на общение
function dlt_fellowship_record($id) {
  $id = db_real_escape_string($id);
  $res_extra = db_query("SELECT `trainee`, `serving_one`, `date`, `time`, `duration` FROM `ftt_fellowship` WHERE `id` = '{$id}'");
  while ($row = $res_extra->fetch_assoc()) {
    $trainee = $row['trainee'];
    $serving_one = $row['serving_one'];
    $time = $row['time'];
    $date = $row['date'];
    $duration = $row['duration'];
  }
  $res = db_query("DELETE FROM `ftt_fellowship` WHERE `id` = '$id'");
  if ($res) {
    if (!empty($serving_one) && !empty($trainee)) {
      emailingAddSetDltBlank('Удалена запись на общение:', 'Удалена запись:', $serving_one, $trainee, $date, $time, $duration);
    }
  }

  return $res;
}

function emailingAddSetDltBlank($topic, $text, $serving_one, $trainee, $date, $time, $duration, $comment = '')
{
  if (!empty($comment)) {
    $comment = '<br>Комментарий: ' . $comment;
  }
  $time_to = (new DateTime(date('Y-m-d') . ' ' . $time . ':00'))->modify("+{$duration} minutes")->format('H:i');
  $trainee_name = short_name::no_middle(Member::get_name($trainee));
  // проверка для братьев из КБК
  if (array_key_exists($serving_one, ftt_lists::kbk_brothers())) {
    $linkToSection = "<a href='https://{$_SERVER['SERVER_NAME']}/ftt_fellowship_bbd.php?bbd_key=forbbdbrothers&member_key={$serving_one}>Перейти в раздел «Общение»</a><br>";
  } else {
    $linkToSection = "https://{$_SERVER['SERVER_NAME']}/ftt_fellowship.php";
  }
  $email_text = 'Обучающийся: ' . $trainee_name . '.<br>'. $text . ' ' . date_convert::yyyymmdd_to_ddmm($date) . ', ' . date_convert::week_days($date, true) . ' — ' . $time . '-' . $time_to . '.' . $comment . '<br>' . $linkToSection;

  emailing::send_by_key($serving_one, $topic . ' ' .$trainee_name, $email_text);
}

function get_meet_by_date($date, $serving_ones = '_all_')
{
  // # для братьев не выводятся служащие сёстры
  // # Уточнить список КБК !!! служащие пвом и братья из КБК (как определить братьев из КБК.)

  global $db;
  $serving_ones = $db->real_escape_string($serving_ones);
  $date = $db->real_escape_string($date);

  // Сортировка
  $order_by = ' ff.date ';

  // УСЛОВИЯ
  // дата
  $order_period = " ff.date = '{$date}' ";

  // служащие
  if ($serving_ones === '_all_') {
    $serving_ones = array_merge(ftt_lists::get_fellowship_list(), ftt_lists::kbk_brothers());
  } elseif ($serving_ones === 'pvom_br') {
    $serving_ones = array_merge(ftt_lists::serving_ones_fellowship_brothers(), ftt_lists::kbk_brothers());
  } else {
    $serving_ones = array($serving_ones => '');
  }
  $serving_ones_condition = '';
  foreach ($serving_ones as $key => $value) {
    if (empty($serving_ones_condition)) {
      $serving_ones_condition .= " ff.serving_one = '{$key}' ";
    } else {
      $serving_ones_condition .= " OR ff.serving_one = '{$key}' ";
    }
  }
  if (!empty($serving_ones_condition)) {
    $serving_ones_condition = ' AND ' . '(' . $serving_ones_condition . ')';
  }

  // condition
  $condition = $order_period . $serving_ones_condition;

  // запрос
  $result = [];

  $res = db_query("SELECT ff.*, m.name
    FROM ftt_fellowship AS ff
    LEFT JOIN member m ON m.key = ff.serving_one
    WHERE {$condition}
    ORDER BY {$order_by}");
  while ($row = $res->fetch_assoc()) {
    if (isset($result[$row['serving_one']])) {
      $result[$row['serving_one']][] = $row;
    } else {
      $result[$row['serving_one']] = [];
      $result[$row['serving_one']][] = $row;
    }
  }
  uasort($result, function($a, $b){
    if (isset($a[0]['name']) && isset($b[0]['name'])) {
      return ($a[0]['name'] > $b[0]['name']);
    }
  });
  return $result;
}
