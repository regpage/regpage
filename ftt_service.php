<?php
    // Раздел служение
    //
    require_once "preheader.php";
    //
    include_once "header2.php";
    // Меню
    include_once "nav2.php";

    // БД
    include_once "db/ftt/ftt_service_db.php";
    // Переменные раздела
    include_once "components/ftt_service/ctrl_main.php";
    //HTML код основной страницы
    include_once "components/ftt_main/html_part_refactoring.php";
    // HTML модальные окна основной страницы
    include_once "components/ftt_service/modals.php";
    // JS
    include_once "components/ftt_service/js.php";
    //
    include_once "footer2.php";
