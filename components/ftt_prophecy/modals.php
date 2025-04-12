<!--  поля окна добавления и правки пророчества -->
<?php if ($ftt_access['group'] === 'staff') { ?>
  <div class="row mb-2">
    <div class="col">
      <select id="mdl_edit_trainee_list" class="form-control form-control-sm">
        <option value="_none_"></option>
        <?php foreach ($trainee_list as $key => $value):
          echo "<option value='{$key}'>{$value}</option>";
        endforeach; ?>
      </select>
    </div>
  </div>
<?php } ?>
<div class="row mb-2">
  <div class="col">
    <input id="mdl_edit_date" type="date" class="form-control form-control-sm">
  </div>
  <div class="col">
    <input type="text" class="form-control form-control-sm">
  </div>
</div>
<div class="row">
  <div class="col">
    <label for="">Пророчество</label>
    <textarea id="mdl_edit_prophecy" class="form-control form-control-sm" rows="8"></textarea>
  </div>
</div>
