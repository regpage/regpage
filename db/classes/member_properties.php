<?php
/**
 * свойства участников
 * Категории
 * Типы документов
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

  function get_documents ()
  {
      $res=db_query ("SELECT `key` as id, name FROM document ORDER BY name");
      $array = array ();
      while ($row = $res->fetch_assoc()) $array[$row['id']]=$row['name'];
      return $array;
  }
}
 ?>
