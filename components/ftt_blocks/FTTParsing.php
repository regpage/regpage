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
          if ($male == 1) {
            $result = $string[0].' '.$string_3[0].' '.$string_2[1];
          } else {
            $result = $string[0].' '.$string_3[1].' '.$string_2[1];
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
                  $temp_string[] = $temp_gender[0];
                }
                if (isset($temp[1])) {
                  $temp_string[] = $temp[1];
                }
              } else {
                $temp_string[] = $temp[0];
              }
            }
          }
          $result = implode(' ', $temp_string);
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

  static function variables($string)
  {

  }
}
 ?>
