<?php
  include_once 'db/ftt/ftt_fellowship_db.php';
  include_once 'db/classes/time_convert.php';

  $serving_ones_list_full = ftt_lists::serving_ones_full();
  $trainee_list_full = ftt_lists::trainee_full();
  $kbk_list = ftt_lists::kbk_brothers();
  if ($ftt_access['group'] === 'trainee' && isset($trainee_list_list[$memberId]) && $trainee_list_list[$memberId]['male'] === '1') {
    $serving_ones_list_meet = ftt_lists::serving_ones_fellowship_brothers();
  } else {
    $serving_ones_list_meet = ftt_lists::get_fellowship_list();
  }
  $serving_ones_list = array_merge($serving_ones_list_meet, $kbk_list);
  // Активный подраздел
  $fellowship_tab_active = 'active';
  $fellowship_bbd_tab_active = '';
  $fellowship_activity_tab_active = '';

  if (isset($_COOKIE['fellowship_tab']) && !empty($_COOKIE['fellowship_tab']) && $_COOKIE['fellowship_tab'] !== 'fellowship_tab_main') {
    $fellowship_tab_active = '';
    switch ($_COOKIE['fellowship_tab']) {
      case 'fellowship_tab_bbd':
        $fellowship_bbd_tab_active = 'active';
        break;
      case 'fellowship_tab_activity':
      $fellowship_activity_tab_active = 'active';
        break;
      default:
        $fellowship_tab_active = 'active';
        break;
    }
  }
