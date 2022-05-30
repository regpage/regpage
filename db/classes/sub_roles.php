<?php
/**
 * СУБ-РОЛИ
 * Доступ в разделах, который осуществляется по под-ролям.
 * Возможно нужны роли от 0 до 5, где ноль заявитель.
 * Суб-роль задаётся при старте страницы
 **/
class Sub_roles {
  // properties
  private $student;
  private $serviceone;
  // Рекомендующий определяется для конкретных контактов, в общем может подойти только для отображение раздела
  private $recommender;
  // Для собеседующего теже правила что и для рекомендующего
  private $interviewer;
  // Разработчик он же супервизор
  private $supervisor;

  //Metods
  //get data
  function __construct($admin_id) {
    // ДОДЕЛАТЬ!
    // key
    $key = $admin_id;
    $result = [];
    db_query("SELECT m.name, m.locality_key, m.email, l.name AS locality_name
      FROM member AS m
      INNER JOIN locality l ON l.key = m.locality_key
      WHERE m.key = $admin_id");
      while ($row = $res->fetch_assoc()) $result[]=$row;

      $name = $result[0]['name'];
      // to split the name and use 0 and 1 elemrnts of array
      // $short_name = $result[0]['name'];
      $locality_key = $result[0]['locality_key'];
      $locality_name = $result[0]['locality_name'];
      $email = $result[0]['email'];

  }
  function key() {
    return $a_key;
  }
  function name() {
    return  $a_name;
  }
  function short_name() {
    return $a_short_name;
  }
  function locality_key() {
    return $a_locality_key;
  }
  function locality_key() {
    return $a_locality_key;
  }
}

 ?>
