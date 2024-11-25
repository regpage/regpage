<?php
/**
 * Рендерим список
 */
class render_list {

  static function list ($data)  {

    for ($i=0; $i < count($data); $i++) {
      $string = '<div class="row list_string"';
      $string_data = '';
      foreach ($data as $key => $value) {
        $string_data .= 'data-'.$key.'="'.$value.'" '
      }
      $string .= $string_data . ' data-toggle="modal" data-target="#modalAddEdit">'
    }
  }
}

 ?>
