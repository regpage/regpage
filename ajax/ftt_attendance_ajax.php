<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/ftt/ftt_attendance_db.php";
include_once "../db/classes/schedule_class.php";
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
    echo set_extrahelp_automatic($_GET['member_key'], $_GET['date'], $_GET['reason']);
    exit();
}

if(isset($_GET['type']) && $_GET['type'] === 'create_late') {
    echo set_late_automatic($_GET['member_key'], $_GET['date'], $_GET['delay'], $_GET['session_name'], $_GET['end_time'], $_GET['id_attendance']);
    exit();
}


if (isset($_GET['type']) && $_GET['type'] === 'dlt_sessions_in_blank') {
  echo json_encode(["result"=>dlt_sessions_in_blank($_GET['id'])]);
  exit();
}

if (isset($_GET['type']) && $_GET['type'] === 'get_sessions_staff') {
  echo json_encode(["result"=>schedule_class::get($_GET['semester_range'], $_GET['time_zone'], $_GET['date'], $_GET['day'])]);
  exit();
}

// Добавить мероприятия в ручную
if (isset($_GET['type']) && $_GET['type'] === 'add_sessions_staff_all') {
  echo json_encode(["result"=>add_sessions_staff_all($_POST['data'])]);
  exit();
}


?>
