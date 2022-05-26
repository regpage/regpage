<?php
// Fetch
include_once "../db.php";
include_once "../db/contactsdb.php";
include_once '../logWriter.php';
$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId)
{
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// CHAT
if(isset($_GET['get_messages'])){
    echo json_encode(["messages"=>db_getChatMessages($adminId,$_GET['id'])]);
    exit();
}

?>
