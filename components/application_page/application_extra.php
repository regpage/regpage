<?php
//if (!empty($value)) {
  $value = explode(';', $value);
  $number_extra = array(0 => 'first-extra', 1 => 'second-extra', 2 => 'third-extra', 3 => 'fourth-extra');
  $extra_counter = 0;
  foreach ($number_extra as $key => $value_str) {
    echo "<div class='row support_block_extra {$value_str}'>
      <br>";

      isset($value[$extra_counter]) ? $support_info_part1 = $value[$extra_counter] : $support_info_part1 = '';
      isset($value[$extra_counter+1]) ? $support_info_part2 = $value[$extra_counter+1] : $support_info_part2 = '';
      isset($value[$extra_counter+2]) ? $support_info_part3 = $value[$extra_counter+2] : $support_info_part3 = '';

        echo "<div class='col-12'>
          <span class='span-label-width-210'>Фамилия Имя </span>
          <input type='text' class='input-request b-width-150-px' value='$support_info_part1' data-table='ftt_request' data-field='support_persons' data-value='$support_info_part1'>
        </div>
        <div class='col-12'>
          <span class='span-label-width-210'>Степень родства </span>
          <input type='text' class='input-request b-width-150-px' value='$support_info_part2' data-table='ftt_request' data-field='support_persons' data-value='$support_info_part2'>
        </div>
        <div class='col-12'>
          <span class='span-label-width-210'>Возраст </span>
          <input type='text' class='input-request b-width-150-px' value='$support_info_part3' data-table='ftt_request' data-field='support_persons' data-value='$support_info_part3'>
      </div>
      <div class='col-12'>
        <span class='delete_extra_string' style='cursor: pointer; font-weight: bold; color: red; font-size: 18px;' title='Удалить'> X </span>
      </div>";
      $extra_counter += 3;

    echo '</div>';
  }
//}hidden
?>
