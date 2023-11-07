<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/ftt/ftt_attendance_db.php";
include_once "../db/ftt/ftt_attendance_skip_db.php";
include_once "../db/ftt/ftt_attendance_meet_db.php";
include_once "../db/classes/schedule_class.php";
include_once "../db/classes/db_operations.php";
include_once '../db/classes/date_convert.php';
include_once '../db/classes/emailing.php';
include_once '../db/classes/trainee_data.php';
include_once '../db/classes/member.php';
include_once '../db/classes/short_name.php';
include_once '../db/classes/CutString.php';
include_once '../db/classes/ftt_reading/bible.php';
include_once '../db/classes/statistic/biblereading.php';
require_once '../db/classes/ftt_lists.php';

// Подключаем ведение лога
include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Получам строки
if (isset($_GET['type']) && $_GET['type'] === 'get_sessions') {
    echo json_encode(["result"=>get_sessions($_GET['id'])]);
    exit();
}

// Обновляем строки
if (isset($_GET['type']) && $_GET['type'] === 'updade_data_blank') {
    if ($_GET['field'] === 'status' && $_GET['value'] === '1') {
      setMissedClasses($_GET['id']);
    }
    if (isset($_GET['value_late'])) {
      echo json_encode(["result"=>set_attendance_time($_GET['id'], $_GET['field'], $_GET['value'], $_GET['value_late'], $_GET['value_absence'])]);
    } else {
      echo json_encode(["result"=>set_attendance($_GET['id'], $_GET['field'], $_GET['value'], $_GET['header'])]);
      if (isset($_GET['reason']) && $_GET['reason'] === '1') {
        set_attendance($_GET['id'], 'late', 0, 0);
        set_attendance($_GET['id'], 'absence', 0, 0);
      } elseif (isset($_GET['reason']) && $_GET['reason'] === '0') {
        set_attendance($_GET['id'], 'late', $_GET['late'], 0);
        set_attendance($_GET['id'], 'absence', $_GET['absence'], 0);
      }
    }
    exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'updade_mark_blank') {
    echo json_encode(["result"=>set_attendance($_GET['id'], $_GET['field'], $_GET['value'], $_GET['header'])]);
    exit();
}

// получаем архивные строки
if (isset($_GET['type']) && $_GET['type'] === 'get_attendance_archive') {
    echo json_encode(["result"=>getFttAttendanceSheetAndStrings($_GET['member_key'], $_GET['period'])]);
    exit();
}

// Обновляем строки
if (isset($_GET['type']) && $_GET['type'] === 'set_attendance_archive') {
    echo json_encode(["result"=>set_attendance_archive($_GET['id'], $_GET['archive'])]);
    exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'create_extrahelp') {
    echo set_extrahelp_automatic($_GET['member_key'], $_GET['date'], $_GET['reason'], $_GET['attendance_id']);
    exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'create_late') {
    echo  json_encode(["result"=>set_late_automatic($_GET['member_key'], $_GET['date'], $_GET['delay'], $_GET['session_name'], $_GET['end_time'], $_GET['id_attendance'])]);
    exit();
}

// Получаем мероприятия для добавления / удаления в бланке.
if (isset($_GET['type']) && $_GET['type'] === 'get_sessions_staff') {
  echo json_encode(["result"=>schedule_class::get($_GET['semester_range'], $_GET['time_zone'], date_convert::yyyymmdd_to_ddmmyyyy($_GET['date']), $_GET['day'])]);
  exit();
}

// Удалить мероприятия в ручную.
if (isset($_GET['type']) && $_GET['type'] === 'dlt_sessions_in_blank') {
  echo json_encode(["result"=>dlt_sessions_in_blank($_GET['id'])]);
  exit();
}

// Добавить мероприятия в ручную.
if (isset($_GET['type']) && $_GET['type'] === 'add_sessions_staff_all') {
  echo json_encode(["result"=>add_sessions_staff_all($_POST['data'])]);
  exit();
}

// Добавить одно мероприятие в ручную.
if (isset($_GET['type']) && $_GET['type'] === 'dlt_session_staff') {
  echo json_encode(["result"=>dlt_session_staff($_POST['data'])]);
  exit();
}

// Добавить одно мероприятие в ручную.
if (isset($_GET['type']) && $_GET['type'] === 'add_session_staff') {
  echo json_encode(["result"=>add_session_staff($_POST['data'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'undo_status') {
  // ОТКАТ ПОСЕЩАЕМОСТИ
  // STATUS
  // готовим данные
  $db_data_stat = new DbData('set', 'ftt_attendance_sheet');
  $db_data_stat->set('field', 'status');
  $db_data_stat->set('value', 0);
  $db_data_stat->set('condition_field', 'id');
  $db_data_stat->set('condition_value', $_GET['id']);
  $db_data_stat->set('changed', 1);
  $echo_stat = DbOperation::operation($db_data_stat->get());

  // MARK
  // готовим данные
  $db_data_mark = new DbData('set', 'ftt_attendance_sheet');
  $db_data_mark->set('field', 'mark');
  $db_data_mark->set('value', 0);
  $db_data_mark->set('condition_field', 'id');
  $db_data_mark->set('condition_value', $_GET['id']);
  $echo_mark = DbOperation::operation($db_data_mark->get());

  // LATES
  // готовим данные
  $db_data_late = new DbData('dlt', 'ftt_late');
  $db_data_late->set('condition_field', 'id_attendance');
  $db_data_late->set('condition_value', $_GET['id']);
  $echo_late = DbOperation::operation($db_data_late->get());

  // EXTRAHELP
  // готовим данные
  $db_data_extra = new DbData('dlt', 'ftt_extra_help');
  $db_data_extra->set('condition_field', 'attendance_and_late');
  $db_data_extra->set('condition_value', $_GET['id']);
  $echo_extrahelp = DbOperation::operation($db_data_extra->get());

  // EXTRAHELP with 3 LATES
  $echo_lates_in_extrahelp = undo_extrahelp_lates($_GET['id']);
  write_to_log::info($adminId, 'Откат бланка '.$_GET['id']);
  // MISSED CLASS
  $echo_skip = dltMissedClass($_GET['id']);

  // Echo result
  echo json_encode([
    'stat'=>$echo_stat,
    'late'=>$echo_late,
    'extrahelp'=>$echo_extrahelp,
    'lates_in_extrahelp'=>$echo_lates_in_extrahelp,
  ]);

  // EXIT
  exit();
}

// bible book & chapter
if (isset($_GET['type']) && $_GET['type'] === 'get_bible_chapter') {
  $bible_books = new Bible;
  echo json_encode(["result"=>$bible_books->getBook($_GET['book'])]);
  exit();
}
// bible statistic
if (isset($_GET['type']) && $_GET['type'] === 'get_bible_statistic') {
  echo json_encode(["result"=>BibleReading::get_readed($_GET['trainee_id'])]);
  exit();
}
// bible statistic
if (isset($_GET['type']) && $_GET['type'] === 'get_bible_statistic_dates') {
  echo json_encode(["result"=>BibleReading::get_by_dates($_GET['trainee_id'])]);
  exit();
}

// PERMISSIONS
// save permission.
if (isset($_GET['type']) && $_GET['type'] === 'set_permission') {
  echo json_encode(["result"=>set_permission($_POST['data'], $adminId)]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'get_permission') {
  echo json_encode(["result"=>get_permission($_GET['sheet_id'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'get_permission_archive') {
  echo json_encode(["result"=>get_permission_archive($_GET['sheet_id'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'notice') {
  // готовим данные
  $db_data_notice = new DbData('set', 'ftt_permission_sheet');
  $db_data_notice->set('field', 'notice');
  $db_data_notice->set('value', $_GET['data']);
  $db_data_notice->set('condition_field', 'id');
  $db_data_notice->set('condition_value', $_GET['id']);
  echo DbOperation::operation($db_data_notice->get());
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'delete_permission_blank') {
  // готовим данные
  $db_data = new DbData('dlt', 'ftt_permission_sheet');
  $db_data->set('condition_field', 'id');
  $db_data->set('condition_value', $_GET['id']);
  DbOperation::operation($db_data->get());

  $db_data_str = new DbData('dlt', 'ftt_permission');
  $db_data_str->set('condition_field', 'sheet_id');
  $db_data_str->set('condition_value', $_GET['id']);
  echo DbOperation::operation($db_data_str->get());
  exit();
}

// SKIP
if (isset($_GET['type']) && $_GET['type'] === 'set_skip_blank') {
  setSkipBlank($_POST['data']);
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
        $target_file = 'img/' . basename($newFileName);
        move_uploaded_file($value['tmp_name'], $target_file);
        $file = 'ajax/' . $target_file;

        //compress
        $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png', 'webp', 'bmp');
        if (in_array($fileExtension, $allowedfileExtensions)) {
          $imagick = new Imagick(__DIR__ . '/' . $target_file);
          $data = $imagick->identifyImage();
          if ($data['mimetype'] === 'image/jpeg' && $imagick->getImageLength() > 500000 && $imagick->getImageLength() < 2000000){
            $imagick->setCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality(60);
            $imagick->writeImage(__DIR__ . '/' . $target_file);
          } elseif ($data['mimetype'] === 'image/jpeg' && $imagick->getImageLength() >= 2000000 && $imagick->getImageLength() <= 5000000){
            $imagick->setCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality(50);
            $imagick->writeImage(__DIR__ . '/' . $target_file);
          } elseif ($data['mimetype'] === 'image/jpeg' && $imagick->getImageLength() > 5000000) {
            $imagick->setCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality(40);
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

  // сохраняем ссылку
  // готовим данные
  /*$db_data = new DbData('set', 'ftt_skip');
  $db_data->set('field', 'file');
  $db_data->set('value', $file);
  $db_data->set('condition_field', 'id');
  $db_data->set('condition_value', $_GET['id']);
  // выполняем
  DbOperation::operation($db_data->get());
  */
  $result_file = setPics($_GET['id'], $file);

  echo json_encode(["result"=>[$result_file, $file]]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'delete_pic') {
  // готовим данные
  $db_data_get = new DbData('get', 'ftt_skip');
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
  $db_data = new DbData('set', 'ftt_skip');
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

if (isset($_GET['type']) && $_GET['type'] === 'delete_skip') {
  // готовим данные
  $db_data_get = new DbData('get', 'ftt_skip');
  $db_data_get->set('field', 'file');
  $db_data_get->set('condition_field', 'id');
  $db_data_get->set('condition_value', $_GET['id']);
  // выполняем
  $check = DbOperation::operation($db_data_get->get());

  $check = explode(';', $check);

  foreach ($check as $key => $value) {
    $file = explode('ajax/', $value);
    if (isset($file[1]) && !empty($file[1])) {
      unlink($file[1]);
    }
  }
  // готовим данные
  $db_data = new DbData('dlt', 'ftt_skip');
  $db_data->set('condition_field', 'id');
  $db_data->set('condition_value', $_GET['id']);
  // выполняем
  echo DbOperation::operation($db_data->get());
  exit();
}

// bible reading
if (isset($_GET['type']) && $_GET['type'] === 'get_bible_data') {
  echo json_encode(["result"=>get_bible_data($_GET['member_key'], $_GET['date'])]);
  exit();
}

?>
