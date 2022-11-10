<?php
/**
 * Рендерим список
 * ::list()
 * ::dataAttr() рендерим дата атрибуты
 */
class RenderList {
/*
  static function list ($data)  {

    for ($i=0; $i < count($data); $i++) {
      $string = '<div class="row list_string"';
      $string_data = '';
      foreach ($data as $key => $value) {
        $string_data .= 'data-'.$key.'="'.$value.'" '
      }
      $string .= $string_data . ' data-toggle="modal" data-target="#modalAddEdit">';
    }
  }*/

  static function dataAttr ($data, $fields_for_rendering) {
    for ($i=0; $i < count($data); $i++) {
      $string_data = '';
      foreach ($data as $key => $value) {
        if (in_array($key, $fields_for_rendering) || $fields_for_rendering === '_all_') {
          $string_data .= 'data-'.$key.'="'.$value.'" ';
        }
      }
      return $string_data;
    }
  }
}

 ?>
