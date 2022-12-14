<?php
include_once "header2.php";
include_once "nav2.php";
include_once "db/ftt/ftt_db.php";

// Проверка прав пользователя.
// служащий ПВОМ
$accessToPage = 0;
// Права
include_once "db/modules/ftt_page_access.php";
?>
