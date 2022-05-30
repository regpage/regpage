<?php
include_once "ajax.php";
include_once "../db/youthdb.php";

$adminId = db_getMemberIdBySessionId (session_id());
if (!$adminId){
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

$sort_field = isset ($_COOKIE['sort_field_youth']) ? $_COOKIE ['sort_field_youth'] : 'name';
$sort_type = isset ($_COOKIE['sort_type_youth']) ? $_COOKIE ['sort_type_youth'] : 'asc';

if (isset ($_GET ['update_member'])){
    $data['key'] = db_setEventMember ($adminId, $_GET, $_POST);
    if (isset($_GET ['create'])) {
      $data['name'] = $_POST['name'];
      $data['author'] = db_getAdminNameById($adminId);
      db_sendMsgToRespOneSync(MEMBER_TYPE, $data);
    }
}

if(isset($_GET['remove'])){
    db_removeMember($_POST['memberId']);
}

if (isset ($_GET ['member']) && isset ($_GET ['active'])){
    db_setMemberActive ($adminId, $_GET ['member'], $_GET ['active'], isset ($_GET ['reason']) ? $_GET ['reason'] : null);
}

echo json_encode(["members"=> db_getYouthList($adminId, $sort_field, $sort_type)]);
