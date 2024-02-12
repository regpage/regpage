<?php
header("Content-Type: application/json; charset=utf-8");
session_start ();
function sanitizeString($var) {
  //$var = strip_tags($var);
  //$var = htmlentities($var);
  return stripslashes($var);
}
if (isset($_GET['type']) && $_GET['type'] === 'save_file') {
  $data = json_decode($_POST['data']);
  if (!isset($data->name) || !isset($data->content)) {
    echo 'Data error.';
    exit();
  }
  $checkName = explode('.', $data->name);
  if (count($checkName) <= 1 || $checkName[count($checkName)-1] !== 'txt') {
    echo 'File error.' . $checkName[-1];
    exit();
  }
  $res = file_put_contents('../content/'.sanitizeString($data->name), sanitizeString($data->content)); // sanitizeString($data->content)
  if ($res) {
    echo 1;
  } else {
    echo 0;
  }
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'get_file') {
  echo json_encode(file_get_contents($_GET['patch']));
  exit();
}
