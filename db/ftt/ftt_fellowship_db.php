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
function get_communication_records_staff($serving_one, $trainee, $sort='meet_sort_servingone-asc')
{
  global $db;
  $serving_one = $db->real_escape_string($serving_one);
  $trainee = $db->real_escape_string($trainee);
  $sort = $db->real_escape_string($sort);
  $condition = '';

  // Условия
  if ($serving_one !== '_all_' && !empty($serving_one)) {
    $condition = " AND ff.serving_one = '{$serving_one}'";
  }

  if ($trainee !== '_all_' && !empty($trainee)) {
    $condition .= " AND ff.trainee = '{$trainee}'";
  }

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
    WHERE ff.date >= CURDATE() {$condition}
    ORDER BY {$order_by}");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

// список записей обучающегося
function get_communication_records($trainee, $sort='meet_sort_servingone-asc')
{
  global $db;
  $trainee = $db->real_escape_string($trainee);
  $sort = $db->real_escape_string($sort);
  // Сортировка

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
    WHERE ff.trainee = '{$trainee}' AND ff.date >= CURDATE()
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
  $result = [];
  if ($checked == 1) {
    $res_extra = db_query("SELECT `trainee` FROM `ftt_fellowship` WHERE `id` = '$id'");
    while ($row = $res_extra->fetch_assoc()) $check_exist = $row['trainee'];
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
  } else {
    $res = db_query("UPDATE `ftt_fellowship` SET `trainee`= '', `comment_train`='', `changed`= 1 WHERE `id` = '$id'");
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

  $res = db_query("UPDATE `ftt_fellowship`
    SET `serving_one`='$serving_one', `trainee`= '$trainee', `date`='$date', `time`='$time', `duration`='$duration', `comment_train`='$comment_train', `comment_serv`='$comment_serv', `changed`= 1
    WHERE `id` = '$id'");
   return $res;
}

function cancel_communication_record($id)
{
  global $db;
  $id = $db->real_escape_string($id);

  $res = db_query("UPDATE `ftt_fellowship`
    SET `trainee`= '', `comment_train`='', `comment_serv`='', `cancel` = 1, `changed`= 1
    WHERE `id` = '$id'");
   return $res;
}


function get_meet_by_date($date, $serving_ones = '_all_')
{
  // # для братьев не выводятся служащие сёстры
  // # Уточнить список КБК !!! служащие пвом и братья из КБК (как определить братьев из КБК.)

  global $db;
  $serving_ones = $db->real_escape_string($serving_ones);
  $date = $db->real_escape_string($date);

  // Сортировка
  $order_by = ' m.name, ff.date ';

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

  return $result;
}
