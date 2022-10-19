<?php
// db
include_once 'db/classes/trainee_data.php';
include_once 'db/classes/short_name.php';
include_once 'db/classes/ftt_lists.php';
include_once 'db/classes/date_convert.php';
include_once 'db/classes/statistics.php';
include_once 'db/classes/ftt_info.php';
// components
include_once 'components/ftt_blocks/FTT_Select_fields.php';

// access
if ($ftt_access['group'] === 'staff') {
  // получить группу служащего
} elseif ($ftt_access['group'] === 'trainee') {
  // данные обучающегося
  $trainee_data = trainee_data::get_data($memberId);
  $serving_trainee = '';
  // служащие из обучающихся
  if (isset($ftt_access['ftt_service']) && $ftt_access['ftt_service'] === '06') {
    $serving_trainee = 1;
    $ftt_access['serving_trainee'] = $ftt_access['ftt_service'];
  }

  // Координатор
  if (isset($trainee_data['coordinator']) && $trainee_data['coordinator'] === '1' && $ftt_access['ftt_service'] !== '06') {
    $serving_trainee = 1;
    $ftt_access['serving_trainee'] = $ftt_access['ftt_service'];
  }
} else {
  exit();
}

// lists
$serving_ones_list = ftt_lists::serving_ones();
$serving_ones_list_list = ftt_lists::serving_ones_list();
$trainee_list = ftt_lists::trainee();
$trainee_list_list = ftt_lists::trainee_list();

?>
