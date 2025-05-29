<!--  поля окна добавления и правки пророчества -->
<?php if ($ftt_access['group'] === 'staff') { ?>
  <div class="row mb-2">
    <div class="col">
      <label>Обучающийся<sup class="text-danger">*<sup></label>
      <select id="mdl_edit_trainee_list_md" class="form-control form-control-sm f_use f_required" name="member_key">
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
    <label>Дата<sup class="text-danger">*<sup></label>
    <input id="mdl_edit_date_md" type="date" class="form-control form-control-sm f_use f_required" name="date">
  </div>
  <div class="col">
    <label>Номер недели</label>
    <input type="number" class="form-control form-control-sm f_use" name="week_number" min="0" max="99">
  </div>
</div>
<div class="row mb-2">
  <div class="col">
    <label>Название сообщения</label>
    <textarea class="form-control form-control-sm f_use" name="topic" rows="2"></textarea>
  </div>
</div>
<div class="row mb-2">
  <div class="col">
    <label>Ключевое положение</label>
    <textarea class="form-control form-control-sm f_use" name="key_point" rows="2"></textarea>
  </div>
</div>
<div class="row mb-2">
  <div class="col">
    <label>Основание в Писании</label>
    <textarea class="form-control form-control-sm f_use" name="scriptural_basis" rows="2"></textarea>
  </div>
</div>
<div class="row mb-2">
  <div class="col">
    <label>Дополнительные ссылки</label>
    <textarea class="form-control form-control-sm f_use" placeholder="Например, название книги служения и номер главы (сообщения)" name="further_ref" rows="2"></textarea>
    <span class="grey_text"></span>
  </div>
</div>
<div class="row mb-2">
  <div class="col">
    <label>Вступительное предложение</label>
    <textarea class="form-control form-control-sm f_use" name="introduction" rows="2"></textarea>
  </div>
</div>
<div class="row mb-2">
  <div class="col">
    <label>Я практиковал(а) пророчество с</label>
    <textarea class="form-control form-control-sm f_use" placeholder="Укажите имена святых, которые слушали ваше пророчество." name="listeners" rows="2"></textarea>
  </div>
</div>
<div class="row mb-3">
  <div class="col">
    <label>Текст пророчества</label>
    <textarea id="mdl_edit_prophecy_md" class="form-control form-control-sm f_use" rows="8" placeholder="Можно приложить фото рукописного листа." name="prophecy"></textarea>
  </div>
</div>
<div class="row">
  <div class="col">
    <!-- <div class="form-group"></div> -->
    <div class="">
      <label for="skip_modal_file">Приложить файл</label><br>
      <input type="file" id="modal_field_file" class="form-control-sm pl-0" accept="image/*" multiple>
    </div>
    <div id="spinner_upload" class="mt-2" style="display: none;">
      <div class="spinner-border spinner-border-sm text-info"></div><span> Загружаем... </span>
    </div>
    <div id="modal_pic_preview_container" class="row mt-2">

    </div>
    <div id="modal_container_pics" class="row mt-2">

    </div>
  </div>
</div>
<div class="row mb-2">
  <div class="col">
    <input type="checkbox" id="mdl_prophecy_done" class="form-check-input ml-0 f_use" name="done"><label for="mdl_prophecy_done" class="form-check-label ml-4"> я пророчествовал(а) на собрании</label>
  </div>
</div>
<?php if ($ftt_access['group'] === 'staff') { ?>
<div class="row mb-2">
  <div class="col">
    <input type="checkbox" id="mdl_prophecy_checked" class="form-check-input ml-0 f_use" name="checked"><label for="mdl_prophecy_checked" class="form-check-label ml-4"> проверено служащим</label>
  </div>
  <div class="col text-right">
    <span id="modal_info_blank_visibility" class="cursor-pointer" style="border-bottom: 1px dashed lightgrey; font-size: 12px;">Инфо</span>
    <div id="modal_info_blank" class="" style="display:none; font-size: 12px;"></div>
  </div>
</div>
<?php } ?>
