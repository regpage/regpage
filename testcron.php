<?php
exit;
$CRON_ROOT_PATH = __DIR__;
// ТЕСТ рассылки
require 'config.php';
require 'db/classes/emailing.php';
require 'db/classes/short_name.php';

Emailing::send_by_key('000005716', 'Страница регистрации', 'Проверка связи.');
