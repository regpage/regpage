<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/classes/db_operations.php";
include_once "../db/classes/filters_custom.php";
// Подключаем ведение лога
//include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Сохранение чекбокса
if (isset($_GET['type']) && $_GET['type'] === 'change_checkbox') {
  $check='';
  $condition_field = 'key';
  if ($_GET['table'] === 'attendance') {
    $condition_field = 'member_key';
    $condition_value = $_GET['id'];
    $res = db_query("SELECT DISTINCT `member_key` FROM `attendance` WHERE `{$condition_field}` = '{$condition_value}'");
    while ($row = $res->fetch_assoc()) $check=$row['member_key'];
  } else {
    $check = 1;
  }

  if ($_GET['table'] === 'attendance' && !$check) {
    $field = $_GET['field'];
    $value = $_GET['value'];
    $member_key = $_GET['id'];
    $res = db_query("INSERT INTO `attendance` (`member_key`, `$field`) VALUES ('$member_key', '$value')");
  } else {
    $db_data = new DbData('set', $_GET['table']);
    $db_data->set('field', $_GET['field']);
    $db_data->set('value', $_GET['value']);
    $db_data->set('condition_field', $condition_field);
    $db_data->set('condition_value', $_GET['id']);
    $res = DbOperation::operation($db_data->get());
  }
  //echo $res;
  echo $check;
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'get_filters') {
  if(isset($_GET['add_filter'])){
      CustomFilters::addFilter($_GET['filter_name'], $adminId);

      echo json_encode(["filters" => CustomFilters::getFilters($adminId)]);
      exit();
  }

  if(isset($_GET['get_filters'])){
      echo json_encode(["filters" => CustomFilters::getFilters($adminId)]);
      exit();
  }

  if(isset($_GET['show_filter'])){
      echo json_encode(["filters" => CustomFilters::getFilters($adminId)]);
      exit();
  }

  if(isset($_GET['save_filter_localities'])){
      CustomFilters::saveFilterLocalities($_GET['filter_id'], $_GET['filter_localities']);

      echo json_encode(["filters" => CustomFilters::getFilters($adminId)]);
      exit();
  }

  if(isset($_GET['save_filter'])){
      CustomFilters::saveFilter($_GET['filter_id'], $_GET['filter_name']);

      echo json_encode(["filters" => CustomFilters::getFilters($adminId)]);
      exit();
  }

  if(isset($_GET['remove_filter'])){
      CustomFilters::removeFilter($_GET['filter_id']);

      echo json_encode(["filters" => db_getAdminFilters($adminId)]);
      exit();
  }
}
