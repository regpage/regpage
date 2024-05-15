<!-- ПОДРАЗДЕЛ АКТИВНОСТЬ-->
<?php require_once 'components/ftt_fellowship/ctrl_content_staff_activity.php'; ?>

<!-- Блок кнопок и фильтров -->
<div id="" class="btn-group mb-2" style="padding-top: 21px;">
  <!-- Фильтр по служащим -->
  <select id="flt_fellowship_activity_servingone" class="form-control form-control-sm mr-2">
    <option value="_all_">Все служащие</option>
    <?php foreach ($serving_ones_list_meet as $key => $value):
      $selected = "";
      if ($serving_ones_flt === $key) {
        $selected = "selected";
      }
      echo "<option value='{$key}' {$selected}>{$value}</option>";
    endforeach; ?>
  </select>
</div>
<!-- Блок списка записей -->
<div id="meet_list_content_staff" class="container">
  <div class="row row_meet mb-1">
    <div class="col-2 text-right"><b></b></div>
    <div class="col-10"><b></b></div>
  </div>
  <hr style="margin-left: -15px; margin-right: -15px; margin-top: 0px; margin-bottom: 0px; border-color: lightgray;">
  <?php foreach (get_fellowship_activity_list() as $key => $value): ?>
    <div class=""><b>
      <?php echo $trainee_list[$key]; ?>
    </b></div>

    <?php foreach ($value as $key_2 => $value_2): ?>
      <span class="">
          <?php echo $value_2['date'] . '; '; ?>
      </span>
    <?php endforeach; ?>
    <?php echo '<hr>'; ?>
  <?php endforeach; ?>
  <!-- Список записей а последние четыре недели -->

</div>
