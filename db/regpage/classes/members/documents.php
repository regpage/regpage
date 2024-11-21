<?php
/**
 *
 */
class Documents
{

  static function getTypes ()
  {
    $array = array ();
    $res=db_query ("SELECT `key` as `id`, `name` FROM `document` ORDER BY `name`");
    while ($row = $res->fetch_assoc()) $array[$row['id']]=$row['name'];
    return $array;
  }
}
