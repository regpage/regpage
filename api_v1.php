<?php
header("Access-Control-Allow-Origin: *");
require_once 'config.php';
require_once 'db/classes/emailing.php';
if (isset($_GET['out'])) {
  if (isset($_GET['type']) && $_GET['type'] === 'crm_check_phone_lead') {
    require_once 'extensions/api_v1/check_phone_lead.php';
  } elseif (isset($_GET['type']) && $_GET['type'] === 'crm_check_phone_deal') {
    require_once 'extensions/api_v1/check_phone_deal.php';
  } elseif (isset($_GET['key']) && $_GET['key'] = 'oursecretkey' && isset($_GET['type'])) { // добавить ключ isset($_GET['key']) && $_GET['key'] === '' возможно использовать поля action (например get & etc)
    if ($_GET['type'] === 'ftt_schedule') { // получить расписание 1-4 семестра на сегодня
      require_once 'extensions/api_v1/ftt/ftt_schedule_api.php';
    } elseif ($_GET['type'] === 'ftt_infoboard') { // получить инфо для экрана обучения на сегодня
      require_once 'extensions/api_v1/ftt/ftt_infoboard_api.php';
    }

  } else {
    require_once 'extensions/api_v1/outgoing.php';
  }

} else {
  require_once 'extensions/api_v1/api.php';
}
