<?php /**
 *
 */
class Settings
{

  // SETTINGS
  function getSettings(){
      $res = db_query("SELECT * FROM setting_category sc
                       LEFT JOIN setting_item si ON si.setting_category_key=sc.category_key");

      $settings = [];
      while($row = $res->fetch_assoc()){
          $settings [] = $row;
      }

      return $settings;
  }

  function getUserSettings($admin_key){
      global $db;
      $_admin_key = $db->real_escape_string($admin_key);

      $res = db_query("SELECT setting_key FROM user_setting WHERE member_key='$_admin_key' ");

      $settings = [];
      while($row = $res->fetch_assoc()){
          $settings [] = $row['setting_key'];
      }

      return $settings;
  }
}
 ?>
