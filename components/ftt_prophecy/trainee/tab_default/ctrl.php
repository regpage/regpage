<?php
$cookieAll = 0;
// фильтр текущие
if (!empty($_COOKIE['prophecy-trainee_flt_list_currents']) && $_COOKIE['prophecy-trainee_flt_list_currents'] === '1') {
  $cookieAll = 1;
}
