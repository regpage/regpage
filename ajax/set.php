<?php
include_once "ajax.php";


if (isset($_GET['type']) && $_GET['type'] === 'set_subsidies') {
  include_once '../db/regpage/classes/reg/subsidies.php';
  $subsidies = new Subsidies($_GET['event_id']);
  echo json_encode(["result"=> $subsidies->addMember($_GET['member_key'], $_GET['ticket'])]);
  exit;
}

if (isset($_GET['type']) && $_GET['type'] === 'get_members_subsidies') {
  include_once '../db/regpage/classes/reg/subsidies.php';
  $subsidies = new Subsidies($_GET['event_id']);
  if (isset($_GET['subtype']) && $_GET['subtype'] === 'list') {
    echo json_encode(["result"=> $subsidies->getMembersList()]);
  } elseif (isset($_GET['subtype']) && $_GET['subtype'] === 'count') {
    echo json_encode(["result"=> $subsidies->getCount()]);
  }
  exit;
}


/* BEGIN #ПОДДЕРЖКА 20 БРАТЬЕВ В ПОЕЗДКЕ В МАНИЛ */

if (isset($_GET['type']) && $_GET['type'] === 'get_brothers_dotation_list') {
    echo json_encode(["result"=> db_brothersDotationList()]);
    exit;
}
if (isset($_GET['type']) && $_GET['type'] === 'get_brothers_have_tickets') {
    echo json_encode(["result"=> db_brothersHaveTickets()]);
    exit;
}
if (isset($_GET['type']) && $_GET['type'] === 'get_brothers_dotation') {
  if (isset($_GET['member_key'])) {
    echo json_encode(["result"=> db_brothersDotationCheck($_GET['member_key'])]);
  } else {
    echo json_encode(["result"=> db_brothersDotationCheck()]);
  }
  exit;
}
if (isset($_GET['type']) && $_GET['type'] === 'get_have_tickets_count') {
    // echo json_encode(["result"=> db_brothersDotationCheck()]);
    echo json_encode(["result"=> db_brothersHaveTicketsCount()]);
    exit;
}
if (isset($_GET['type']) && $_GET['type'] === 'set_red_background') {
    echo json_encode(["result"=> db_setRedBackground($_GET['members_keys'], $_GET['event_id'])]);
    exit;
}
if (isset($_GET['type']) && $_GET['type'] === 'brothers_dotation') {
    echo json_encode(["result"=> db_brothersDotation($_GET['member_key'], $_GET['ticket'], $_GET['event_id'])]);
    exit;
}
if (isset($_GET['type']) && $_GET['type'] === 'brothers_dotation_group') {
    echo json_encode(["result"=> db_brothersDotationGroup($_GET['members_keys'], $_GET['event_id'])]);
    exit;
}

// красный фон
function db_setRedBackground($memberKeys, $eventId)
{
  if (empty($memberKeys)) {
    return false;
  }
  global $db;
  $memberKeys = $db->real_escape_string($memberKeys);
  $eventId = $db->real_escape_string($eventId);
  $memberKeys = explode(',', $memberKeys);
  $condition = '';
  foreach ($memberKeys as $key => $value) {
    if (empty($condition)) {
      $condition .= " `member_key` = '{$value}' ";
    } else {
      $condition .= " OR `member_key` = '{$value}' ";
    }
  }
  $res = db_query ("UPDATE reg SET `questionable` = 1 WHERE ({$condition}) AND event_key='{$eventId}'");

  return $res;
}
// список братьев с дотацией
function db_brothersDotationList()
{
  $list = [];

  $res = db_query("SELECT `member_key` FROM `brothers_dotation`");
  while ($row = $res->fetch_assoc()) $list[$row['member_key']] = $row['member_key'];

  return $list;
}

// количество записей
function db_brothersDotationCheck($memberKey=false)
{
  global $db;
  $memberKey = $db->real_escape_string($memberKey);
  $isExist = '';
  if ($memberKey) {
    $isExist = db_brothersDotationExist($memberKey);
  }
  $isFilled = 0;
  if (empty($isExist)) {
    $res = db_query("SELECT count(`member_key`) AS total FROM `brothers_dotation`");
    while ($row = $res->fetch_assoc()) $isFilled = $row['total'];
  } else {
    $isFilled = 'exist';
  }

  return $isFilled;
}

// братья с билетами
function db_brothersHaveTicketsCount($eventKey = '20250013')
{
  global $db;
  $eventKey = $db->real_escape_string($eventKey);
  $brothersHaveTickets = 0;
  $res = db_query("SELECT COUNT(r.member_key) AS total
    FROM reg r
    JOIN member m ON m.key = r.member_key
    WHERE r.flight_num_arr != ''  AND r.flight_num_dep != '' AND m.male = 1 AND r.event_key = '{$eventKey}'");
  while ($row = $res->fetch_assoc()) $brothersHaveTickets = $row['total'];


  return $brothersHaveTickets;
}

function db_brothersHaveTickets($eventKey = '20250013') {
  global $db;
  $eventKey = $db->real_escape_string($eventKey);
  $result = [];
  $res = db_query("SELECT `member_key` FROM `reg` WHERE `flight_num_arr` != ''  AND `flight_num_dep` != '' AND `event_key` = '{$eventKey}'");
  while ($row = $res->fetch_assoc()) $result[$row['member_key']] = $row['member_key'];

  return $result;
}

function db_brotherHaveTickets($memberKey, $eventKey = '20250013') {
  global $db;
  $memberKey = $db->real_escape_string($memberKey);
  $eventKey = $db->real_escape_string($eventKey);

  $result = '';
  $res = db_query("SELECT `member_key` FROM `reg` WHERE `member_key` = '{$memberKey}' AND `flight_num_arr` != '' AND `flight_num_dep` != '' AND `event_key` = '{$eventKey}'");
  while ($row = $res->fetch_assoc()) $result = $row['member_key'];

  return $result;
}

// проверка существующей записи
function db_brothersDotationExist($memberKey) {
  global $db;
  $memberKey = $db->real_escape_string($memberKey);
  $isExist='';

  $res = db_query("SELECT `member_key` FROM `brothers_dotation` WHERE member_key = '$memberKey'");
  while ($row = $res->fetch_assoc()) $isExist = $row['member_key'];

  return $isExist;
}

// проверка существующей записи
function db_isBrother($memberKey) {
  global $db;
  $memberKey = $db->real_escape_string($memberKey);
  $isBrother='';

  $res = db_query("SELECT `male` FROM `member` WHERE `key` = '{$memberKey}'");
  while ($row = $res->fetch_assoc()) $isBrother = $row['male'];

  return $isBrother;
}

// добавление / удаление дотации
function db_brothersDotation($memberKey, $ticket, $eventId)
{
  global $db;
  $memberKey = $db->real_escape_string($memberKey);
  $ticket = $db->real_escape_string($ticket);
  $eventId = $db->real_escape_string($eventId);
  $isFilled = '';
  $isExist = db_brothersDotationExist($memberKey);

  if (!empty($isExist) && !$ticket) {
    // db_query("DELETE FROM `brothers_dotation` WHERE `member_key`='$memberKey'");
    return db_brothersDotationCheck();
  } elseif (!empty($isExist) && $ticket) {
    return 'no changes';
  } elseif (empty($isExist) && $ticket) {
    $haveTickets = db_brotherHaveTickets($memberKey);
    $isFilled = db_brothersDotationCheck();
    if ($isFilled < 80 && !empty($haveTickets)) {
      db_query("INSERT INTO `brothers_dotation` (`member_key`) VALUES ('$memberKey')");
      return db_brothersDotationCheck();
    } else {
      return 'no changes';
    }
  }
}
// пакетное добавление в таблицу дотаций
function db_brothersDotationGroup($membersKeys, $eventId)
{
  global $db;
  $membersKeys = $db->real_escape_string($membersKeys);
  $eventId = $db->real_escape_string($eventId);
  $membersKeys = explode(',', $membersKeys);
  foreach ($membersKeys as $value) {
    $isExist = db_brothersDotationExist($value);
    $isBrother = db_isBrother($value);
    if (empty($isExist) && $isBrother == 1) {
      $haveTickets = db_brotherHaveTickets($value);
      if (!empty($haveTickets)) {
        $isFilled = db_brothersDotationCheck();
        if ($isFilled < 80) {
          db_query("INSERT INTO `brothers_dotation` (`member_key`) VALUES ('{$value}')");
          return true;
        } else {
          return false;
        }
      }
    }
  }
}
/* END */

/* Задаём значение в поле questionable таблицы reg*/
if (isset($_GET['type']) && $_GET['type'] === 'set_questionable') {
  echo set_questionable($_GET['member_id'], $_GET['event_id'], $_GET['value']);
  exit;
}

if (isset ($_GET['sort_field']))
{
    $_SESSION['sort_field_'.$_GET ['event']]=$_GET ['sort_field'];
    $sort_field = $_GET ['sort_field'];
}
else if (isset($_GET ['event']) && isset ($_SESSION['sort_field_'.($_GET['event'])]))
    $sort_field = $_SESSION['sort_field_'.($_GET ['event'])];
else
    $sort_field = 'name';

if (isset ($_GET['sort_type']))
{
    $_SESSION['sort_type_'.$_GET ['event']]=$_GET ['sort_type'];
    $sort_type = $_GET ['sort_type'];
}
else if (isset($_GET ['event']) && isset ($_SESSION['sort_type_'.($_GET ['event'])]))
    $sort_type = $_SESSION['sort_type_'.($_GET ['event'])];
else
    $sort_type = 'asc';

if (isset ($_POST ['message']) && isset ($_POST ['event']) && isset ($_POST ['name']) && isset ($_POST ['email']) && !isset ($_POST['admins']))
{
    $email = db_getTeamEmail ($_POST ['event']);
    $adminId = db_getMemberIdBySessionId (session_id());
    $locality = db_getMemberLocality($adminId);
    $locality = $locality ? "<br><br>Населённый пункт отправителя: $locality" : "";
    $error = null;

    $message = stripslashes ($_POST ['message']).$locality;

    if ($email){
        $from_name = stripslashes ($_POST ['name']);
        $from_email = stripslashes ($_POST ['email']);
        $arrEmails = explode(',', $email);
        foreach ($arrEmails as $value) {
            $res = EMAILS::sendEmail ($value, "Сообщение с сайта reg-page.ru: ".($from_name), $message, $from_email);
            if($res != null){
                $error = $res;
            }
        }
    }
    else
        $error = "Сообщение не может быть послано, т.к. адрес команды регистрации не определен";

    if($error == null){
        echo json_encode(["result"=>true]);
        exit;
    }
}

if (isset ($_POST ['message']) && isset($_POST ['event']) && isset ($_POST ['name']) && isset ($_POST ['email']) && isset ($_POST['admins']))
{
    $email = db_getTeamAdmins();
    if($_POST ['event']!="") $infoEvent = db_getEventInfoForAdmins($_POST ['event']);
    else $infoEvent="";

    if (!isset ($_POST ['guest']))
    {
        $locality = db_getMemberLocality(db_getMemberIdBySessionId (session_id()));
        if ($locality) $locality = "<br><br>nНаселённый пункт отправителя: $locality";
    }
    else{
        $locality ="";
    }

    if ($email)
    {
        header("Content-Type: text/plain; charset=utf-8");
        $from_name = stripslashes ($_POST ['name']);
        $from_email = stripslashes ($_POST ['email']);
        // $headers = "From: $from_name<$from_email>\r\nReply-To: $from_name<$from_email>\r\n";
        $arrEmails = explode(',', $email);
        foreach ($arrEmails as $value) {
            EMAILS::sendEmail (stripslashes ($value), "Сообщение с сайта reg-page.ru - ".($from_name), (stripslashes ($_POST ['message'])).$locality."\n".$infoEvent."\n"."Страница: ".($_POST["admins"]), $from_email);
        }
        exit;
    }
    else
        $error = "Сообщение не может быть послано, т.к. адрес команды не определен";
}

if (!isset($error))
{
    $adminId = db_getMemberIdBySessionId (session_id());
    if (!$adminId)
    {
        header("HTTP/1.0 401 Unauthorized");
        exit;
    }
}

if(isset ($_GET['set_login'])){
    if(isset($_POST['login'])){
        if(UTILS::sendConfirmationEmailToChangeLogin($_POST['login'], $adminId)){
            db_logoutAdmin($adminId, session_id());
            echo json_encode(["result"=>true]);
        }
        else{
            echo json_encode(["result"=>false]);
        }
    }
    else{
        echo json_encode(["result"=>false]);
    }
    exit;
}
if(isset ($_GET['invite_users'])){
    if(isset($_POST['users'])){
        echo json_encode(["result"=> db_inviteUsersToEvent($_POST['showAdminName'], $adminId, $_POST['users'], $_POST['event'])]);
    }
    exit;
}
else if (isset ($_GET ['event']) && isset ($_POST ['send_to_members']) && isset ($_POST ['subject'])
    && isset ($_POST ['text']) && isset ($_POST ['from_name']) && isset ($_POST ['from_email']) )
{
    global $appRootPath;

    $eventId = $_GET ['event'];
    $type = $_POST ['type'];
    $subject = stripslashes ($_POST ['subject']);
    $text = str_replace("\n", '<br>', htmlspecialchars (stripslashes ($_POST ['text'])));
    $from_name = stripslashes ($_POST ['from_name']);
    $from_email = stripslashes ($_POST ['from_email']);
    //$headers  = 'MIME-Version: 1.0' . "\r\n";
    //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    //$headers .= "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nFrom: $from_name<$from_email>\r\nReply-To: $from_name<$from_email>\r\n";
    foreach (preg_split("/,/", $_POST ['send_to_members'], -1, PREG_SPLIT_NO_EMPTY) as $memberId)
    {
        $reg = db_getEventMember($memberId, $eventId);
        if (!$reg['regstate_key'] || $type!='invitation'){
            if (strstr ($text, '{СсылкаНаБланк}')){
                $permalink = db_getPermalink($memberId, $eventId);
                $body = str_replace('{СсылкаНаБланк}', '<a href="'.$appRootPath.'invites?link='.$permalink.'">'.$appRootPath.'invites?link='.$permalink.'</a>', $text);
            }
            else{
                $body = $text;
            }

            $userEmail = db_getMemberNameEmail($memberId);
            db_enqueueLetter ($memberId, $eventId, $subject, $body, trim($userEmail[1]), $from_email, $from_name);
        }
    }
}
else if(isset ($_GET['set_state'])){
    db_setMembersRegstateEvent($adminId, $_GET['event'], $_GET ['memberId'], $_GET ['setstate']);
}
else if(isset($_GET['set_attended_members'])){
    db_setAttendedDismissMembersEvent($adminId, $_GET['event'], isset($_GET ['set_attended_members']) ? $_GET ['set_attended_members'] : null, isset($_GET['dismiss_attended_members']) ? $_GET ['dismiss_attended_members'] : null);
}
else if(isset($_GET['confirm_registration'])){
    db_confirmRegistrationBulkMembersEvent($adminId, $_GET['event'], isset($_GET['membersIds']) ? preg_split("/,/", $_GET ['membersIds'], -1, PREG_SPLIT_NO_EMPTY) : null);
}
else if (isset ($_GET ['member']) && isset ($_GET ['event']))
{
    $getMemberId = db_setEventMember ($adminId, $_GET, $_POST);
    if (isset ($_GET ['create'])) {
      $dataForCreate['key'] = $getMemberId;
      $dataForCreate['name'] = $_POST['name'];
      $dataForCreate['author'] = db_getAdminNameById($adminId);
      if (substr($getMemberId, 0, 1) == 9) {
        db_sendMsgToRespOneSync(MEMBER_TYPE, $dataForCreate);
      }
    }
    if (isset($_GET ['register'])) {
      $msgToOrganizer = db_sendMessageToOrganizer ($_GET['event'], $getMemberId, $_POST['locality_key']);
    }
}
else if (isset ($_GET ['members']) && isset ($_GET ['event']) && !isset($_GET['checkServ']))
{
    db_setEventMembers ($adminId, $_GET ['event'], preg_split("/,/", $_GET ['members'], -1, PREG_SPLIT_NO_EMPTY),
                        $_POST["arr_date"], $_POST["arr_time"], $_POST["dep_date"], $_POST["dep_time"],
                        $_POST["accom"], $_POST["transport"], isset($_POST["status"])? $_POST["status"] : NULL, $_POST["coord"], isset($_POST["service"])? $_POST["service"] : NULL,
                        isset($_POST["mate"])? $_POST["mate"] : NULL, $_POST["parking"]);
}
else if (isset ($_GET ['remove_members']) && isset ($_GET ['event'])){
    db_unregisterMembers ($adminId, $_GET ['event'], preg_split("/,/", $_GET ['remove_members'], -1, PREG_SPLIT_NO_EMPTY));
}
elseif (isset ($_GET ['set_dates_arr'])) {
  db_registerMembersSetDates($adminId, $_GET ['event'], preg_split("/,/", $_GET ['register_members'], -1, PREG_SPLIT_NO_EMPTY), $_GET ['set_dates_arr'], $_GET ['set_dates_dep']);
}
else if (isset ($_GET ['register_members']) && isset ($_GET ['event'])){
    $invalid = db_registerMembers ($adminId, $_GET ['event'], preg_split("/,/", $_GET ['register_members'], -1, PREG_SPLIT_NO_EMPTY));
    $arr_original = preg_split("/,/", $_GET ['register_members'], -1, PREG_SPLIT_NO_EMPTY);
    $eventIdInvalid = $_GET ['event'];
    $arr_for_send = array();
    foreach ($arr_original as $memberInvalid){
      $resInvalid=db_query ("SELECT regstate_key FROM reg WHERE member_key='$memberInvalid' AND event_key='$eventIdInvalid'");
      $rowInvalid=$resInvalid->fetch_array();
      if ($rowInvalid['regstate_key'] =='01'){
        $arr_for_send[] = $memberInvalid;
      }
    }
    $msgToOrganizer = db_sendMessageToOrganizer ($_GET['event'], $arr_for_send);
}
else if (isset ($_GET ['reg_new_members']) && isset ($_GET ['event']))
{
    db_registerNewMembers ($adminId, $_GET ['event'], preg_split("/,/", $_GET ['reg_new_members'], -1, PREG_SPLIT_NO_EMPTY));
}
else if (isset ($_GET ['members']) && isset ($_GET ['event']) && isset($_GET['checkServ'])){
    db_setEventMembersService ($adminId,  $_GET ['event'], preg_split("/,/", $_GET ['members'], -1, PREG_SPLIT_NO_EMPTY),
            $_POST['paid'], $_POST['place'], isset($_POST['attended']) ? $_POST['attended'] : null);
}
else if (isset ($_GET ['member_id']) && isset ($_GET ['amount']) && isset ($_GET ['eventId'])) {
    db_setUserAid($_GET ['member_id'], $_GET ['amount'], $_GET ['eventId']);
    echo json_encode(["members"=>db_getAidStatistic ($_GET ['eventId'], isset($_GET['scope']) ? $_GET['scope'] : null , $adminId)]);
    exit;
}
elseif (isset ($_GET ['set_profile'])) {
    db_setProfile ($adminId, $_POST["name"], $_POST["birth_date"],
        $_POST["cell_phone"], $_POST["locality_key"], $_POST["new_locality"],
        $_POST["gender"]=="male" ? 1 : ($_POST["gender"]=="female" ? 0 : null),
        $_POST["citizenship_key"], $_POST['notice_info'], $_POST['notice_reg']);
    echo json_encode(["res"=>"ok"]);

    exit();
}
elseif (isset ($_GET ['set_password'])) {
    if(isset($_POST['pass']) && db_isPasswordValid($adminId, $_POST['pass']) && isset($_POST['newPass']) && strlen($_POST['newPass']) >= 5){
        db_setUserPassword($adminId, $_POST['newPass'],session_id());
        echo json_encode(["result"=> true]);
    }
    else{
        echo json_encode(["result"=> false]);
    }

    exit();
}

if(isset($_GET ['event'])){
    if(db_isAdminRespForReg($adminId, $_GET ['event'])){
        echo json_encode(array ("members"=> db_getDashboardMembersService (
            $_GET ['event'],
            isset ($_GET['attended'])? $_GET['attended'] : NULL,
            NULL,
            $sort_field, $sort_type,
            isset ($_GET['searchText'])? $_GET['searchText'] : NULL,
            isset ($_GET['coord'])? $_GET['coord'] : NULL,
            isset ($_GET['service'])? $_GET['service'] : NULL,
            NULL),
            "invalid"=>isset($invalid) ? $invalid : null,
            "localities"=>db_getEventLocalities ($_GET['event'])));
    }
    else{
        echo json_encode(array ("members"=>db_getDashboardMembers ($adminId, $_GET ['event'], $sort_field, $sort_type, isset ($_GET['searchText'])? $_GET['searchText'] : NULL,
            NULL, NULL),
            "invalid"=>isset($invalid) ? $invalid : null,
            "localities"=>db_getAdminEventLocalities ($_GET['event'], $adminId)));
    }
    exit;
}
else if(!isset($error))
    $error = "Неверные параметры запроса";

header("HTTP/1.0 400 Bad Request");
header("Content-Type: text/plain; charset=utf-8");
echo $error;

?>
