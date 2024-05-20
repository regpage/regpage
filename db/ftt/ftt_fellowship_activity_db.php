<?php
require_once 'db/classes/date_plus.php';
// Список записей за 4 недели
function get_fellowship_activity_list($serving_ones = '_all_',  $sort='meet_sort_servingone-asc') // $trainee_flt = '_all_',
{
  global $db;
  $serving_ones = $db->real_escape_string($serving_ones);
  $sort = $db->real_escape_string($sort);
  $result = [];
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
  //$date_current = getdate();

  $weeks = [];
  $currDate = date('Y-m-d');
  $dateDayNow = date('N');
  $dateDay = 28;
  if ($dateDayNow > 0 && $dateDayNow < 7) {
    $dateDay += $dateDayNow;
    $dateEndFour = date_plus::sub_d($currDate, $dateDayNow);
    // 1th
    $weeks[] = [date_plus::sub_d($dateEndFour, 27), date_plus::sub_d($dateEndFour, 21)];
    // 2th
    $weeks[] = [date_plus::sub_d($dateEndFour, 20), date_plus::sub_d($dateEndFour, 14)];
    // 3th
    $weeks[] = [date_plus::sub_d($dateEndFour, 13), date_plus::sub_d($dateEndFour, 7)];
    // 41th
    $weeks[] = [date_plus::sub_d($dateEndFour, 6), $dateEndFour];
    // 5th
    $weeks[] = [date_plus::plus_d($dateEndFour, 1), $currDate];
  } else {
    // 1th
    $weeks[] = [date_plus::sub_d($currDate, 27), date_plus::sub_d($currDate, 21)];
    // 2th
    $weeks[] = [date_plus::sub_d($currDate, 20), date_plus::sub_d($currDate, 14)];
    // 3th
    $weeks[] = [date_plus::sub_d($currDate, 13), date_plus::sub_d($currDate, 7)];
    // 41th
    $weeks[] = [date_plus::sub_d($currDate, 6), $currDate];
  }


  $order_period = " (ff.date >= (CURDATE() - INTERVAL {$dateDay} DAY)) AND ff.date <= CURDATE() AND ff.trainee != '' ";
  $result['weeks'] = $weeks;
  // служащие
  if ($serving_ones === '_all_') {
    $serving_ones = array_merge(ftt_lists::get_fellowship_list(), ftt_lists::kbk_brothers());
    foreach (ftt_lists::trainee() as $key => $value) {
      $result[$key] = [];
    }
  } else {
    foreach (ftt_lists::get_trainees_by_staff($serving_ones) as $key => $value) {
      $result[$key] = [];
    }
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

  $res = db_query("SELECT ff.*, m.name
    FROM ftt_fellowship AS ff
    LEFT JOIN member m ON m.key = ff.trainee
    WHERE {$condition}
    ORDER BY {$order_by}");
  while ($row = $res->fetch_assoc()) {
    if (isset($result[$row['trainee']])) {
      $week = array('week' => 5);
      // сравнить даты
      foreach ($weeks as $key => $value) {
        if ($row['date'] >= $value[0] && $row['date'] <= $value[1]) {
          $week['week'] = $key;
          break;
        }
      }
      // добавить неделю
      $result[$row['trainee']][] = array_merge($row, $week);
    } else {
      $result[$row['trainee']] = [];
      $result[$row['trainee']][] = $row;
    }
  }

  return $result;
}
