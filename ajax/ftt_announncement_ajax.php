<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/ftt/ftt_announcement_db.php";
include_once "../db/classes/db_operations.php";
include_once '../db/classes/date_convert.php';
// Подключаем ведение лога
include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Получам строки
/*
if (isset($_GET['type']) && $_GET['type'] === 'get_sessions') {
    echo json_encode(["result"=>get_sessions($_GET['id'])]);
    exit();
}
*/

?>
