<?php
/**
 * Рендерим вопросы в заявлении на ПВОМ
 * ::
 * ::
 */
include_once "components/ftt_blocks/FTT_Select_fields.php";
include_once "components/ftt_blocks/InputsGroup.php";

class FttRenderpoints {
  static function rendering ($points, $section, $data, $lists = []) {
    $localities = $lists['localities'];
    $countries1 = $lists['countries1'];
    $countries2 = $lists['countries2'];
    echo "<div class='container'><h2>{$section}</h2>";
    for ($i=0; $i < count($points); $i++) {
      if ($points[$i]['group'] === $section) {
        $db_field = explode('.', $points[$i]['db_field']);
        if ($points[$i]['required'] == 1) {
          $points[$i]['required'] = 'required';
        }
        $other = [];
        if ($db_field[1] === 'locality_key') {
          $other['list'] = $lists['localities'];
        } elseif ($db_field[1] === 'country_key' || $db_field[1] === 'citizenship_key') {
          $other['list'] = [$countries1, $countries2];
        }
        $is_display = '';
        if ($points[$i]['display_type'] === 'none') {
          $is_display = 'd-none';
        }
        if ($points[$i]['display_type'] === 'radio buttons' || $points[$i]['display_type'] === 'checkboxes') {
          $other['radio'] = explode(',', $points[$i]['values']);
        }
        echo "<div class='row {$is_display}'><div class='col-5'><span>{$points[$i]['title']}</span><br><span class='grey_text'>{$points[$i]['help']}</span></div>";
        echo self::field($points[$i]['display_type'],'point_', $data[$db_field[1]], $db_field, $points[$i]['required'], $other);
        echo "</div>";
        /*$string_data = '';
        foreach ($data as $key => $value) {
          if (in_array($key, $fields_for_rendering) || $fields_for_rendering === '_all_') {
            $string_data .= 'data-'.$key.'="'.$value.'" ';
          }
        }*/
      }
    }
    echo "</div>";
    return $string_data;
  }

  static function field($type, $id, $value, $db_field, $required, $other=[]) {
    $id .= $db_field[1];
    $data_attr = "id='{$id}' class='input-request i-width-280-px' value='{$value}' data-value='{$value}' data-table='{$db_field[0]}' data-field='{$db_field[1]}' {$required}";
    echo "<div class='col-5'>";
    if ($type === 'string field') { //$type === 'input'
      echo "<input type='text' {$data_attr}>";
    } elseif ($type === 'checkbox') {
      $checked = '';
      if (!empty($value)) {
        $checked = 'checked';
      }
      echo "<input type='checkbox' id='{$id}' class='form-check-input input-request' data-table='{$db_field[0]}' data-field='{$db_field[1]}' {$required} {$checked}>";
    } elseif ($type === 'radio buttons') {
      echo "<div data-value='{$value}' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-value='{$value}' {$required}>";
      InputsGroup::radio($other['radio'], $other['radio'][0], $value, $db_field[1]);
      echo "</div>";
    } elseif ($type === 'date field') {
      echo "<input type='date' {$data_attr}>";
    } elseif ($type === 'download') {

    } elseif ($type === 'text') {

    } elseif ($type === 'select list') {
      echo "<select id='{$id}' class='input-request i-width-280-px' data-field='{$db_field[1]}' data-table='{$db_field[0]}' data-value='{$value}' {$required}>";
      if ($db_field[1] === 'country_key' || $db_field[1] === 'citizenship_key') {
        FTT_Select_fields::rendering($other['list'][0], $value);
        echo "<option disavled>------------------------";
        FTT_Select_fields::rendering($other['list'][1], $value);
      } else {
        FTT_Select_fields::rendering($other['list'], $value);
      }
      echo "</select>";
    } elseif ($type === 'none') {
      echo "<span id='{$id}' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-value='{$value}'></span>";
    } elseif ($type === 'header' || $type === 'info') {

    } elseif ($type === 'checkboxes') {
      echo "<div data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-value='{$value}' {$required}>";
      InputsGroup::checkboxes($other['radio'], $other['radio'][0], $value);
      echo "</div>";
    } else {
      echo " Р А З Р А Б О Т К А . ";
    }
    echo "</div>";
  }

  static function parsing() {

  }
}

 ?>
