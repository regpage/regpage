<?php
include_once 'db/ftt/ftt_fellowship_activity_db.php';
// Фильтры
if (isset($_COOKIE['meet__activity_flt_staff']) && !empty($_COOKIE['meet__activity_flt_staff'])) {
  $serving_ones_activy_flt = $_COOKIE['meet__activity_flt_staff'];
} else {
  $serving_ones_activy_flt = $memberId;
}

if (isset($_COOKIE['meet_activity_flt_trainee']) && !empty($_COOKIE['meet_activity_flt_trainee'])) {
  $trainee_activy_flt = $_COOKIE['meet_activity_flt_trainee'];
} else {
  $trainee_activy_flt = '_all_';
}

$fellowshipList = get_fellowship_activity_list($serving_ones_activy_flt, $trainee_activy_flt);
