<?php
if (isset($GLOBALS['global_root_path'])) {
  include_once $GLOBALS['global_root_path'].'db/classes/short_name.php';
} else {
  include_once __DIR__.'/../classes/short_name.php';
}
/**
 * It's admin's current data
 * $curent_admin_data = new Admin_data;
 * $curent_admin_name = $curent_admin_data->name;
 * ДОБАвить безопастность db()
 * admin_data::vt($admin_id) доступ к разделу видео обучение
 */
class get_admin_data {

  static public function data($admin_id) {
    global $db;
    $admin_id = $db->real_escape_string($admin_id);
    $result = [];
    $res = db_query("SELECT m.key, m.name AS admin_name, m.locality_key, m.email, l.name AS locality_name, m.category_key, m.male
      FROM member AS m
      INNER JOIN locality l ON l.key = m.locality_key
      WHERE m.key = '$admin_id'");
      while ($row = $res->fetch_assoc()) $result[]=$row;
      return $result[0];
  }

  static public function ftt($admin_id) {
    global $db;
    $admin_id = $db->real_escape_string($admin_id);
    $result = [];
    $result_2 = [];
    $service = '';
    $res = db_query("SELECT `member_key`, `time_zone` FROM ftt_serving_one WHERE `member_key` = '$admin_id'");
      while ($row = $res->fetch_assoc()) $result[]=$row;

      if (isset($result[0]['member_key'])) {
        return ['group' => 'staff', 'ftt_service' => [], 'staff_time_zone' => $result[0]['time_zone'], 'attendance' => '', 'coordinator'=>''];
      } else {
        $res_2 = db_query("SELECT `member_key`, `service`, `coordinator` FROM ftt_trainee WHERE `member_key` = '$admin_id'");
          while ($row = $res_2->fetch_assoc()) $result_2[]=$row;

          if ($result_2[0]['member_key']) {
            # Ответственные в парам
            $service_param = getValueFttParamByName('extrahelp_service_id');
            // проверить при одном служении возвращает ли МАССИВ
            $ftt_services = explode(',', $result_2[0]['service']);
            // неясно следующая строка можеьт быть пустой или нее
            $service_access_param = '';
            if (in_array($service_param, $ftt_services)) {
              $service_access_param = $service_param;
            }
            return ['group' => 'trainee', 'ftt_service' => $service_access_param, 'staff_time_zone' => '', 'attendance' => '1', 'coordinator'=>$result_2[0]['coordinator']];
          } else {
            return ['group' => '', 'ftt_service' => '', 'staff_time_zone' => '', 'attendance' => '', 'coordinator'=>''];
          }
      }
  }
  static public function vt($admin_id)
  {
    global $db;
    $admin_id = $db->real_escape_string($admin_id);
    $result = '';

    $res = db_query("SELECT `member_key` FROM `vt_responsibles` WHERE `member_key` = '$admin_id'");
      while ($row = $res->fetch_assoc()) $result=$row['member_key'];
      if (empty($result)) {
        return false;
      } else {
        return true;
      }
  }
}

 ?>
