<?php
require_once 'rw_log.php';
if (isset($_GET['data']) && isset($_GET['type'])) {
  $_GET['data'] = $_GET['admin']. '. ' .$_GET['data'];
  if ($_GET['type'] == 'w') {
    RWLog::warning($_GET['member_key'], $_GET['data']);
  } elseif ($_GET['type'] == 'e') {
    RWLog::error($_GET['member_key'], $_GET['data']);
  } elseif ($_GET['type'] == 'd') {
    RWLog::debug($_GET['member_key'], $_GET['data']);
  } elseif ($_GET['type'] == 'f') {
    RWLog::fatal($_GET['member_key'], $_GET['data']);
  } else {
    RWLog::info($_GET['member_key'], $_GET['data']);
  }
} else {
  RWLog::error('NONE', 'НЕТ ДАННЫХ');
}
?>
