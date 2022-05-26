<?php
/* Вставка для полновременно обучающихся. */
?>
<!--ftt-block-1-->
<div class="controls ftt_block">
  <div class="control-group row-fluid" style="width: 48%;">
      <label class="span12">Семестр</label>
      <select id="semestrPvom" class="span12" name="">
        <option value="_none_" selected>&nbsp;</option>
        <option value="1">Первый</option>
        <option value="2">Второй</option>
        <option value="3">Третий</option>
        <option value="4">Четвёртый</option>
        <option value="5">Пятый</option>
        <option value="6">Шестой</option>
        <option value="0">Гость</option>
      </select>
  </div>
  <div class="control-group row-fluid" style="width: 48%; float: right">
      <label class="span12">Группа изучения</label>
      <select class="span12">
        <option value='_none_' selected>&nbsp;</option>
      <?php
        foreach (getFttStudyGroup() as $key => $value) {
           echo "<option value='{$key}'>{$value}</option>";
        }
      ?>
      </select>
  </div>
</div>
<!--ftt-block-2-->
<div class="controls ftt_block">
    <div class="control-group row-fluid" style="width: 48%;">
        <label class="span12">Квартира</label>
        <select class="span12">
          <option value='_none_' selected>&nbsp;</option>
        <?php
          foreach (getFttApartments() as $key => $value) {
             echo "<option value='{$key}'>{$value}</option>";
          }
        ?>
        </select>
    </div>
    <div class="control-group row-fluid" style="width: 48%; float: right;">
        <label class="span12">Координатор квартиры</label>
        <select class="span12" valid="required">
            <option value='_none_' selected>&nbsp;</option>
            <option value="0">Нет</option>
            <option value="1">Да</option>
        </select>
    </div>
</div>
<!--ftt-block-3-->
<div class="controls ftt_block">
    <div class="control-group row-fluid" style="min-height: 61px; width: 48%;">
      <label class="span12">Команда благовестия</label>
      <select class="span12">
        <option value='_none_' selected>&nbsp;</option>
      <?php
        foreach (getFttGospelTeam() as $key => $value) {
           echo "<option value='{$key}'>{$value}</option>";
        }
      ?>
      </select>
    </div>
    <div class="control-group row-fluid" style="width: 48%; float: right;">
        <label class="span12">Номер группы благовестия</label>
        <input class="span12" type="text" maxlength="10">
    </div>
</div>
<!--ftt-block-4-->
<div class="controls ftt_block">
  <div class="control-group row-fluid" style="">
      <label class="span12">Служащий</label>
      <select id="service_ones_pvom" class="span12" name="">
        <option value='' selected>&nbsp;</option>
        <?php foreach (db_getServiceonesPvom() as $id => $name) echo "<option value='$id'>".htmlspecialchars ($name)."</option>"; ?>
      </select>
  </div>
</div>
