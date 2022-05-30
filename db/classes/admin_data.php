<?php
include_once 'db/classes/short_name.php';
/**
 * It's admin's current data
 * $curent_admin_data = new Admin_data;
 * $curent_admin_name = $curent_admin_data->name;
 * ДОБАвить безопастность db()
 */
class get_admin_data {

  static public function data($admin_id) {
    $result = [];
    $res = db_query("SELECT m.key, m.name AS admin_name, m.locality_key, m.email, l.name AS locality_name
      FROM member AS m
      INNER JOIN locality l ON l.key = m.locality_key
      WHERE m.key = '$admin_id'");
      while ($row = $res->fetch_assoc()) $result[]=$row;
      return $result[0];
  }

  static public function ftt($admin_id) {
    $result = [];
    $result_2 = [];
    $service = '';
    $res = db_query("SELECT `member_key`, `time_zone` FROM ftt_serving_one WHERE `member_key` = '$admin_id'");
      while ($row = $res->fetch_assoc()) $result[]=$row;

      if (isset($result[0]['member_key'])) {
        return ['group' => 'staff', 'ftt_service' => [], 'staff_time_zone' => $result[0]['time_zone'], 'attendance' => ''];
      } else {
        $res_2 = db_query("SELECT `member_key`, `service` FROM ftt_trainee WHERE `member_key` = '$admin_id'");
          while ($row = $res_2->fetch_assoc()) $result_2[]=$row;

          if ($result_2[0]['member_key']) {
            # Ответственные в парам
            $service_param = getValueFttParamByName('extrahelp_service_id');
            // проверить пи одном служении возвращает ли МАССИВ
            $ftt_services = explode(',', $result_2[0]['service']);
            if (in_array($service_param, $ftt_services)) {
              $service_access_param = $service_param;
            }
            return ['group' => 'trainee', 'ftt_service' => $service_access_param, 'staff_time_zone' => '', 'attendance' => '1'];
          } else {
            return ['group' => '', 'ftt_service' => '', 'staff_time_zone' => '', 'attendance' => ''];
          }
      }
  }
}

 ?>
