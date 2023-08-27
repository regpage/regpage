<?php
// РАЗДЕЛ ЧТЕНИЕ
// DB
//include_once 'db/ftt/ftt_list_db.php';
// Classes
include_once 'db/classes/ftt_reading/bible.php';
include_once 'db/classes/trainee_data.php';
$bible_obj = new Bible;
$trainee_data = [];
if ($ftt_access['group'] === 'trainee') {
  $trainee_data = trainee_data::get_data($memberId);
}


// Списки
// $serving_ones_list_full = ftt_lists::serving_ones_full();
// $trainee_list_full = ftt_lists::trainee_full();
