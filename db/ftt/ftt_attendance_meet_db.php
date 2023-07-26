<?php
// COMMUNICATION
function get_communication_list($member_id = '_all_', $serving_ones = '_all_', $sort='meet_sort_date-asc', $canceled=0)
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
  $member_id = $db->real_escape_string($member_id);
  $serving_ones = $db->real_escape_string($serving_ones);
  $canceled = $db->real_escape_string($canceled);
  $sort = $db->real_escape_string($sort);

  // Сортировка
  // сортировка по name бывает по обучающимся и по служащим
  // менять поле в строке JOIN на нужное
  $order_by = ' ff.date, ff.time ';
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
      $order = ' m.name DESC, ff.date DESC ';
    }
  }

  // УСЛОВИЯ
  // дата
  $date_current = getdate();
  $days_to_future = 28 - $date_current['wday'];
  if ($date_current['wday'] > 0) {
    $order_period = " ((ff.date >= (CURDATE() - INTERVAL {$date_current['wday']} DAY)) AND (ff.date <= (CURDATE() + INTERVAL {$days_to_future} DAY))) ";
  } else {
    $order_period = " ((ff.date >= CURDATE()) AND (ff.date <= (CURDATE() + INTERVAL 28 DAY))) ";
  }
  // служащие
  if ($serving_ones === 'kbk') {
    $serving_ones = ftt_lists::kbk_brothers();
  } elseif ($serving_ones === 'pvom_br') {
    $serving_ones = ftt_lists::serving_ones_brothers();
  } else {
    $serving_ones = ftt_lists::serving_ones();
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

  // трэш
  $trash = "";
  if ($canceled === '1') {
    $trash = ' AND ff.cancel = 1 ';
  }

  $condition = $order_period . $serving_ones_condition . $trash;

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
    WHERE ff.trainee = '{$trainee}'
    ORDER BY {$order_by}");
  while ($row = $res->fetch_assoc()) $result[] = $row;
  return $result;
}

function set_communication_record($trainee, $id)
{
  global $db;
  $trainee = $db->real_escape_string($trainee);
  $id = $db->real_escape_string($id);

  $res = db_query("UPDATE `ftt_fellowship` SET `trainee`= '$trainee', `changed`= 1 WHERE `id` = $id");
}
