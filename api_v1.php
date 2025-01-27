<?php
require_once 'config.php';
require_once 'db/classes/emailing.php';
if (isset($_GET['out'])) {
  if (isset($_GET['type']) && $_GET['type'] === 'crm_check_phone') {
    require_once 'extensions/api_v1/check_phone_lead.php';
    require_once 'extensions/api_v1/check_phone_deal.php';    
  } else {
    require_once 'extensions/api_v1/outgoing.php';
  }

} else {
  require_once 'extensions/api_v1/api.php';
}
