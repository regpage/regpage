<?php
    include_once "header2.php";
    // Меню
    include_once "nav2.php";

    // Глобальные переменные разделов
    include_once "components/ftt_main/var_part.php";

    // БД
    include_once "db/ftt/ftt_announncement_db.php";

    // Переменные раздела
    include_once "components/ftt_announncement/var_part.php";

    // HTML код основной страницы
    include_once "components/ftt_main/html_part_refactoring.php";

    // HTML модальные окна страницы
    include_once "components/ftt_announncement/modals_part.php";

    // глобальный для ftt JS код
    include_once "components/ftt_main/js_main.php";

    // JS раздела
    include_once "components/ftt_announncement/js_part.php";

    include_once "footer2.php";
?>
