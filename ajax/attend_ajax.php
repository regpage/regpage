<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/classes/db_operations.php";
// Подключаем ведение лога
//include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Сохранение чекбокса
if (isset($_GET['type']) && $_GET['type'] === 'change_checkbox') {
    $db_data = new DbData('set', 'member');
    $db_data->set('field', $_GET['field']);
    $db_data->set('value', $_GET['value']);
    $db_data->set('condition_field', 'key');
    $db_data->set('condition_value', $_GET['id']);    
    DbOperation::operation($db_data->get());
    exit();
}
