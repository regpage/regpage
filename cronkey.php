<?php
// проверяем ключ
if (isset($argv[1]) && isset($argv[2])) {
  if ($argv[1] !== 'key' || $argv[2] !== 'NJlzMcbCjZ') {
  	exit;
  }
} elseif (isset($_GET['key'])) {
  if ($_GET['key'] !== 'NJlzMcbCjZ') {
    exit;
  }
} else {
  exit;
}
