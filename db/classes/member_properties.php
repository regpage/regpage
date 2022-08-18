<?php
/**
 * свойства участников
 * Категории
 */
class MemberProperties
{
  static function get_categories ()
  {
      $res=db_query ("SELECT `key` as id, name FROM category");
      $array = array ();
      while ($row = $res->fetch_assoc()) $array[$row['id']]=$row['name'];
      return $array;
  }
}
 ?>
