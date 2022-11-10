<?php
/** Дополнительные списки Обучения
*  Квартиры обучения
*
**/
class FttExtraLists {

  // Квартиры обучения
  static function getApartments () {
    $result = [];
    $res = db_query("SELECT `id`, `name` FROM `ftt_apartment` ORDER BY `name`");
    while ($row = $res->fetch_assoc()) $result[$row['id']] = $row['name'];
    return $result;
  }
}


?>
