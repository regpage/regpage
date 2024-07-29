<?php
/**
 *
 */
class CustomPage extends DBQuery
{
  static function getPage ($name)
  {
      return parent::get('str', 'custom_page', 'value', 'name' ,$name);

      /*$name = db_real_escape_string($name);
      $res=db_query ("SELECT value FROM custom_page WHERE name='{$name}'");

      if ($row = $res->fetch_assoc())
          return $row['value'];
      else
          return '';
          */
  }
  static function getSpecPages () {
    return parent::get('arr', 'custom_page', 'name', 'name', '__', 'LIKE');

    /*$res=db_query ("SELECT name FROM custom_page WHERE name LIKE '__'");
      $array = array();
      while ($row = $res->fetch_assoc()) $array[]=$row['name'];
      return $array;*/
  }

}
