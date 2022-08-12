<?php
  // СПИСОК ПВОМ
  include_once 'db/classes/trainee_data.php';
  include_once 'db/classes/short_name.php';
  include_once 'db/classes/ftt_lists.php';
  include_once 'db/classes/date_convert.php';
  include_once 'db/classes/extra_lists.php';
  //include_once 'db/classes/ftt_info.php';
  include_once 'db/ftt/ftt_list_db.php';

// access
if ($ftt_access['group'] !== 'staff') {
  exit();
}

// данные обучающегося
$trainee_data = trainee_data::get_data($memberId);
$serving_trainee = '';
// служащие из обучающихся
if (isset($ftt_access['ftt_service']) && $ftt_access['ftt_service'] === '06') {
  $serving_trainee = 1;
}

// Координатор
if (isset($trainee_data['coordinator']) && $trainee_data['coordinator'] === '1' && $ftt_access['ftt_service'] !== '06') {
  $serving_trainee = 1;
}


$serving_ones_list = ftt_lists::serving_ones();
// $serving_ones_list_full = ftt_lists::serving_ones_full();
$serving_ones_list_list = ftt_lists::serving_ones_list();

$trainee_list = ftt_lists::trainee();
// $trainee_list_full = ftt_lists::trainee_full();
$trainee_list_list = ftt_lists::trainee_list();

$localities = [];
$localities_staff = [];

foreach ($trainee_list_list as $key => $value) {
  $localities[$value['locality_key']] = $value['locality_name'];
}

foreach ($serving_ones_list_list as $key => $value) {
  $localities_staff[$value['locality_key']] = $value['locality_name'];
}

asort($localities);
asort($localities_staff);

?>
