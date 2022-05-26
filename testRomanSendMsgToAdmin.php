<script>
  function sendMsgToRegionalAdmin(memberId) {
    // Установить связь. Создать функцию возвращающую ID админа, ответственного за регистрацию в местности заданного участника. Роль админа 1 или 2 или только 1
    regionalAdmin = membedrId + locality + adminThisLocality;
  }
</script>
<?php
include_once "db.php";
//Write action to txt log
function mySysLog($value)
{
  date_default_timezone_set('Europe/Moscow');
    $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Attempt: ".($value).PHP_EOL.
            "-------------------------".PHP_EOL;
file_put_contents('./syslog_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
}
// Check and Log
function checkParamAndLog($param, $msg)
{
  if($param == '' || $param == undefined || $param == NULL){
    mySysLog('ERROR '.$msg.' FAILED');
  return false;
}
}
// get admin id & location
function db_getsendMsgToRegionalAdmin($memberId){
    global $db;
    // $text = $db->real_escape_string();

    if($memberId == '' || $memberId == undefined || $memberId == NULL){
      mySysLog('ERROR Id of admin is missing. SECTION: Email to the admin about the user from his location. MESSAGE: The system cannot send Email to admin about the registration of new user at the event. FAILED');
      return false;
    }

    $res = db_query("SELECT m.email, m.cell_phone, m.name, m.locality_key, m.key as id FROM member m WHERE m.key LIKE '$memberId'");

    $members = array();
    while ($row = $res->fetch_assoc()) $members[]=$row;

    mySysLog('SUCCESS Locality key is '.$members[0][locality_key].'. SECTION: Email to the admin about the user from his location. MESSAGE: The system is preparing to send an administrator a new user registration letter to the event.');

    return $members[0][locality_key];
}

function giveMeMemberRegion($locationID)
{
  if($locationID == '' || $locationID == undefined || $locationID == NULL){
    mySysLog('ERROR Id of location is missing. SECTION: Email to the admin about the user from his location. MESSAGE: The system cannot send Email to admin about the registration of new user at the event. FAILED');
    return false;
  }
  $res = db_query("SELECT l.region_key, l.name, l.key as id FROM locality l WHERE l.key LIKE '$locationID'");

  $placeOfLocality = array();
  while ($row = $res->fetch_assoc()) $placeOfLocality[]=$row;

  mySysLog('SUCCESS Region key is '.$placeOfLocality[0][region_key].'. SECTION: Email to the admin about the user from his location. MESSAGE: The system is preparing to send an administrator a new user registration letter to the event.');

  return $placeOfLocality[0][region_key];
}

function giveMeCountry($regionID)
{
  if($regionID == '' || $regionID == undefined || $regionID == NULL){
    mySysLog('ERROR Id of region is missing. SECTION: Email to the admin about the user from his location. MESSAGE: The system cannot send Email to admin about the registration of new user at the event. FAILED');
    return false;
  }

  $res = db_query("SELECT r.country_key, r.key as id FROM region r WHERE r.key LIKE '$regionID'");

  $countryId = array();
  while ($row = $res->fetch_assoc()) $countryId[]=$row;

  mySysLog('SUCCESS Country key is '.$countryId[0][country_key].'. SECTION: Email to the admin about the user from his location. MESSAGE: The system is preparing to send an administrator a new user registration letter to the event.');

  return $countryId[0][country_key];
}

function giveMeRegionAdminsByCountry($countryKey)
{
  checkParamAndLog($countryKey, 'Country is missing. SECTION: Email to the admin about the user from his location. MESSAGE: The system cannot send Email to admin about the registration of new user at the event.');

  $res = db_query("SELECT a.country_key, a.locality_key, a.region_key, a.member_key FROM access a WHERE a.country_key LIKE '$countryKey'");

  $membersAdmin = array();

  while ($row = $res->fetch_assoc()) $membersAdmin[]=$row;

  mySysLog('SUCCESS The first line in the list of admins is '.$membersAdmin[0].'. SECTION: Email to the admin about the user from his location. MESSAGE: The system is preparing to send an administrator a new user registration letter to the event.');

  return $membersAdmin;
}

function giveMeAdminL1orL2($listAdmins)
{
  checkParamAndLog($listAdmins, 'List of Admins is missing. SECTION: Email to the admin about the user from his location. MESSAGE: The system cannot send Email to admin about the registration of new user at the event.');

  $membersAdmin = array();
  $listAdmins2 = array();
  $i=0;
  foreach ($listAdmins as &$value) {
    $res = db_query("SELECT ad.login, ad.role FROM admin ad WHERE ad.member_key LIKE '$value[member_key]' AND ad.role LIKE '2'");
    while ($row = $res->fetch_assoc()) $membersAdmin[]=$row;

      $listAdmins1 = $membersAdmin[$i][login];
      $listAdmins2[0] = $listAdmins2[0].$listAdmins1.' ';
      $i++;
  }

mySysLog('SUCCESS The email addresses of the admins have been selected. SECTION: Email to the admin about the user from his location. MESSAGE: The system is preparing to send an administrator a new user registration letter to the event.');

  return $listAdmins2[0];
}

function giveMeAdminRegion($memberRegion)
{
  checkParamAndLog($memberRegion, 'The ID region of member is missing. SECTION: Email to the admin about the user from his location. MESSAGE: The system cannot send Email to admin about the registration of new user at the event.');

  $res = db_query("SELECT a.locality_key, a.member_key FROM access a WHERE a.locality_key LIKE '$memberRegion'");

  $membersAdmin = array();

  while ($row = $res->fetch_assoc()) $membersAdmin[]=$row;

mySysLog('SUCCESS First line ID of the admins is '.$membersAdmin[0][member_key].'. SECTION: Email to the admin about the user from his location. MESSAGE: The system is preparing to send an administrator a new user registration letter to the event.');

  return $membersAdmin;
}

/*
function db_getRegionalAdminId($memberId){
    global $db;
    $text = $db->real_escape_string();

    if($text == ''){
        return false;
    }

    $res = db_query("SELECT DISTINCT m.email, m.cell_phone, m.name, m.key as id, l.name as locality, acc.member_key as locality_admin_key FROM member m
                    INNER JOIN access acc ON m.locality_key = acc.locality_key
                    INNER JOIN locality l ON m.locality_key = l.key

                    WHERE m.name LIKE '%$text%' LIMIT 0, 3");

    $members = array();
    while ($row = $res->fetch_assoc()) $members[]=$row;
    return $members;
}
*/
echo giveMeAdminL1orL2(giveMeAdminRegion(giveMeMemberRegion(db_getsendMsgToRegionalAdmin('000012243'))));

//final
function getMeAdminEmail($value)
{
  $a = db_getsendMsgToRegionalAdmin('000001797');
  $b = giveMeMemberRegion($a);
  $bb = giveMeAdminRegion($b);
  $c = giveMeCountry($b);

  if ($b) {
    $e = giveMeRegionAdminsByCountry($bb);
  }

  if ($c == 'RU' || $c == undefined || $c == NULL) {
    $d = giveMeRegionAdminsByCountry($c);
  }


}
?>
