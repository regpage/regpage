<?php
/**
 * Рендерим вопросы в заявлении на ПВОМ
 * ::
 * ::
 */
include_once "components/ftt_blocks/FTT_Select_fields.php";
include_once "components/ftt_blocks/InputsGroup.php";
include_once "components/ftt_blocks/FTTParsing.php";

class FttRenderpoints {
  static function rendering ($points, $section, $data, $lists = []) {
    $localities = $lists['localities'];
    $countries1 = $lists['countries1'];
    $countries2 = $lists['countries2'];
    echo "<div class='container'><div class='row text-white bg-secondary rounded'><h2 class='pl-3 mb-1'>{$section}</h2></div>";
    for ($i=0; $i < count($points); $i++) {
      if ($points[$i]['group'] === $section) {
        $fields_values = [];
        $db_field = explode(',', $points[$i]['db_field']);
        // если полей больше чем одно
        if (count($db_field) > 1) {
          $db_field_temp = [];
          foreach ($db_field as $key => $loop_value) {
            $db_field_temp[] = explode('.', $loop_value);
            $fields_values[] = $data[$db_field_temp[$key][1]];
          }
          $db_field = $db_field_temp;
        } else {
          $db_field = explode('.', $points[$i]['db_field']);
        }

        if ($points[$i]['required'] == 1) {
          $points[$i]['required'] = 'required';
        }
        $other = [];
        if ($db_field[1] === 'locality_key') {
          $other['list'] = $lists['localities'];
        } elseif ($db_field[1] === 'country_key' || $db_field[1] === 'citizenship_key') {
          $other['list'] = [$countries1, $countries2];
        }

        if (!empty($points[$i]['values'])) {
          $other['list'] = explode(',', $points[$i]['values']);
        }

        $is_display = '';
        if ($points[$i]['display_type'] === 'none') {
          $is_display = 'd-none';
        }
        if ($points[$i]['display_type'] === 'radio buttons' || $points[$i]['display_type'] === 'checkboxes') {
          $other['radio'] = explode(',', $points[$i]['values']);
        }
        global $gl_gender_candidate;
        $point_title = FTTParsing::gender($points[$i]['title'], $gl_gender_candidate);
        $point_help = FTTParsing::gender($points[$i]['help'], $gl_gender_candidate);
        if ($points[$i]['display_type'] === 'info') {
          echo "<div class='row {$is_display}'><div class='col-12'><strong>{$point_title}</strong><br><span class='grey_text'>{$point_help}</span></div>";
        } else {
          echo "<div class='row {$is_display}'><div class='col-5'><span>{$point_title}</span><br><span class='grey_text'>{$point_help}</span></div>";
        }

        if (count($fields_values) > 0) {
          $data_value = $fields_values;
        } else {
          $data_value = $data[$db_field[1]];
        }

        echo self::field($points[$i]['display_type'],'point_', $data_value, $db_field, $points[$i]['required'], $other);
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

    if (isset($db_field[0]) && !is_array($db_field[0])) {
      $db_field[0] = trim($db_field[0]);
    }

    if (isset($db_field[1]) && !is_array($db_field[1])) {
      $db_field[1] = trim($db_field[1]);
    }

    $id .= $db_field[1];

    $data_attr = "id='{$id}' class='input-request i-width-370-px' value='{$value}' data-value='{$value}' data-table='{$db_field[0]}' data-field='{$db_field[1]}' {$required}";
    echo "<div class='col-5'>";
    if ($type === 'string field') { //$type === 'input'
      if ($db_field[1] === 'support_persons') {
        echo "<div class='row support_block'><div class='col'><button type='button' id='add_support_block_extra' class='btn btn-info'> <b>+</b> Добавить</button></div></div>";
        include_once "components/application_page/application_extra.php";
      } else {
        echo "<input type='text' {$data_attr}>";
      }
    } elseif ($type === 'checkbox') {
      $checked = '';
      if (!empty($value)) {
        $checked = 'checked';
      }
      echo "<input type='checkbox' id='{$id}' class='form-check-input input-request ml-1' data-table='{$db_field[0]}' data-field='{$db_field[1]}' {$required} {$checked}>";
    } elseif ($type === 'radio buttons') {
      echo "<div data-value='{$value}' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-value='{$value}' {$required}>";
      InputsGroup::radio($other['radio'], $other['radio'][0], $value, $db_field[1]);
      echo "</div>";
    } elseif ($type === 'date field') {
      if (!empty($value)) {
        echo "<input type='date' {$data_attr}>";
      } else {
        echo "<input type='date' id='{$id}' class='input-request i-width-370-px bg_grey' data-table='{$db_field[0]}' data-field='{$db_field[1]}' {$required}>";
      }

    } elseif ($type === 'download') {
      $multiple = '';
      if (count($db_field) > 2) {
        $multiple = 'multiple';
        $db_tbl_str = $db_field[0][0];
        $db_field_str = $db_field[0][1];
        $value_str = $value[0];
      } else {
        $db_tbl_str = $db_field[0];
        $db_field_str = $db_field[1];
        $value_str = $value;
      }
      echo "<input type='file' class='input-request' data-table='{$db_tbl_str}' data-field='{$db_field_str}' data-value='{$value_str}' {$required} {$multiple} accept='.jpg, .jpeg, .png, .pdf'>";
      // ВЫВОД ЗАГРУЖЕННЫХ ИЗОБРАЖЕНИЙ НА ЭКРАН
      if (count($db_field) > 2) {
        foreach ($db_field as $key => $loop_value) {
          echo "<span><a href='{$value[$key]}' target='_blank'><img src='{$value[$key]}' alt='' width='100'></a><i class='fa fa-trash pic-delete' aria-hidden='true'></i></span>";
        }
      } else {
        echo "<span><a href='{$value_str}' target='_blank'><img src='{$value_str}' alt='' width='100'></a><i class='fa fa-trash pic-delete' aria-hidden='true'></i></span>";
      }
    } elseif ($type === 'textarea') {
      echo "<textarea id='{$id}' class='input-request i-width-370-px' row='2' value='{$value}' data-value='{$value}' data-table='{$db_field[0]}' data-field='{$db_field[1]}' {$required}>{$value}</textarea>";
    } elseif ($type === 'select list') {
      echo "<select id='{$id}' class='i-width-280-px' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-value='{$value}' {$required}>";
      if ($db_field[1] === 'country_key' || $db_field[1] === 'citizenship_key') {
        FTT_Select_fields::rendering($other['list'][0], $value);
        echo "<option disabled>------------------------";
        FTT_Select_fields::rendering($other['list'][1], $value);
      } elseif ($db_field[1] === 'locality_key') {
        FTT_Select_fields::rendering($other['list'], $value);
      } else {
        global $gl_gender_candidate;
        FTT_Select_fields::rendering(FTTParsing::gender($other['list'], $gl_gender_candidate), $value, '', 1);
      }
      echo "</select>";
    } elseif ($type === 'none') {
      echo "<span id='{$id}' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-value='{$value}'></span>";
    } elseif ($type === 'header' || $type === 'info') {

    } elseif ($type === 'checkboxes') {
      echo "<div class='ml-3 pl-1' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-value='{$value}' {$required}>";
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
