<?php
    include_once "header2.php";
    // Меню
    include_once "nav2.php";

    // Глобальные переменные разделов
    include_once "components/ftt_main/var_part.php";

    // БД
    include_once "db/ftt/ftt_announcement_db.php";

    // Переменные раздела
    include_once "components/ftt_announcement/var_part.php";

    // HTML код основной страницы
    include_once "components/ftt_main/html_part_refactoring.php";

    // HTML модальные окна страницы
    include_once "components/ftt_announcement/modals_part.php";

    // глобальный для ftt JS код
    include_once "components/ftt_main/js_main.php";

    // JS раздела
    include_once "components/ftt_announcement/js_part.php";

    include_once "footer2.php";
?>
