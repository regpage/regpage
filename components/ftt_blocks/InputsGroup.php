<?php
  /**
   * rendering рендерим список выбора FTT_Select_fields::rendering($list, $seleted_option, $extra_first_option)
   */
  class InputsGroup
  {
    static function radio ($list, $seleted_option_default = 'missing', $seleted_option_value = '', $group)
    {
      foreach ($list as $key => $value) {
        $checked = '';
        /*if (empty($seleted_option_value) && $value === $seleted_option_default) {
          $default = 'checked';
        }*/
        if ($value === $seleted_option_value) {
          $checked = 'checked';
        }
        echo "<div class='form-check-inline'><label class='form-check-label'>
        <input type='radio' class='form-check-input' id='radio_point{$key}' name='{$group}' value='{$value}' {$checked}>{$value}</label></div>";
      }
    }
    static function checkboxes ($list, $seleted_option_default = 'missing', $seleted_options_value = '')
    {
      $seleted_options_value = explode(',', $seleted_options_value);
      foreach ($list as $key => $value) {
        $default = '';
        /*if (count($seleted_options_value) === 0 && $value === $seleted_option_default) {
          $default = 'checked';
        }*/

        $checked = '';
        if (in_array($value, $seleted_options_value)) {
          $checked = 'checked';
        }
        echo "<div><label class='form-check-label'><input type='checkbox' class='form-check-input' id='checkbox_point{$key}' value='{$value}' {$default} {$checked}>{$value}</label></div>";
      }
    }
  }

?>
