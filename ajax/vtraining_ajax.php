<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/classes/db_operations.php";
include_once "../db/classes/filters_custom.php";
// Подключаем ведение лога
//include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}
/*
if (isset($_GET['type']) && $_GET['type'] === 'get_filters') {

}
*/
