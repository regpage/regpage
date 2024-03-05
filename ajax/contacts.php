<?php
// Ajax
include_once "ajax.php";
include_once "../db/contactsdb.php";
include_once '../logWriter.php';
require_once '../db/classes/emailing.php';
$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId)
{
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

if(isset($_GET['get_contacts'])){
    echo json_encode(["contacts"=>db_getContactsStrings($adminId, $_GET['role'])]);
    exit();
}

if(isset($_GET['get_contacts_prev'])){
    echo json_encode(["contacts"=>db_getContactsStringsPrev($adminId, $_GET['cont_role'])]);
    exit();
}

if(isset($_GET['get_contact'])){
    echo json_encode(["contact"=>db_getContactString($_GET['id'])]);
    exit();
}
/*
if(isset($_GET['new_update_contact'])){
    echo json_encode(["id"=>db_newOrUpdateContactString($adminId, $_GET['data'])]);
    exit();
}
*/
if(isset($_POST['type']) && $_POST['type'] === 'save'){
    echo json_encode(["id"=>db_newOrUpdateContactString($adminId, $_POST['blank_data'])]);
    exit();
}

if(isset($_POST['type']) && $_POST['type'] === 'delete_contact'){
    echo json_encode([db_deleteContactString($_POST['delete_contacts_id'], $adminId)]);
    exit();
}

if(isset($_POST['type']) && $_POST['type'] === 'archiviate_contact'){
    echo json_encode([db_setContactsToArchive($_POST['archiviate_contacts_id'], $adminId)]);
    exit();
}

if(isset($_POST['type']) && $_POST['type'] === 'responsible_set'){
    db_responsibleSet($_POST['id'], $_POST['responsible'], $adminId);
    exit();
}

if(isset($_POST['type']) && $_POST['type'] === 'responsible_set_zero'){
    db_responsibleSetZero($_POST['data'], $adminId);
    exit();
}

if(isset($_GET['add_crm_id'])){
    db_crmIdSet($_GET['crm_id'], $_GET['id'], $adminId, $_GET['text'], $_GET['comment'],$_GET['notes']);
    exit();
}

// Statistic status
if(isset($_GET['add_history_status'])){
    db_addStatusHistoryStr($_GET['status'], $_GET['id_contact']);
    exit();
}

// CHAT
if(isset($_GET['get_messages'])){
    echo json_encode(["messages"=>db_getChatMessages($adminId,$_GET['id'])]);
    exit();
}

if(isset($_GET['new_message'])){
    echo json_encode(["messages"=>db_newChatMsg($adminId, $_GET['data'], $_GET['list'])]);
    exit();
}

if(isset($_GET['update_message'])){
    db_updateChatMsg($_GET['id'], $_GET['text']);
    exit();
}

if(isset($_GET['delete_message'])){
    db_deleteChatMsg($_GET['id']);
    exit();
}

//EMAIL TO UKRAINE
if (isset($_POST['type']) && $_POST['type'] === 'message_ua') {
    $email = getValueParamByName('crm_ua_email');
    //$adminId = db_getMemberIdBySessionId (session_id());
    $error = null;
    $message = stripslashes($_POST['text_message']);
    if ($email){
            $res = EMAILS::sendEmail ($email, "Новый заказ с сайта регистрации", $message);
            if($res != null){
                $error = $res;
            }
    } else {
        $error = "Сообщение не может быть послано, т.к. адрес не определен";
    }
    if($error == null){
        $textmext = 'UA Заказ отправлен по email на Украину. '.$_POST['text_message'];
        //logFileWriter($adminId, $textmext, 'WARNING');
        echo json_encode(["result"=>true]);
        exit;
    }
}

// EMAIL TO LATVIA
if (isset($_POST['type']) && $_POST['type'] === 'message_lv') {
    $email = getValueParamByName('crm_lv_email');
    //$adminId = db_getMemberIdBySessionId (session_id());
    $error = null;
    $message = stripslashes($_POST['text_message']);
    if ($email){
            $res = EMAILS::sendEmail ($email, "Новый заказ с сайта регистрации", $message);
            if($res != null){
                $error = $res;
            }
    } else {
        $error = "Сообщение не может быть послано, т.к. адрес не определен";
    }
    if($error == null){
        $textmext = 'UA Заказ отправлен по email в Латвию. '.$_POST['text_message'];
        //logFileWriter($adminId, $textmext, 'WARNING');
        echo json_encode(["result"=>true]);
        exit;
    }
}

// notification
if(isset($_GET['set_notice'])){
    db_newNotification($_GET['admin'],$_GET['contact']);
    exit();
}

if(isset($_GET['delete_notices'])){
    db_deleteNotification($_GET['id']);
    exit();
}

// set status multiple
if(isset($_POST['type']) && $_POST['type'] === 'set_status_multiple'){
    db_statusMultipleSet($_POST['contact_id'], $_POST['new_status']);
    exit();
}

if (isset($_POST['type']) && $_POST['type'] === 'set_resp_for_admin'){
    db_setRespForAdmin($_POST['id'], $_POST['keys'], $_POST['role']);
    exit();
}

if(isset($_GET['get_resp_group'])){
    echo json_encode(["result" => db_getAdminResponsiblesGroup($_GET['id'])]);
    exit();
}

if(isset($_GET['set_resp_group_role'])){
    db_setUpdadteContactsRoleAdmin($_GET['id'], $_GET['role']);
    exit();
}

if(isset($_GET['get_admin_role'])){
    echo json_encode(["result" => db_getContactsRoleAdmin($_GET['id'])]);
    exit();
}

if(isset($_GET['get_localities_by_admin'])){
    echo json_encode(["result" => db_getAdminMeetingLocalities($_GET['id'])]);
    exit();
}

if(isset($_GET['check_remove_account'])){
    echo json_encode(["result" => db_checkRemoveAccount($_GET['member'])]);
    exit();
}

if(isset($_GET['get_archived_string'])){
    echo json_encode(db_getArchivedStrings());
    exit();
}

if(isset($_GET['set_recover_archived_string'])){
    echo json_encode(db_setRecoverArchivedStrings($_GET['id'], $adminId));
    exit();
}

if(isset($_GET['get_thash_string'])){
    echo json_encode(db_getTrashStrings($adminId));
    exit();
}

if(isset($_GET['set_recover_string'])){
    echo json_encode(db_setRecoverStrings($_GET['id'], $adminId));
    exit();
}

if(isset($_GET['delete_one_contact'])){
    echo json_encode(db_deleteOneContact($_GET['id'], $adminId));
    exit();
}

if(isset($_GET['archive_one_contact'])){
    echo json_encode(db_archiveOneContact($_GET['id'], $adminId));
    exit();
}

if(isset($_GET['get_unique_group'])){
    echo json_encode(db_getUniqueProjects());
    exit();
}

if(isset($_GET['set_new_name_for_group'])){
    if (isset($_GET['old_name'])) {
      echo json_encode(setNewNameForGroup($adminId, $_GET['new_name'], $_GET['old_name']));
      exit();
    } else {
      echo json_encode(setNewNameForGroup($adminId, $_GET['new_name']));
      exit();
    }
}

if(isset($_GET['get_short_statistics_for_comboboxes'])){
    echo json_encode(getShortStatResp($adminId));
    exit();
}

// LOG send to CRM
if(isset($_GET['set_log_CRM'])){
    echo json_encode(logFileWriter($adminId, $_GET['message'], $_GET['status']));
    exit();
}
