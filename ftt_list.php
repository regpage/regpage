<?php
    require_once "preheader.php";
    
    include_once "header2.php";
    // Меню
    include_once "nav2.php";

    // РАСПИСАНИЕ Переменные раздела
    include_once "components/ftt_list/var_part.php";

    // HTML код основной страницы
    include_once "components/ftt_main/html_part_refactoring.php";

    // HTML модальные окна основной страницы
    include_once "components/ftt_list/modals_part.php";

    // JS
    include_once "components/ftt_list/js_part.php";

    include_once "footer2.php";
?>
