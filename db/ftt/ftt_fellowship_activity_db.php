<?php
// Список записей за 4 недели
function get_fellowship_activity_list($serving_ones = '_all_', $sort='meet_sort_servingone-asc')
{
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
  $order_period = " (ff.date >= (CURDATE() - INTERVAL 28 DAY)) AND ff.trainee != '' ";
  $date_current = getdate();
  //$days_to_future = 28 - $date_current['wday'];
  /*if ($date_current['wday'] > 0) {
    //$order_period = " ((ff.date >= (CURDATE() - INTERVAL {$date_current['wday']} DAY)) AND (ff.date <= (CURDATE() + INTERVAL {$days_to_future} DAY))) ";

  } else {
    $order_period = " ((ff.date >= CURDATE()) AND (ff.date <= (CURDATE() + INTERVAL 28 DAY))) ";
  }
  */

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

  foreach (ftt_lists::trainee() as $key => $value) {
    $result[$key] = [];
  }

  $res = db_query("SELECT ff.*, m.name
    FROM ftt_fellowship AS ff
    LEFT JOIN member m ON m.key = ff.trainee
    WHERE {$condition}
    ORDER BY {$order_by}");
  while ($row = $res->fetch_assoc()) {
    if (isset($result[$row['trainee']])) {
      $result[$row['trainee']][] = $row;
    } else {
      $result[$row['trainee']] = [];
      $result[$row['trainee']][] = $row;
    }
  }

  return $result;
}
