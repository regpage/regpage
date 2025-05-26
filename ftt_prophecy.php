<?php
// Раздел пророчествование
require_once "preheader.php";
//
require_once "header2.php";
// Меню
require_once "nav2.php";
//

// БД
require_once "db/ftt/ftt_prophecy_db.php";
// общие переменные ftt
require_once "components/ftt_main/var_part.php";
// Переменные раздела
require_once "components/ftt_prophecy/ctrl.php";
//HTML код основной страницы
require_once "components/ftt_main/html_part_refactoring.php";
// HTML модальные окна основной страницы
require_once "components/ftt_prophecy/modals_ctrl.php";
// JS общие скрипты
include_once "components/ftt_main/js_main.php";
// JS
require_once "components/ftt_prophecy/js.php";
//
require_once "footer2.php";
