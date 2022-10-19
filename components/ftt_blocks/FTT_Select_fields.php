<?php
  /**
   * rendering рендерим список выбора
   */
  class FTT_Select_fields
  {
    static function rendering ($list, $seleted_option = 'missing', $extra_first_option = '')
    {
      if ($extra_first_option) {
        echo "<option value='_all_'>{$extra_first_option}</option>";
      }
      foreach ($list as $key => $value) {
        $selected = '';
        if ($key === $seleted_option) {
          $selected = 'selected';
        }
        echo "<option value='{$key}' $selected>{$value}</option>";
      }
    }
  }

?>
