<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/ftt/ftt_db.php";
include_once "../db/classes/ftt_applications/ftt_candidates.php";
// Подключаем ведение лога
//include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Получаем все заявления
if(isset($_GET['type']) && $_GET['type'] === 'all_requests'){
    //write_to_log::debug('000005716', 'Запрошен весь список заявлений для раздела ПВОМ');//$adminId
    echo json_encode(["result"=>db_getAllRequests($adminId, $_GET['role'], $_GET['guest'], $_GET['sort'])]);
    exit();
}

// Добавляем заявление
if(isset($_GET['type']) && $_GET['type'] === 'add_application'){
    echo json_encode(["result"=>FttCandidates::add($_GET['member_key'], $_GET['guest'])]);
    exit();
}

// Удаляем заявление
/*
if(isset($_GET['type']) && $_GET['type'] === 'dlt_application'){
    echo json_encode(["result"=>FttCandidates::dlt($_GET['member_key'])]);
    exit();
}
*/

// Отправляем запрос заявления на ПВОМ
if(isset($_GET['type']) && $_GET['type'] === 'add_request_for'){
    echo json_encode(["result"=>sentRequestToPVOM($adminId)]);
    exit();
}

?>
