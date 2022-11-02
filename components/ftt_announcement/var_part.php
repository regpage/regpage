<?php
  // ОБЪЯВЛЕНИЯ ПВОМ
  // БД
  include_once "db/ftt/ftt_announcement_db.php";
  // Classes
  include_once 'db/classes/DatesCompare.php';
  // Cookie
  $tab_one_active = '';
  $tab_two_active = 'active';
  if (isset($_COOKIE['tab_active']) && $_COOKIE['tab_active'] === 'inbox') {
    $tab_one_active = '';
    $tab_two_active = 'active';
  } elseif (isset($_COOKIE['tab_active']) && $_COOKIE['tab_active'] === 'outbox') {
    $tab_one_active = 'active';
    $tab_two_active = '';
  }
  // Sorting
  // Tabs

  // Готовим списки
  // Служащие
  $recipients_group = [];
  $recipients_group['staff']['01'] = '';
  foreach ($serving_ones_list_list as $key => $value) {
    if (empty($recipients_group['staff']['01'])) {
      $recipients_group['staff']['01'] = $key;
    } else {
      $recipients_group['staff']['01'] = $recipients_group['staff']['01'].','.$key;
    }
    if (empty($recipients_group['staff'][$value['time_zone']])) {
      $recipients_group['staff'][$value['time_zone']] = $key;
    } else {
      $recipients_group['staff'][$value['time_zone']] = $recipients_group['staff'][$value['time_zone']].','.$key;
    }
  }

  // Обучающиеся
  $recipients_group['trainee_14']['01'] = '';
  $recipients_group['trainee_56']['01'] = '';
  $recipients_group['coordinators']['01'] = '';
  foreach ($trainee_list_list as $key => $value) {
    if ($value['semester'] < 5) {
      if (empty($recipients_group['trainee_14']['01'])) {
        $recipients_group['trainee_14']['01'] = $key;
      } else {
        $recipients_group['trainee_14']['01'] = $recipients_group['trainee_14']['01'].','.$key;
      }
      if (empty($recipients_group['trainee_14'][$value['time_zone']])) {
        $recipients_group['trainee_14'][$value['time_zone']] = $key;
      } else {
        $recipients_group['trainee_14'][$value['time_zone']] = $recipients_group['trainee_14'][$value['time_zone']].','.$key;
      }
    } else {
      if (empty($recipients_group['trainee_56']['01'])) {
        $recipients_group['trainee_56']['01'] = $key;
      } else {
        $recipients_group['trainee_56']['01'] = $recipients_group['trainee_56']['01'].','.$key;
      }
      if (empty($recipients_group['trainee_56'][$value['time_zone']])) {
        $recipients_group['trainee_56'][$value['time_zone']] = $key;
      } else {
        $recipients_group['trainee_56'][$value['time_zone']] = $recipients_group['trainee_56'][$value['time_zone']].','.$key;
      }
    }

    if ($value['coordinator'] === '1') {
      if (empty($recipients_group['coordinators']['01'])) {
        $recipients_group['coordinators']['01'] = $key;
      } else {
        $recipients_group['coordinators']['01'] = $recipients_group['coordinators']['01'].','.$key;
      }
      if (empty($recipients_group['coordinators'][$value['time_zone']])) {
        $recipients_group['coordinators'][$value['time_zone']] = $key;
      } else {
        $recipients_group['coordinators'][$value['time_zone']] = $recipients_group['coordinators'][$value['time_zone']].','.$key;
      }
    }
  }
