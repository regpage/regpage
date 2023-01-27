<?php
/** Фильтры
 * getCustomFilters получаем кастомные фильтры
 */
class CustomFilters
{
  static function addFilter($filter_name, $admin_key){
      global $db;
      $_filter_name = $db->real_escape_string($filter_name);
      $_admin_key = $db->real_escape_string($admin_key);

      db_query("INSERT INTO filter (name, admin_key) VALUES ('$_filter_name', '$_admin_key') ");
  }

  static function getFilters($admin_key){
      global $db;
      $_admin_key = $db->real_escape_string($admin_key);

      $res = db_query("SELECT * FROM filter WHERE admin_key='$_admin_key' ");

      $filters = [];
      while($row = $res->fetch_assoc()){
          $filters [] = $row;
      }

      return $filters;
  }

  static function saveFilterLocalities($filter_id, $filter_localities){
      global $db;
      $_filter_localities = $db->real_escape_string($filter_localities);
      $_filter_id = $db->real_escape_string($filter_id);

      db_query("UPDATE filter SET value = '".($_filter_localities == '' ? NULL : $_filter_localities)."' WHERE id='$_filter_id' ");
  }

  static function saveFilter($filter_id, $filter_name){
      global $db;
      $_filter_name = $db->real_escape_string($filter_name);
      $_filter_id = $db->real_escape_string($filter_id);

      db_query("UPDATE filter SET name = '".$_filter_name."' WHERE id='$_filter_id' ");
  }

  static function removeFilter($filter_id){
      global $db;
      $_filter_id = $db->real_escape_string($filter_id);

      db_query("DELETE FROM filter WHERE id='$_filter_id' ");
  }

}
