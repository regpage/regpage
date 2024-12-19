<?php
require_once 'config.php';
require_once 'db/classes/emailing.php';
if (isset($_GET['out'])) {
  require_once 'extensions/api_v1/outgoing.php';
} else {
  require_once 'extensions/api_v1/api.php';
}
