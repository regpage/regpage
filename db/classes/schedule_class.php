<?php

/**
 *  Получить расписание с учётом корректировок
 * С учётом переданных аргументов
 * Принимает данные из trainee или service_one
 * ДОБАвить безопастность db()
 */
// УЧИТЫВАТЬ ПРЕД ОТМЕНЁННЫЕ МЕРОПРИЯТИЯ
class schedule_class {

  // Расписание по дням
  static function get_data($semester_range, $day, $time_zone) {
    global $db;
    $semester_range = $db->real_escape_string($semester_range);
    $day = $db->real_escape_string($day);
    $time_zone = $db->real_escape_string($time_zone);
    if ($time_zone === 'all') {
      $time_zone = '';
    } else {
      $time_zone = " AND `time_zone` = '$time_zone'";
    }
    if ($semester_range === 'all') {
      $semester_range = " `semester_range`= '1' OR `semester_range`= '2'";
    } else {
      $semester_range = " `semester_range`= '$semester_range'";
    }
    $result = [];
    $res = db_query("SELECT `id`, `$day`, `session_name`, `attendance`, `duration`, `semester_range`, `comment`, `time_zone`, `visit`, `end_time`
      FROM ftt_session
      WHERE (`semester_range`= 0 OR {$semester_range}) {$time_zone}
      ORDER BY `$day`");
    while ($row = $res->fetch_assoc()) $result[] = $row;
    return $result;
  }

  // корректировки расписания
  static public function correction() {
    $result = [];
    $res = db_query("SELECT * FROM ftt_session_correction");
    while ($row = $res->fetch_assoc()) $result[] = $row;
    return $result;
  }

  public static function get($semester_range, $time_zone, $date='_none_', $day='_none_') {
    $number_day;
    $date_today;
    $day_today;

    if ($date === '_none_') {
      $number_day = date('N');
      $day_today = 'day'.$number_day;
      $date_today_tmp = date('d.m.Y', time());
      $date_today = strtotime($date_today_tmp);
    } else {
      $day_today = $day;
      $date_today = strtotime($date);      
    }

    // это можно вынести в переменные раздела
    $ftt_attendance_start = getValueFttParamByName('attendance_start');
    $ftt_attendance_end = getValueFttParamByName('attendance_end');
    $ftt_attendance_start = strtotime($ftt_attendance_start);
    $ftt_attendance_end = strtotime($ftt_attendance_end);

    // Проверяем что расписание не выходит за период обучения
    if ($date_today < $ftt_attendance_start && $date_today > $ftt_attendance_end) {
      exit();
    }

    $correction = self::correction();
    // даты корректировок приводим к нужному типу
    for ($i=0; $i < count($correction); $i++) {
      $correction_data_tmp = strtotime($correction[$i]['date']);
      $correction[$i]['date'] = $correction_data_tmp;
    }

    // Корректировки
    $correction_data = [];
    for ($ii=0; $ii < count($correction); $ii++) {
      $semester_check;
      $time_zone_check;
      if ($correction[$ii]['semester_range'] === '0') {
        $semester_check = true;
      } else {
        $semester_check = $correction[$ii]['semester_range'] === $semester_range;
      }

      if ($correction[$ii]['time_zone'] === '0') {
        $time_zone_check = true;
      } else {
        $time_zone_check = $correction[$ii]['time_zone'] === $time_zone;
      }

      if ($correction[$ii]['date'] === $date_today && $semester_check && $time_zone_check) {
        // проверяем количество изменяемых строк
        $correction_strings = explode(',' ,$correction[$ii]['cancel_id']);

        if (count($correction_strings) > 0) {
          for ($i2=0; $i2 < count($correction_strings); $i2++) {
            if ($i2 === 0) {
              $one_corretion = $correction[$ii];
              $one_corretion['cancel_id'] = trim($correction_strings[$i2]);
              $correction_data[] = $one_corretion;
            } else {
              $one_corretion = $correction[$ii];
              $one_corretion['cancel_id'] = trim($correction_strings[$i2]);
              $one_corretion['time'] = '';
              $correction_data[] = $one_corretion;
            }
          }
        } else {
          $correction_data[] = $correction[$ii];
        }
      }
    }

    $schedule_day = self::get_data($semester_range, $day_today, $time_zone);
    $loop_schedule = $schedule_day;
    // Добавляем корректировки
    $loop_schedule_extra = [];

    foreach ($loop_schedule as $key => $value) {
      if ($value[$day_today]) {
        for ($iii=0; $iii < count($correction_data); $iii++) {
          if (!$correction_data[$iii]['cancel_id']) {
            $loop_schedule_extra[] = [
              'session_name' => $correction_data[$iii]['session_name'],
              $day_today => $correction_data[$iii]['time'],
              'duration' => $correction_data[$iii]['duration'],
              'attendance' => $correction_data[$iii]['attendance'],
              'comment' => $correction_data[$iii]['comment'],
              'color' => 1
            ];
            $correction_data[$iii]['cancel_id'] = 'break';
          }
          if ($value['id'] === $correction_data[$iii]['cancel_id']) {
            $loop_schedule[$key]['session_name'] = $correction_data[$iii]['session_name'];
            $loop_schedule[$key][$day_today] = $correction_data[$iii]['time'];
            $loop_schedule[$key]['duration'] = $correction_data[$iii]['duration'];
            $loop_schedule[$key]['attendance'] = $correction_data[$iii]['attendance'];
            $loop_schedule[$key]['comment'] = $correction_data[$iii]['comment'];
            $loop_schedule[$key]['semester_range'] = $correction_data[$iii]['semester_range'];
            $loop_schedule[$key]['time_zone'] = $correction_data[$iii]['time_zone'];
            $loop_schedule[$key]['id'] = '';
          }
        }
      }
    }

    // дополнительные строки
    if (count($loop_schedule_extra) > 0) {
      for ($i3=0; $i3 < count($loop_schedule_extra); $i3++) {
        $loop_schedule[] = $loop_schedule_extra[$i3];
      }
    }

    // Подготавливаем вспомогательный массив
    $sort_field = [];
    foreach ($loop_schedule as $key => $row) {
      $sort_field[$key] = $row[$day_today];
    }

    // Сортируем
    array_multisort($sort_field, SORT_ASC, $loop_schedule);

    // Возвращаем расписание
    return $loop_schedule;
  }
}
// добавить корректировки
 ?>
