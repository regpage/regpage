<?php
    require_once "preheader.php";

    include_once "header2.php";
    // Меню
    include_once "nav2.php";

    // Общие переменные (стандартные)
    include_once "components/ftt_main/var_part.php";

    // Работа с БД
    include_once "db/ftt/ftt_reading_db.php";

    // Переменные раздела
    include_once "components/ftt_reading/var_part.php";

    // Подключение раздела, HTML код страницы
    include_once "components/ftt_main/html_part_refactoring.php";

    // HTML модальные окна основной страницы
    include_once "components/ftt_reading/modals_part.php";

    // JS общие скрипты
    include_once "components/ftt_main/js_main.php";

    // JS скрипты раздела
    include_once "components/ftt_reading/js_part.php";

    include_once "footer2.php";
