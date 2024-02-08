<?php
// cookie
$sortingStat = 'asc';
if (isset($_COOKIE['sorting_stat']) && $_COOKIE['sorting_stat'] === 'desc') {
  $sortingStat = 'desc';
}
