<?php

header("Content-Type: application/json; charset=utf-8");
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365);  // 365 day cookie lifetime
session_start ();

function exception_handler($exception) {
	header("http/1.0 500 Internal server error");
	echo $exception->getMessage();
	exit;
}

function error_handler ($errno, $errstr, $errfile, $errline) {
    header("http/1.0 500 Internal server error");
    echo "$errno: ".$errstr;
    exit;
}

set_exception_handler('exception_handler');
set_error_handler('error_handler');

// logs
include_once '../../../extensions/write_to_log/write_to_log.php';

function db_getAdminIdBySessionId ($sessionId){

  $sessionId = db_real_escape_string($sessionId);

  $res=db_query ("SELECT admin_key from admin_session where id_session='$sessionId'");
  if ($row = $res->fetch_assoc()) return $row['admin_key'];
  return NULL;
}

function db_getAdminNameById($adminId){
    global $db;
    $adminId = $db->real_escape_string($adminId);

    $res = db_query("SELECT name FROM member WHERE `key`='$adminId'");
    if($row = $res->fetch_object()){
        return $row->name;
    }
    return null;
}

function db_getLocalityByKey($locality_key){
    global $db;
    $locality = $db->real_escape_string($locality_key);
    $res = db_query("SELECT name FROM locality WHERE `key`='$locality'");

    if ($row = $res->fetch_object()){
        return $row->name;
    }
    return null;
}

function db_getAdminLocality($adminId){
    global $db;
    $adminId = $db->real_escape_string($adminId);

    $res = db_query("SELECT locality_key FROM member WHERE `key`='$adminId'");

    if($res->num_rows>0){
        return $res->fetch_assoc()['locality_key'];
    }
    return '';
}

function db_getAdminCountry($adminId){
    global $db;
    $adminId = $db->real_escape_string($adminId);

    $res=db_query ("SELECT c.key as country
                    FROM member m
                    INNER JOIN locality l ON l.key = m.locality_key
                    INNER JOIN region r ON r.key = l.region_key
                    INNER JOIN country c ON c.key = r.country_key
                    WHERE m.key='$adminId'");

    while ($row = $res->fetch_assoc()) $country=$row['country'];
    return $country;
}

function db_getAdminRole ($adminId){
    global $db;
    $adminId = $db->real_escape_string($adminId);

    $res = db_query("SELECT role FROM admin WHERE member_key='$adminId' ");
    if ($row = $res->fetch_assoc()) return (int)$row['role'];
    return NULL;
}

$adminId = db_getAdminIdBySessionId (session_id());
