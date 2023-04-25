<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/ftt/ftt_attendance_db.php";
include_once "../db/ftt/ftt_attendance_skip_db.php";
include_once "../db/classes/schedule_class.php";
include_once "../db/classes/db_operations.php";
include_once '../db/classes/date_convert.php';
include_once '../db/classes/emailing.php';
include_once '../db/classes/trainee_data.php';
include_once '../db/classes/member.php';
include_once '../db/classes/short_name.php';
include_once '../db/classes/CutString.php';

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
    if (isset($_GET['value_late'])) {
      echo json_encode(["result"=>set_attendance_time($_GET['id'], $_GET['field'], $_GET['value'], $_GET['value_late'], $_GET['value_absence'])]);
    } else {
      setMissedClasses($_GET['id']);
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
?>
