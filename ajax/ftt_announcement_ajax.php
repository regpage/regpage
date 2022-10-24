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

// Сохранение бланка
if (isset($_GET['type']) && $_GET['type'] === 'save_announcement') {
    echo json_encode(["result"=>saveAnnouncement($_POST['data'])]);
    exit();
}

// Получение данных бланка
if (isset($_GET['type']) && $_GET['type'] === 'get_announcement') {
    echo json_encode(["result"=>getAnnouncement($_GET['id'])]);
    exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'delete_announcement') {
    $db_data = new DbData('dlt', 'ftt_announcement');
    $db_data->set('condition_field', 'id');
    $db_data->set('condition_value', $_GET['id']);
    DbOperation::operation($db_data->get());
    exit();
}

?>
