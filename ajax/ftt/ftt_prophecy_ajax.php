<?php
// подключаем запросы
include_once "db/ftt/ftt_prophecy_db.php";
include_once "db/classes/db_operations.php";
require_once 'db/classes/ftt_lists.php';
include_once 'db/classes/emailing.php';
include_once 'db/classes/member.php';
include_once 'db/classes/short_name.php';
include_once 'db/classes/date_convert.php';
include_once 'db/classes/time_convert.php';
include_once 'db/classes/files/files_up.php';

// set line
if (isset($_GET['type']) && $_GET['type'] === 'set_line') {
  echo json_encode(["result"=>ProphecyDB::setLine(json_decode($_POST['data']))]);
  exit();
}
// get line
if (isset($_GET['type']) && $_GET['type'] === 'get_line') {
  echo json_encode(["result"=>ProphecyDB::getLine($_GET['id'])]);
  exit();
}
// remove line
if (isset($_GET['type']) && $_GET['type'] === 'dlt_line') {
  echo json_encode(["result"=>ProphecyDB::dltLine($_GET['id'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'set_pic') {

  if (isset($_FILES['blob0'])) {
    $all_files = '';
    $file = '';
    foreach ($_FILES as $key => $value) {
      if ($value['error'] === UPLOAD_ERR_OK) {
        if (!empty($file)) {
          $all_files .= ';';
        }
        // check
        $target_file_temp = explode(".", $value['name']);
        $fileExtension = strtolower(end($target_file_temp));
        $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png', 'webp', 'bmp', 'zip', 'rar', '7z', 'txt', 'xls', 'xlsx', 'doc', 'docx', 'odt', 'ods', 'rtf', 'pdf');
        if (!in_array($fileExtension, $allowedfileExtensions)) {
          echo json_encode(["result"=>'Неизвестный формат файла.']);
          exit();
        }
        // file
        $newFileName = md5(time() . $value['name']) . '.' . $fileExtension;
        $picsPath = 'ajax/img/prophecy';
        if (!is_dir($picsPath)) {
          mkdir($picsPath, 0775, true);
        }
        $target_file = $picsPath . '/' . basename($newFileName);
        move_uploaded_file($value['tmp_name'], $target_file);
        $file = $target_file;

        //compress от 1 до 100, 1 = высокая степень сжатия, 100 = низкая степень сжатия.
        $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png', 'webp', 'bmp');
        if (in_array($fileExtension, $allowedfileExtensions)) {
          $imagick = new Imagick(__DIR__ . '/../../' . $target_file);
          $data = $imagick->identifyImage();
          if ($data['mimetype'] === 'image/jpeg' && $imagick->getImageLength() > 500000 && $imagick->getImageLength() < 2000000){
            // ПОНИЖАЕМ КАЧЕСТВО
            $imagick->setCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality(40);
            // ИЗМЕНЯЕМ РАЗМЕР В МЕНЬШУЮ СТОРОНУ
            $cropWidth = $imagick->getImageWidth();
            $cropHeight = $imagick->getImageHeight();
            if ($cropHeight < $cropWidth && $cropWidth > 2500) {
              $imagick->scaleimage(2500, 0);
            } elseif ($cropWidth < $cropHeight && $cropHeight > 2500) {
              $imagick->scaleimage(0, 2500);
            }
            // записываем файл
            $imagick->writeImage(__DIR__ . '/../../' . $target_file);
          } elseif ($data['mimetype'] === 'image/jpeg' && $imagick->getImageLength() >= 2000000 && $imagick->getImageLength() <= 5000000){
            // ПОНИЖАЕМ КАЧЕСТВО
            $imagick->setCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality(40);
            // ИЗМЕНЯЕМ РАЗМЕР В МЕНЬШУЮ СТОРОНУ
            $cropWidth = $imagick->getImageWidth();
            $cropHeight = $imagick->getImageHeight();
            if ($cropHeight < $cropWidth && $cropWidth > 2500) {
              $imagick->scaleimage(2500, 0);
            } elseif ($cropWidth < $cropHeight && $cropHeight > 2500) {
              $imagick->scaleimage(0, 2500);
            }
            // записываем файл
            $imagick->writeImage(__DIR__ . '/../../' . $target_file);
          } elseif ($data['mimetype'] === 'image/jpeg' && $imagick->getImageLength() > 5000000) {
            // ПОНИЖАЕМ КАЧЕСТВО
            $imagick->setCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality(40);
            // ИЗМЕНЯЕМ РАЗМЕР В МЕНЬШУЮ СТОРОНУ
            $cropWidth = $imagick->getImageWidth();
            $cropHeight = $imagick->getImageHeight();
            if ($cropHeight < $cropWidth && $cropWidth > 2500) {
              $imagick->scaleimage(2500, 0);
            } elseif ($cropWidth < $cropHeight && $cropHeight > 2500) {
              $imagick->scaleimage(0, 2500);
            }
            // записываем файл
            $imagick->writeImage(__DIR__ . '/../../' . $target_file);
          } elseif ($data['mimetype'] === 'image/jpeg' && $imagick->getImageLength() <= 500000) {
            // ПОНИЖАЕМ КАЧЕСТВО
            $imagick->setCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality(60);
            // записываем файл
            $imagick->writeImage(__DIR__ . '/../../' . $target_file);
          }
        }
        $all_files .= $file;
      }
    }
    $file = $all_files;
  } else {
    $file = '';
  }

  $result_file = FilesUp::setPics($_GET['id'], $file, 'ftt_prophecy', 'file', false);

  echo json_encode(["result"=>[$result_file, $file]]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'delete_pic') {
  // готовим данные
  $db_data_get = new DbData('get', 'ftt_prophecy');
  $db_data_get->set('field', 'file');
  $db_data_get->set('condition_field', 'id');
  $db_data_get->set('condition_value', $_GET['id']);
  // выполняем
  $check = DbOperation::operation($db_data_get->get());

  $check = explode(';', $check);
  $files = '';
  foreach ($check as $key => $value) {
    if ($value !== $_GET['patch']) {
      if (empty($files)) {
        $files .= $value;
      } else {
        $files .= ';' . $value;
      }
    }
  }

  // готовим данные
  $db_data = new DbData('set', 'ftt_prophecy');
  $db_data->set('field', 'file');
  $db_data->set('value', $files);
  $db_data->set('condition_field', 'id');
  $db_data->set('condition_value', $_GET['id']);
  // выполняем
  echo DbOperation::operation($db_data->get());
  // file
  //$hi = explode('ajax/', $_GET['patch']);
  if (!empty($_GET['patch'])) {
    unlink($_GET['patch']);
  }

  exit();
}
