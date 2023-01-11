<?php
/**
 * Разбор языка
 */
class FTTParsing
{

  // Разбор текста типа [его] [её]
  static function gender($string, $male)
  {
    $is_string = 0;
    $result = [];
    if (!is_array($string)) {
        $string = explode('[',$string);
        $temp_string = [];
        if (count($string) === 2) {
          $string_2 = explode(']',$string[1]);
          $string_3 = explode(',',$string_2[0]);
          $space = ' ';
          if (substr(htmlentities($string_2[1]), 0, 1) === '&') {
            $space = '';
          }
          if ($male == 1) {
            $result = $string[0].' '.$string_3[0].$space.$string_2[1];
          } else {
            $result = $string[0].' '.$string_3[1].$space.$string_2[1];
          }
        } elseif (count($string) > 2) {
          for ($i=0; $i < count($string); $i++) {
            if ($i=== 0) {
              $temp_string[] = $string[$i];
            } else {
              $temp = explode(']', $string[$i]);
              if (count($temp) > 1) {
                $temp_gender = explode(',', $temp[0]);
                if ($male == 1) {
                  $temp_string[] = $temp_gender[0];
                } else {
                  $temp_string[] = $temp_gender[1];
                }
                if (isset($temp[1])) {
                  $temp_string[] = $temp[1];
                }
              } else {
                $temp_string[] = $temp[0];
              }
            }
          }
          //$result = implode(' ', $temp_string);
          $result = '';
          foreach ($temp_string as $key => $value) {
            if (substr($value, 0, 1) === '.' || substr($value, 0, 1) === ',' || substr($value, 0, 1) === ':'
            || substr($value, 0, 1) === ';' || substr(htmlentities($value), 0, 1) === '&' || substr($value, 0, 1) === '"'
            || substr($value, 0, 1) === '?' || substr($value, 0, 1) === '!') {
              $result = $result . '' . $value;
            } else {
              $result = $result . ' ' . $value;
            }
          }
        } else {
          $result = $string[0];
        }
      $is_string = 1;
    }
    if ($is_string === 0) {
      for ($i=0; $i < count($string); $i++) {
        $temp = trim($string[$i]);
        if (substr($temp, 0, 1) === '[' && $male == 1) { // male
          $result[] = trim($temp,'[');
        } elseif (substr($temp, -1) === ']' && $male != 1) { // female
          $result[] = trim($temp,']');
        } elseif(substr($temp, -1) !== ']' && substr($temp, 0, 1) !== '[') { //other
          $result[] = $temp;
        }
      }
    }
    if ($is_string === 1) {
      //$result = implode(' ',$result);
    }

    return $result;
  }

  static function variables($string, $male)
  {
    $array = explode('{',$string);
    if (count($array) < 2) {
      return $string;
    }
    $res_array = [];
    for ($i=0; $i < count($array); $i++) {
      if ($i=== 0) {
        $res_array[] = $array[$i];
      } else {
        $temp = explode('}', $array[$i]);
        if (count($temp) > 1) {
          $res_array[] = $temp[0];
          $res_array[] = $temp[1];
        } else {
          $res_array[] = $temp[0];
        }
      }
    }
    global $ftt_monthly_pay;
    global $ftt_min_pay;
    global $request_data;
    global $ftt_consecration;

    foreach ($res_array as $key => $value) {
      $value = trim($value);
      if ($key === 0 && substr($value, 0, 1) === '$') {
        $res_array[$key] = '';
      }
      // finance
      if ($value === 'ftt_param.monthly_pay') {
        $res_array[$key] = $ftt_monthly_pay;
      } elseif ($value === 'ftt_param.monthly_pay x 4') {
        $res_array[$key] = $ftt_monthly_pay * 4;
      } elseif ($value === 'ftt_param.min_pay') {
        $res_array[$key] = $ftt_min_pay;
      } elseif ($value === 'ftt_param.min_pay x 4') {
        $res_array[$key] = $ftt_min_pay * 4;
      }

      // Фор с шагом 2
      if ($value === 'состою в браке' || $value === 'разведён' || $value === 'вдовец'
      || $value === 'разведена' || $value === 'вдова') {
        if ($request_data['marital_status'] === $value) {
          $res_array[$key] = '';
          $temp_sub = explode(',', $res_array[$key+1]);
          $temp_sub = explode(':', $temp_sub[0]);
          $res_array = [$temp_sub[1]];
        } elseif ($value === 'состою в браке' || $value === 'разведён' || $value === 'вдовец'
        || $value === 'разведена' || $value === 'вдова') {
          $res_array[$key] = '';
          $res_array[$key+1] = '';
        } else {
          $res_array[$key] = '';
        }
      }

      // consecration
      if ($value === 'ftt_param.consecration') {
        $res_array[$key] = self::gender($ftt_consecration, $male);
      }
    }

    return implode('', $res_array);
  }
}
 ?>
