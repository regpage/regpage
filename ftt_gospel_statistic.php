<?php
    require_once "preheader.php";

    include_once "header2.php";
    // Меню
    include_once "nav2.php";
    // БД
    include_once "db/ftt/ftt_gospel_db.php";

    // РАСПИСАНИЕ Переменные раздела
    include_once "components/ftt_gospel/var_part.php";

    // HTML код основной страницы
    include_once "components/ftt_main/html_part_refactoring.php";

    // HTML модальные окна основной страницы
    include_once "components/ftt_gospel/stat_modals_part.php";

    // JS
    include_once "components/ftt_gospel/js_part.php";

    include_once "footer2.php";
?>
