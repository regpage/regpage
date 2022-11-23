<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/ftt/ftt_db.php";
// Подключаем ведение лога
include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Получаем все заявления
if(isset($_GET['type']) && $_GET['type'] === 'all_requests'){
    write_to_log::debug('000005716', 'Запрошен весь список заявлений для раздела ПВОМ');//$adminId
    echo json_encode(["result"=>db_getAllRequests($adminId, $_GET['role'], $_GET['guest'])]);
    exit();
}

?>
