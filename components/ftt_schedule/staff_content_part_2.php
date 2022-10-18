<div id="ftt_schedule_container_2" class="col-6" style="background-color: white; padding: 0px; margin-top: 13px;">
  <span id="label_5_6" style="margin-left: 20px;">Семестры 5-6</span>
  <div id="ftt_schedule_list_2" class="container" style="margin-top: 5px;">
    <div class="accordion" id="accordionExample_2">
      <div class="card">
<?php
// дата и дни недели
$schedule_empty;
$schedule_filled;
$correction_data_tmp;
$today_day = date('N');
$today_day_NEW = ($today_day - 1) * 86400;
$date_start_day = date('d.m', time()-$today_day_NEW); //NEW
$ftt_schedule_start_mls = strtotime($ftt_schedule_start);
$ftt_schedule_end_mls = strtotime($ftt_schedule_end);
// даты корректировок приводим к нужному типу
for ($i=0; $i < count($correction_2); $i++) {
  $correction_data_tmp = strtotime($correction_2[$i]['date']);
  $correction_2[$i]['date'] = $correction_data_tmp;
}

// дни
for ($i=0; $i < count($days); $i++) {
  $open_day = '';
  $btn_bold = '';
  $date_week_day = $date_start_day;

  // Прибавляем один день
  $day_incr_tmp = $date_start_day.'.'.date('Y');
  $date_day_stamp = strtotime($day_incr_tmp);
  $date_next_day_stamp = $date_day_stamp + 86400;
  $date_start_day = date('d.m', $date_next_day_stamp);

  if (($today_day - 1) === $i) {
    $open_day = 'show';
    $btn_bold = 'accordion-head';
  }

// Корректировки
$correction_info = '';
$correction_data = [];
$correction_check_2 = [];
for ($ii=0; $ii < count($correction_2); $ii++) {
  // СДЕЛАТЬ РАЗДЕЛЕНИЕ ЗАПЯТЫМИ И ЗАМЕНУ НЕСКОЛЬКИХ МЕРОПРИЯТИЙ
  if ($correction_2[$ii]['date'] === $date_day_stamp && ($correction_2[$ii]['semester_range'] === '2' || $correction[$ii]['semester_range'] === '0')
  && ($correction[$ii]['time_zone'] === $time_zone_list)) {
    //$correction_2[$ii]['time_zone'] === $ftt_access['staff_time_zone']  ||
    $correction_info = ' (есть изменения)';
    // проверяем количество изменяемых строк
    $correction_strings = explode(',' ,$correction_2[$ii]['cancel_id']);

    if (count($correction_strings) > 0) {
      for ($i2=0; $i2 < count($correction_strings); $i2++) {
        if ($i2 === 0) {
          $one_corretion = $correction_2[$ii];
          if (isset($correction_check_2[$correction_strings[$i2]]) && $correction_check_2[$correction_2[$ii]['cancel_id']] === '0') {
            $one_corretion['cancel_id'] = '';
          } else {
            if (isset($correction_check_2[$correction_strings[$i2]]) && $correction_check_2[$correction_2[$ii]['cancel_id']] === '2') {
              $one_corretion['cancel_id'] = '';
            } else {
              $correction_check_2[$correction_strings[$i2]] = $correction_2[$ii]['semester_range'];
              $one_corretion['cancel_id'] = trim($correction_strings[$i2]);
            }
          }
          $correction_data[] = $one_corretion;
        } else {
          $one_corretion = $correction_2[$ii];
          if (isset($correction_check_2[$correction_strings[$i2]]) && $correction_check_2[$correction_2[$ii]['cancel_id']] === '0') {
            $one_corretion['cancel_id'] = '';
          } else {
            if (isset($correction_check_2[$correction_strings[$i2]]) && $correction_check_2[$correction_2[$ii]['cancel_id']] === '2') {
              $one_corretion['cancel_id'] = '';
            } else {
              $correction_check_2[$correction_strings[$i2]] = $correction_2[$ii]['semester_range'];
              $one_corretion['cancel_id'] = trim($correction_strings[$i2]);
            }
          }
          $one_corretion['time'] = '';
          $correction_data[] = $one_corretion;
        }
      }
    } else {
      $correction_data[] = $correction_2[$ii];
    }

  }
}

//ВНЕСЕНИЕ ИЗМЕНЕНИЙ И СОРТИРОВКА МАССИВА
if (count($correction_data) > 0 ) {
  // Определяем день
  $number_day = $i + 1;
  $day = 'day'.$number_day;

  // Выбираем массив
  if ($day === 'day1') {
    $loop_schedule = $schedule_day1_2;
  } else if ($day === 'day2') {
    $loop_schedule = $schedule_day2_2;
  } else if ($day === 'day3') {
    $loop_schedule = $schedule_day3_2;
  } else if ($day === 'day4') {
    $loop_schedule = $schedule_day4_2;
  } else if ($day === 'day5') {
    $loop_schedule = $schedule_day5_2;
  } else if ($day === 'day6') {
    $loop_schedule = $schedule_day6_2;
  } else if ($day === 'day7') {
    $loop_schedule = $schedule_day7_2;
  }

// Добавляем корректировки
  $loop_schedule_extra = [];
  $correction_color = [];

  foreach ($loop_schedule as $key => $value) {
    if ($value[$day]) {
    for ($iii=0; $iii < count($correction_data); $iii++) {
      if (!$correction_data[$iii]['cancel_id']) {
        $loop_schedule_extra[] = [
          'session_name' => $correction_data[$iii]['session_name'],
          $day => $correction_data[$iii]['time'],
          'duration' => $correction_data[$iii]['duration'],
          'attendance' => $correction_data[$iii]['attendance'],
          'comment' => $correction_data[$iii]['comment'],
          'color' => 1
        ];
        $correction_data[$iii]['cancel_id'] = 'break';
      } else if ($value['id'] === $correction_data[$iii]['cancel_id'] && !$correction_data[$iii]['time']) {
        $loop_schedule[$key][$day] = $correction_data[$iii]['time'];
      }
      if ($correction_data[$iii]['cancel_id'] && $correction_data[$iii]['cancel_id'] !== 'break' && $correction_data[$iii]['time']) {
        $loop_schedule_extra[] = [
          'session_name' => $correction_data[$iii]['session_name'],
          $day => $correction_data[$iii]['time'],
          'duration' => $correction_data[$iii]['duration'],
          'attendance' => $correction_data[$iii]['attendance'],
          'comment' => $correction_data[$iii]['comment'],
          'color' => 1
        ];
        $correction_data[$iii]['time']  = '';
      }
    }
  }
  }
  if (count($loop_schedule_extra) > 0) {
    for ($i3=0; $i3 < count($loop_schedule_extra); $i3++) {
      $loop_schedule[] = $loop_schedule_extra[$i3];
    }
  }
  // Подготавливаем вспомогательный массив
  $sort_field = [];
  foreach ($loop_schedule as $key => $row) {
    $sort_field[$key] = $row[$day];
  }
  // Сортируем
  array_multisort($sort_field, SORT_ASC, $loop_schedule);
  // Сохраняем изменения
if ($day === 'day1') {
  $schedule_day1_2 = $loop_schedule;
} else if ($day === 'day2') {
  $schedule_day2_2 = $loop_schedule;
} else if ($day === 'day3') {
   $schedule_day3_2 = $loop_schedule;
} else if ($day === 'day4') {
  $schedule_day4_2 = $loop_schedule;
} else if ($day === 'day5') {
  $schedule_day5_2 = $loop_schedule;
} else if ($day === 'day6') {
  $schedule_day6_2 = $loop_schedule;
} else if ($day === 'day7') {
  $schedule_day7_2 = $loop_schedule;
}
}
  // Проверяем что расписание не выходит за период обучения
  if (($date_day_stamp < $ftt_schedule_start_mls) || ($date_day_stamp > $ftt_schedule_end_mls)) {
    $id_head = 'id_head_'.$i;
    $id_collapse = 'id_collapse_'.$i;
    if ($schedule_empty !== 1 && $schedule_filled !== 1) {
      echo "<p style='margin-left: 20px; margin-top: 15px;'>Расписание доступно с {$ftt_schedule_start}</p>";
      $schedule_empty = 1;
    } elseif ($schedule_empty !== 2 && $schedule_filled === 1) {
      //echo "<p style='margin-left: 20px; margin-top: 15px;'>Обучение завершилось {$ftt_schedule_end} </p>";
      $schedule_empty = 2;
    }

    echo "<div class='card-header' id='{$id_head}_2' style='display: none;'>
        <h2 class='mb-0'>
          <button class='btn btn-link btn-block pl-0 text-left {$btn_bold}' type='button' data-toggle='collapse' data-target='.{$id_collapse}' aria-expanded='true' aria-controls='{$id_collapse}'>
            {$days[$i]}, {$date_week_day}
          </button>
        </h2>
      </div>
      <div id='{$id_collapse}_2' class='collapse {$open_day} {$id_collapse}' aria-labelledby='{$id_head}_2' data-parent='#accordionExample_2'>
        <div class='card-body' style='display: none;'>";
    $number_day = $i + 1;
    $day = 'day'.$number_day;
    // занятия
    echo "<p>Расписание доступно с {$ftt_schedule_start}</p>";
    echo "</div></div>";
  } else {
    $id_head = 'id_head_'.$i;
    $id_collapse = 'id_collapse_'.$i;
    $schedule_filled = 1;  // border-top-gray класс из card-header
    echo "<div class='card-header' id='{$id_head}_2'>
        <h2 class='mb-0'>
          <button class='btn btn-link btn-block pl-0 text-left {$btn_bold}' type='button' data-toggle='collapse' data-target='.{$id_collapse}' aria-expanded='true' aria-controls='{$id_collapse}_2'>
            {$days[$i]}, {$date_week_day} {$correction_info}
          </button>
        </h2>
      </div>
      <div id='{$id_collapse}_2' class='collapse {$open_day} {$id_collapse}' aria-labelledby='{$id_head}_2' data-parent='#accordionExample_2'>
        <div class='card-body'>";

    $number_day = $i + 1;
    $day = 'day'.$number_day;
    if ($day === 'day1') {
      $schedule = $schedule_day1_2;
    } else if ($day === 'day2') {
      $schedule = $schedule_day2_2;
    } else if ($day === 'day3') {
      $schedule = $schedule_day3_2;
    } else if ($day === 'day4') {
      $schedule = $schedule_day4_2;
    } else if ($day === 'day5') {
      $schedule = $schedule_day5_2;
    } else if ($day === 'day6') {
      $schedule = $schedule_day6_2;
    } else if ($day === 'day7') {
      $schedule = $schedule_day7_2;
    }
    // Возможен ??? вариант с array_multisort($ar[0], SORT_ASC, SORT_STRING, $ar[1], SORT_NUMERIC, SORT_DESC);
    // Смортри справочник
    // занятия
    foreach ($schedule as $key => $value) {
      if ($value[$day]) {
        //корректировки
        // Перезаписать данные на корректирующие С УЧЁТОМ ВХОДЯЩЕГО МАССИВА КОРЕКТИРОВОК НА ДЕНЬ!!! ДЮРИНГ В КОРРЕКТИРОВКАХ
        /*if (count($correction_data) > 0 ) {
          for ($iii=0; $iii < count($correction_data); $iii++) {
            if ($value['id'] == $correction_data[$iii]['cancel_id']) {
              if ($correction_data[$iii]['session_name']) {
                $value['session_name'] = $correction_data[$iii]['session_name'];
              }
              if ($correction_data[$iii]['time']) {
                $value[$day] = $correction_data[$iii]['time'];
              }
              if ($correction_data[$iii]['duration']) {
                $value['duration'] = $correction_data[$iii]['duration'];
              }
              if ($correction_data[$iii]['attendance']) {
                $value['attendance'] = $correction_data[$iii]['attendance'];
              }
              if ($correction_data[$iii]['comment']) {
                $value['comment'] = $correction_data[$iii]['comment'];
              }
            }
          }
        }*/
        // часовые пояса не переделан до конца не работает
        /*
        if ($trainee_data['utc'] !== 3) {
          if ($trainee_data['utc'] < 10) {
            $utc_check['utc'] = 3 - $trainee_data['utc'];
            if ($utc_check < 0) {
              $difference = $utc_check * -1;
              $difference = '0'.$utc_check.':00';
            } else {
              $difference = '0'.$utc_check.':00';
            }
          } else if ($trainee_data['time_zone'] > 9 && $trainee_data['time_zone'] <= 12) {
            $trainee_data['time_zone'] = $trainee_data['time_zone'].':00';

          } else {
            $trainee_data['time_zone'] = 0;
          }
          $time_zone_tmp = strtotime($value[$day]) + strtotime($trainee_data['time_zone']) - strtotime("00:00:00");
          $value[$day] = date('H:i',$time_zone_tmp);
        }
        */
        $time_to = '';
        if ($value['duration'] > 0) {
          $hour;
          $minuts;
          $duration_tmp = '';
          if ($value['duration'] < 60 && $value['duration'] > 9) {
            $duration_tmp = '00:'.$value['duration'];
          } elseif ($value['duration'] < 60 && $value['duration'] < 10) {
            $duration_tmp = '00:0'.$value['duration'];
          } else {
            $hour = intval ($value['duration'] / 60);
            $minuts = $value['duration'] - ($hour * 60);
            if ($minuts > 0) {
              if ($minuts < 10) {
                $minuts = '0'.$minuts;
              }
              if ($hour > 9) {
                $duration_tmp = $hour.':'.$minuts;
              } else {
                $duration_tmp = '0'.$hour.':'.$minuts;
              }
            } else if ($hour > 9) {
              $duration_tmp = $hour.':00';
            } elseif ($hour < 10) {
              $duration_tmp = '0'.$hour.':00';
            }
          }
          // складываем время получаем время "до"
          $res = strtotime($value[$day]) + strtotime($duration_tmp) - strtotime("00:00:00");
          $time_to = date('H:i',$res);
        }
        //
        if ($value['color'] === 1) {
          $color = 'mark-yellow';
        } else {
          $color = '';
        }

        $comment_icon = '';
        if ($value['comment']) {
          $comment_icon = '<i class="fa fa-sticky-note" aria-hidden="true"></i>';
        }


        if ($time_to) {
          echo "<div class='row {$color}'><div class='col-8'>{$value['session_name']}</div><div class='col-3'>{$value[$day]}–{$time_to} </div><div class='col-1 comment_col' title='{$value['comment']}'>{$comment_icon}</div></div><hr class='hr-slim'>";
        } else {
          echo "<div class='row {$color}'><div class='col-8'>{$value['session_name']}</div><div class='col-3'></span>{$value[$day]}</span></div><div class='col-1 comment_col' title='{$value['comment']}'>{$comment_icon}</div></div><hr class='hr-slim'>";
        }
      }
    }
    echo "</div></div>";
  }
}

?>
      </div>
    </div>
  </div>
</div>
