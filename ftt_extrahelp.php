<?php
    require_once "preheader.php";
    
    include_once "header2.php";
    // Меню
    include_once "nav2.php";
    // БД
    include_once "db/ftt/ftt_extra_help_db.php";

    // Переменные раздела
    include_once "components/ftt_extra_help/var_part.php";

    // HTML код основной страницы
    include_once "components/ftt_main/html_part.php";

    // HTML модальные окна основной страницы
    include_once "components/ftt_extra_help/modals_part.php";

    // JS
    include_once "components/ftt_extra_help/js_part.php";

    include_once "footer2.php";
?>
