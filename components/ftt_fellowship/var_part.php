<?php
  include_once 'db/ftt/ftt_fellowship_db.php';

  $serving_ones_list_full = ftt_lists::serving_ones_full();
  $trainee_list_full = ftt_lists::trainee_full();
  $kbk_list = ftt_lists::kbk_brothers();
  $serving_ones_list_meet = ftt_lists::get_fellowship_list();
  $serving_ones_list = array_merge($serving_ones_list_meet, $kbk_list);
