<?php
// Ajax
include_once 'ajax.php';
// подключаем запросы
include_once '../db/ftt/ftt_extra_help_db.php';
include_once '../db/classes/statistics.php';
include_once '../db/classes/ftt_lists.php';
include_once '../db/classes/files/files_up.php';
include_once "../db/classes/db_operations.php";

// Подключаем ведение лога
//include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Добавляем строку
if(isset($_GET['type']) && $_GET['type'] === 'add_extra_help') {
    echo json_encode(["result"=>setAddExtraHelp($_POST)]);
    exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'update_extra_help') {
  echo json_encode(["result"=>updateAddExtraHelp($_POST)]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'delete_extra_help') {
  echo json_encode(["result"=>deleteExtraHelpString($_GET['id'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'set_extra_help_done') {
  echo json_encode(["result"=>setExtraHelpDone($_GET['id'], $_GET['archive'], $adminId)]);
  exit();
}

// ==== LATE ====
// set a late to done
if (isset($_GET['type']) && $_GET['type'] === 'set_late_done') {
  echo json_encode(["result"=>setLateDone($_GET['id'], $_GET['done'])]);
  exit();
}

// Добавляем строку
if(isset($_GET['type']) && $_GET['type'] === 'add_late'){
    echo json_encode(["result"=>setAddLate($_POST)]);
    exit();
}

// Обновляем строку
if (isset($_GET['type']) && $_GET['type'] === 'update_late') {
  echo json_encode(["result"=>updateAddLate($_POST)]);
  exit();
}

// удаляем строку
if (isset($_GET['type']) && $_GET['type'] === 'delete_late') {
  echo json_encode(["result"=>deleteLateString($_GET['id'])]);
  exit();
}

// получаем отчёт для печати
if (isset($_GET['type']) && $_GET['type'] === 'get_print_report') {
  echo json_encode(["result"=>statistics::extra_help_count(ftt_lists::get_trainees_by_staff($_GET['service_one_key']), true)]);
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
        $picsPath = 'img/extrahelp';
        if (!is_dir($picsPath)) {
          mkdir($picsPath, 0775, true);
        }
        $target_file = $picsPath . '/' . basename($newFileName);
        move_uploaded_file($value['tmp_name'], $target_file);
        $file = 'ajax/' . $target_file;

        //compress от 1 до 100, 1 = высокая степень сжатия, 100 = низкая степень сжатия.
        $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png', 'webp', 'bmp');
        if (in_array($fileExtension, $allowedfileExtensions)) {
          $imagick = new Imagick(__DIR__ . '/' . $target_file);
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
            $imagick->writeImage(__DIR__ . '/' . $target_file);
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
            $imagick->writeImage(__DIR__ . '/' . $target_file);
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
            $imagick->writeImage(__DIR__ . '/' . $target_file);
          } elseif ($data['mimetype'] === 'image/jpeg' && $imagick->getImageLength() <= 500000) {
            // ПОНИЖАЕМ КАЧЕСТВО
            $imagick->setCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality(60);
            // записываем файл
            $imagick->writeImage(__DIR__ . '/' . $target_file);
          }
        }
        $all_files .= $file;
      }
    }
    $file = $all_files;
  } else {
    $file = '';
  }

  $result_file = FilesUp::setPics($_GET['id'], $file, 'ftt_extra_help');

  echo json_encode(["result"=>[$result_file, $file]]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'delete_pic') {
  // готовим данные
  $db_data_get = new DbData('get', 'ftt_extra_help');
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
  $db_data = new DbData('set', 'ftt_extra_help');
  $db_data->set('field', 'file');
  $db_data->set('value', $files);
  $db_data->set('condition_field', 'id');
  $db_data->set('condition_value', $_GET['id']);
  // выполняем
  echo DbOperation::operation($db_data->get());
  // file
  $hi = explode('ajax/', $_GET['patch']);
  if (isset($hi[1]) && !empty($hi[1])) {
    unlink($hi[1]);
  }

  exit();
}
