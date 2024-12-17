<?php
// ==== РАЗДЕЛ ЗВОНКИ ==== //
// preheader
require_once "components/main/preheader.php";

// Глобальные переменные разделов
require_once "components/regpage/main/var_main.php";

// Переменные раздела
require_once "components/regpage/calls/ctrl.php";

// Header
//require_once "components/main/head.php";
require_once "header2.php";

// временно
require_once "db.php";

// Меню
//require_once "components/main/nav.php";
require_once "nav2.php";

// HTML код раздела
require_once "components/regpage/main/content_container.php";
// модальные окна
include_once "components/regpage/calls/modals.php";
// JS раздела
require_once "components/regpage/calls/js.php";

// Footer
require_once "components/main/footer.php";
