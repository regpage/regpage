<?php
    // preheader
    require_once "components/main/preheader.php";

    // Глобальные переменные разделов
    require_once "components/regpage/main/var_main.php";
// exit;
    // Переменные раздела
    require_once "components/regpage/attend/var_part.php";

    // Header
    require_once "header2.php";
    // временно
    require_once "db.php";
    // Меню
    require_once "nav2.php";

    // HTML код раздела
    require_once "components/regpage/main/content_container.php";

    // HTML модальные окно бланка
    include_once "components/main/blank.php";

    // Глобальный JS код для ftt
    require_once "components/regpage/main/js_main.php";

    // JS раздела
    require_once "components/regpage/attend/js_part.php";

    // Footer
    require_once "footer2.php";
?>
