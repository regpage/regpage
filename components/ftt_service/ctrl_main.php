<?php
// РАЗДЕЛ
// DB
//include_once 'db/ftt/ftt_list_db.php';
// Classes
//include_once 'db/classes/members.php';
if ($ftt_access['group'] === 'staff') {
  //include_once 'components/ftt_service/ctrl_content_part_staff.php';
} elseif ($ftt_access['group'] === 'trainee') {
  //include_once 'components/ftt_service/ctrl_content.php';
}
// Списки
// $serving_ones_list_full = ftt_lists::serving_ones_full();
// $trainee_list_full = ftt_lists::trainee_full();
