<?php
  /**
   * rendering рендерим список выбора FTT_Select_fields::rendering($list, $seleted_option, $extra_first_option)
   */
  class FTT_Select_fields
  {
    static function rendering ($list, $seleted_option = 'missing', $extra_first_option = '', $same_value = false)
    {
      if ($extra_first_option) {
        echo "<option value='_all_'>{$extra_first_option}</option>";
      }
      foreach ($list as $key => $value) {
        $selected = '';
        if ($same_value) {
          if ($value === $seleted_option) {
            $selected = 'selected';
          }
        } else {
          if ($key === $seleted_option) {
            $selected = 'selected';
          }
        }

        $zone_key = strval($key);
        if ($same_value) {
          echo "<option value='{$value}' $selected>{$value}</option>";
        } else {
          echo "<option value='{$zone_key}' $selected>{$value}</option>";
        }
      }
    }
  }

?>
