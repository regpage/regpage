<?php
// Ajax
include_once "ajax.php";
include_once "../db/contactsdb.php";
include_once '../logWriter.php';
$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}
/*
if(isset($_GET['???'])){
    echo json_encode(["some"=>db_???($adminId, $_GET['???'])]);
    exit();
}
*/
?>
