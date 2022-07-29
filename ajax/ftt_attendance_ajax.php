<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/ftt/ftt_attendance_db.php";
include_once "../db/classes/schedule_class.php";
include_once "../db/classes/db_operations.php";
// Подключаем ведение лога
//include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Получам строки
if(isset($_GET['type']) && $_GET['type'] === 'get_sessions') {
    echo json_encode(["result"=>get_sessions($_GET['id'])]);
    exit();
}

// Обновляем строки
if(isset($_GET['type']) && $_GET['type'] === 'updade_data_blank') {
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
// получаем архивные строки
if(isset($_GET['type']) && $_GET['type'] === 'get_attendance_archive') {
    echo json_encode(["result"=>getFttAttendanceSheetAndStrings($_GET['member_key'], $_GET['period'])]);
    exit();
}

// Обновляем строки
if(isset($_GET['type']) && $_GET['type'] === 'set_attendance_archive') {
    echo json_encode(["result"=>set_attendance_archive($_GET['id'], $_GET['archive'])]);
    exit();
}

if(isset($_GET['type']) && $_GET['type'] === 'create_extrahelp') {
    echo set_extrahelp_automatic($_GET['member_key'], $_GET['date'], $_GET['reason'], $_GET['attendance_id']);
    exit();
}

if(isset($_GET['type']) && $_GET['type'] === 'create_late') {
    echo set_late_automatic($_GET['member_key'], $_GET['date'], $_GET['delay'], $_GET['session_name'], $_GET['end_time'], $_GET['id_attendance']);
    exit();
}

// Получаем мероприятия для добавления / удаления в бланке.
if (isset($_GET['type']) && $_GET['type'] === 'get_sessions_staff') {
  echo json_encode(["result"=>schedule_class::get($_GET['semester_range'], $_GET['time_zone'], $_GET['date'], $_GET['day'])]);
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
  echo json_encode(["result"=>DbOperation::operation($db_data_stat->get())]);
  unset($db_data_stat);

  // LATES
  // готовим данные
  $db_data_late = new DbData('dlt', 'ftt_late');
  $db_data_late->set('condition_field', 'id_attendance');
  $db_data_late->set('condition_value', $_GET['id']);
  echo json_encode(["result"=>DbOperation::operation($db_data_late->get())]);
  unset($db_data_late);

  // EXTRAHELP
  // готовим данные
  $db_data_extra = new DbData('dlt', 'ftt_extra_help');
  $db_data_extra->set('condition_field', 'attendance_and_late');
  $db_data_extra->set('condition_value', $_GET['id']);
  echo json_encode(["result"=>DbOperation::operation($db_data_extra->get())]);
  unset($db_data_extra);

  // EXTRAHELP with 3 LATES
  echo json_encode(["result"=>undo_extrahelp_lates($_GET['id'])]);

  // EXIT
  exit();
}

?>
