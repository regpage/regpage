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
  static function rendering ($points, $section, $data, $lists = [], $notForRecommendHeader=[]) {
    global $is_recommendator;
    global $serviceone_role;
    $localities = $lists['localities'];
    $countries1 = $lists['countries1'];
    $countries2 = $lists['countries2'];
    $except = [];
    $notForRecommendHeaderClass = '';
    if (in_array($section, $notForRecommendHeader)) {
      $notForRecommendHeaderClass = 'recommend_not_visible';
    }
    echo "<div class='container'><div class='row text-white bg-secondary rounded mb-4 mt-3 {$notForRecommendHeaderClass}'><h4 class='pl-3 mb-1 mt-1'>{$section}</h4></div>";
    for ($i=0; $i < count($points); $i++) {
      if ($points[$i]['group'] === $section) {
        if ($points[$i]['not_for_recommend'] == 1 && $is_recommendator == 1 && $serviceone_role != 3) {
            continue;
        }

        if (empty($points[$i]['title'])) {
            continue;
        }

        if ($points[$i]['display_condition']) {
          $display_condition_nothing = $points[$i]['display_condition'];
          $display_condition_nothing = explode(' ', $display_condition_nothing);
          if ($display_condition_nothing[0] === 'none') {
            continue;
          }
        }

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
        $point_title = FTTParsing::variables($point_title, $gl_gender_candidate);
        $point_help = FTTParsing::gender($points[$i]['help'], $gl_gender_candidate);
        if ($points[$i]['display_type'] === 'info') {
          echo "<div class='row {$is_display}'><div class='col-12'><strong>{$point_title}</strong><br><span class='grey_text'>{$point_help}</span></div>";
        } elseif ($points[$i]['display_type'] === 'paragraph') {
          echo "<div class='row {$is_display}'><div class='col-12'><span>{$point_title}</span><br><span class='grey_text'>{$point_help}</span></div>";
        } else {
          echo "<div class='row {$is_display}'><div class='col-5'><span class='title_point'>{$point_title}</span><br><span class='grey_text'>{$point_help}</span></div>";
        }

        if (count($fields_values) > 0) {
          $data_value = $fields_values;
        } else {
          $data_value = $data[$db_field[1]];
        }
        $other['display_condition'] = $points[$i]['display_condition'];
        $other['maxlength'] = $points[$i]['value_type'];
        $other['no_button'] = $points[$i]['no_button'];
        $other['status'] = $data['stage'];
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
    $required_class = '';
    $required_class_extra = '';
    global $application_prepare;
    /*if ($required === 'required' && $other['status'] === '1' && $application_prepare !== '1'
    || $required === 'required' && empty($other['status']) && $application_prepare !== '1') {
      $required_class = 'required_field';
    }
    if ($required === 'required' && $type === 'checkbox' && $other['status'] === '1' && $application_prepare !== '1') {
      $required_class_extra = 'required_field';
    }*/
    $maxlength = $other['maxlength'];
    if (!empty($maxlength)) {
      $maxlength = trim($maxlength);
    }
    $no_button_elem = '';
    if (isset($db_field[0]) && !is_array($db_field[0])) {
      $db_field[0] = trim($db_field[0]);
    }

    if (isset($db_field[1]) && !is_array($db_field[1])) {
      $db_field[1] = trim($db_field[1]);
    }
    if (!is_array($db_field[1])) {
      $id .= $db_field[1];
    } else {
      $id .= $db_field[1][1];
    }


    $data_attr = "id='{$id}' class='input-request i-width-370-px {$required_class}' value='{$value}' data-value='{$value}' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-display_condition='{$other['display_condition']}' {$required}";
    echo "<div class='col-5'>";
    if ($type === 'string field') { //$type === 'input'
      if ($other['no_button'] == 1 && empty($value)) {
        $no_button_elem = '<span class="link_custom_gray set_no" style="margin-left: -45px; background-color: lightgrey;">нет</span>';
      } elseif ($other['no_button'] == 1 && !empty($value)) {
        $no_button_elem = '<span class="link_custom_gray set_no" style="margin-left: -45px; display:none; background-color: lightgrey;">нет</span>';
      }
      echo "<input type='text' maxlength='{$maxlength}' {$data_attr}><span class='pl-2 link_custom_gray'></span>".$no_button_elem;
    } elseif ($type === 'number') {
      echo "<input type='number' maxlength='{$maxlength}' {$data_attr}><span class='pl-2 link_custom_gray'></span>";
    } elseif ($type === 'checkbox') { // CHECKBOX
      $checked = '';
      if (!empty($value)) {
        $checked = 'checked';
      }
      echo "<input type='checkbox' id='{$id}' class='form-check-input input-request ml-1' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-display_condition='{$other['display_condition']}' {$required} {$checked}>";
      echo "<div class='i-width-370-px mt-4 {$required_class_extra}'></div>";
    } elseif ($type === 'radio buttons') { // RADIO BUTTONS
      echo "<div class='i-width-370-px {$required_class}' data-value='{$value}' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-value='{$value}' data-display_condition='{$other['display_condition']}' {$required}>";
      InputsGroup::radio($other['radio'], $other['radio'][0], $value, $db_field[1]);
      echo "</div>";
    } elseif ($type === 'date field') {
      if (!empty($value)) {
        echo "<input type='date' {$data_attr}>";
      } else {
        echo "<input type='date' id='{$id}' class='input-request i-width-370-px bg_grey $required_class' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-display_condition='{$other['display_condition']}' {$required}>";
      }
    } elseif ($type === 'download') { // DOWNLOAD
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

      $width_class = '';
      if (count($db_field) < 3 && $value_str) {
        $width_class = 'width-95-px';
      } elseif (count($db_field) > 2 && $value_str) {
        $width_class = 'b-width-100-px';
      }

      echo "<input type='file' id='{$id}' class='input-request {$required_class} {$width_class}  mr-3' data-table='{$db_tbl_str}' data-field='{$db_field_str}' data-value='{$value_str}' data-display_condition='{$other['display_condition']}' {$required} {$multiple} accept='.jpg, .jpeg, .png, .pdf'>";
      // ВЫВОД ЗАГРУЖЕННЫХ ИЗОБРАЖЕНИЙ НА ЭКРАН
      if (count($db_field) > 2) {
        for ($i=0; $i < count($value); $i++) {
          if (mb_substr(trim($value[$i]), -1) === 'f' || mb_substr(trim($value[$i]), -1) === 'F') {
            echo "<span><a href='{$value[$i]}' target='_blank'><img class='mr-3' src='img/pdf.jpeg' alt='' width='50' data-pic='$i'></a><i class='fa fa-trash pic-delete' data-pic='$i' aria-hidden='true'></i></span>";
          } else { // src='data:image/jpeg;base64,".base64_encode($value[$i])."'
            echo "<span><a href='{$value[$i]}' target='_blank'><img src='{$value[$i]}' alt='' width='100' data-pic='$i'></a><i class='fa fa-trash pic-delete mr-3' data-pic='$i' aria-hidden='true'></i></span>";
          }
        }
      } else {
        if (mb_substr(trim($value_str), -1) === 'f' || mb_substr(trim($value_str), -1) === 'F') {
          echo "<span><a href='{$value_str}' target='_blank'><img class='mr-3' src='img/pdf.jpeg' alt='' width='50'></a><i class='fa fa-trash pic-delete' aria-hidden='true'></i></span>";
        } else {
          echo "<span $check_meck><a href='{$value_str}' target='_blank'><img src='{$value_str}' alt='' width='100'></a><i class='fa fa-trash pic-delete' aria-hidden='true'></i></span>";
        }
      }
    } elseif ($type === 'textarea') { // TEXTAREA
      if ($db_field[1] === 'support_persons') {
        echo "<div class='row support_block'><div class='col'><button type='button' id='add_support_block_extra' class='btn btn-info'> <b>+</b> Добавить</button></div></div>";
        include_once "components/ftt_application_page/application_extra.php";
      } else {
        if ($other['no_button'] == 1 && empty($value)) {
          $no_button_elem = '<span class="link_custom_gray set_no" style="margin-left: -45px; vertical-align: super;  background-color: lightgrey;">нет</span>';
        } elseif ($other['no_button'] == 1 && !empty($value)) {
          $no_button_elem = '<span class="link_custom_gray set_no" style="margin-left: -45px; vertical-align: super; display:none;  background-color: lightgrey;">нет</span>';
        }
        $textarea_height = '';
        if ($maxlength > 255 && $maxlength <= 400) {
          $textarea_height = 'field_height_90px';
        } elseif ($maxlength > 400) {
          $textarea_height = 'field_height_400px';
        }
        if ($db_field[1] === 'request_info') {
          $maxlength = '';
        }
        echo "<textarea id='{$id}' class='input-request i-width-370-px {$required_class} {$textarea_height}' value='{$value}' maxlength='{$maxlength}' data-value='{$value}' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-display_condition='{$other['display_condition']}' {$required}>{$value}</textarea><span class='pl-2 link_custom_gray'></span>".$no_button_elem;
      }
    } elseif ($type === 'select list') { // SELECT
      echo "<select id='{$id}' class='i-width-280-px {$required_class}' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-value='{$value}' data-display_condition='{$other['display_condition']}' {$required}>";
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
    } elseif ($type === 'none') { // HIDE
      echo "<span id='{$id}' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-value='{$value}'></span>";
    } elseif ($type === 'header' || $type === 'info' || $type === 'paragraph') {

    } elseif ($type === 'checkboxes') { // CHECKBOX
      echo "<div class='ml-3 pl-1' data-table='{$db_field[0]}' data-field='{$db_field[1]}' data-value='{$value}' {$required}>";
      InputsGroup::checkboxes($other['radio'], $other['radio'][0], $value);
      echo "</div>";
    } else {
      echo " Р А З Р А Б О Т К А . ";
    }
    echo "</div>";
  }
}

 ?>
