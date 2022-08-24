<?php
    include_once 'header2.php';
    // Меню
    include_once 'nav2.php';

    //$devision_name = 'ftt_NEW_DEVISION';
    $devision_name = strlen($_SERVER['REQUEST_URI']);
    if (substr($_SERVER['HTTP_HOST'], 0,4) === 'ftt_') {
      $main_devision = 'ftt_main';
    } else {
      $main_devision = 'main';
    }

    // РАСПИСАНИЕ Переменные раздела
    include_once "components/{$devision_name}/var_part.php";

    // HTML код основной страницы
    include_once "components/{$main_devision}/html_part_refactoring.php";

    // HTML модальные окна основной страницы
    include_once "components/{$devision_name}/modals_part.php";

    // JS
    include_once "components/{$devision_name}/js_part.php";

    include_once "footer2.php";
?>
