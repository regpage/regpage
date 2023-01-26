<div class="row mb-3">
  <!-- Список подразделов -->
  <select class="form-control form-control-sm members-lists-combo" tooltip="Выберите нужный вам список здесь" style="max-width: 468px;">
    <option value="members">Общий список</option>
    <option value="attend" selected>Список посещаемости</option>
    <option value="youth">Молодые люди</option>
    <option value="list">Ответственные за регистрацию</option>
    <?php if ($roleThisAdmin===2) { ?>
      <option value="activity">Активность ответственных</option>
    <?php } ?>
  </select>
</div>
<div class="row mb-2">
  <div class="col-3 pl-1">
    <b class="sort_col" data-sort="name">ФИО <i class="<?php echo $sort_fio_ico; ?>"></i>
    </b>
  </div>
  <div class="col-3">
    <b class="sort_col" data-sort="locality">Город <i class="<?php echo $sort_locality_ico; ?>"></i>
    </b>
  </div>
  <div class="col-1" title="Собрания Господней трапезы"><b>Т</b></div>
  <div class="col-1" title="Молитвенные собрания" style="padding-left: 13px;"><b>М</b></div>
  <div class="col-1" title="Групповые собрания" style="padding-left: 13px;"><b>Г</b></div>
  <div class="col-1" title="Другие виды собраний" style="padding-left: 12px;"><b>Д</b></div>
  <div class="col-1" title="Собрания видеообучения" style="padding-left: 10px;"><b>В</b></div>
  <div class="col-1" style="padding-left: 10px;"><b>Возраст</b></div>
</div>
<div class="row">
  <div id="attend_list" class="container pl-2">
    <?php
    //print_r($membersList);
     foreach ($membersList as $key => $value):
      // print_r($value);
       ?>
      <div class="row attend_str pl-1" data-member_key="<?php echo $value->id; ?>">
        <div class="col-3 pl-0">
          <?php echo $value->name; ?>
        </div>
        <div class="col-3">
          <?php echo $value->locality; ?>
        </div>
        <div class="col-1">
          <input type="checkbox" data-field="attend_meeting" <?php if ($value->attend_meeting) echo 'checked'; ?>>
        </div>
        <div class="col-1">
          <input type="checkbox" data-field="attend_pm" <?php if ($value->attend_pm) echo 'checked'; ?>>
        </div>
        <div class="col-1">
          <input type="checkbox" data-field="attend_gm" <?php if ($value->attend_gm) echo 'checked'; ?>>
        </div>
        <div class="col-1">
          <input type="checkbox" data-field="attend_am" <?php if ($value->attend_am) echo 'checked'; ?>>
        </div>
        <div class="col-1">
          <input type="checkbox" data-field="attend_vt" <?php if ($value->attend_vt) echo 'checked'; ?>>
        </div>
        <div class="col-1">
          <?php echo floor($value->age); ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>
