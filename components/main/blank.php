<?php
require_once 'db/regpage/classes/members/documents.php';
require_once 'db/regpage/classes/members/colleges.php';
require_once 'db/classes/localities.php';
require_once 'db/classes/member_properties.php';
$localitiesForBlank = localities::get_localities();
if (!isset($categories_list)) {
  $categories_list = MemberProperties::get_categories();
}
?>
<!-- КАРТОЧКА УЧАСТНИКА ПВОМ -->
<div id="modalAddEdit" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true"
data-member_key="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Карточка участника</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row mb-2">
          <div class="col-12">
            <label class="required-for-label">ФИО</label>
            <input type="text" id="name" class="form-control form-control-sm required_field" data-field="name" data-table="member" >
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-6">
              <label class="">Дата рождения</label>
              <input type="date" id="birth_date" class="form-control form-control-sm" maxlength="10" data-field="birth_date" data-table="member">
          </div>
          <div class="col-6">
              <label class="required-for-label">Пол</label>
              <select id="gender" class="form-control form-control-sm required_field" data-field="male" data-table="member">
                  <option value="1">MУЖ</option>
                  <option value="0">ЖЕН</option>
              </select>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-6">
              <label class="required-for-label">Гражданство</label>
              <select id="citizenship" class="form-control form-control-sm required_field" data-field="citizenship_key" data-table="member">
                  <option value='_none_' selected></option>
                  <?php foreach (localities::get_countries(true) as $id => $name) echo "<option value='$id'>".htmlspecialchars ($name)."</option>"; ?>
                  <option disabled="disabled">---------------------------</option>
                  <?php foreach (localities::get_countries(false) as $id => $name) {
                    if ($id) {
                      echo "<option value='$id'>".htmlspecialchars ($name)."</option>";
                    }
                  } ?>
              </select>
          </div>
          <div class="col-6">
              <label>Русскоязычный</label>
              <select id="russianLanguage" class="form-control form-control-sm" data-field="russian_lg" data-table="member">
                  <option value="0">НЕТ</option>
                  <option value="1" selected="">ДА</option>
              </select>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-6">
            <label class="required-for-label">Населенный пункт</label>
            <select id="locality" class="form-control form-control-sm required_field" data-table="member" data-field="locality_key">
              <option value="_none_" selected>
                <option value="_new_">Добавить новую местность
                <option disabled>---------------------------
                <?php foreach ($localitiesForBlank as $id => $name){
                  if ($id) {
                    echo "<option value='$id'>".htmlspecialchars ($name)."</option>";
                  }
                } ?>
            </select>
            <input id="emNewLocality" class="form-control form-control-sm required_field" style="display: none;" type="text" maxlength="50" list="localities_list" data-field="new_locality" data-table="member" placeholder="Введите название местности" title="Введите название. Если нужный населённый пункт появится в списке, выберите его">
            <span id="reset_locality" class="close_x cursor-pointer h4">&times;</span>
            <datalist id="localities_list">
              <option value="">
              <?php foreach ($localitiesForBlank as $id => $name){
                if ($id) {
                  echo "<option value='$name' data-id='$id'>";
                }
              } ?>
  				  </datalist>
          </div>
          <div class="col-6">
            <label>Категория</label>
            <select id="category" class="form-control form-control-sm" data-field="category_key" data-table="member">
                <option value="_none_" selected=""></option>
                <?php foreach ($categories_list as $id => $name) echo "<option value='$id'>".htmlspecialchars ($name)."</option>"; ?>
            </select>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <label>Почтовый адрес</label>
            <input type="text" id="address" class="form-control form-control-sm" maxlength="150" data-field="address" data-table="member">
            <span class="example">Пример: Россия, 180000, Псковская обл., г. Псков, ул. Труда 5, кв. 6</span>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-6">
            <label>Email</label>
            <input type="email" id="email" class="form-control form-control-sm" maxlength="50" data-field="email" data-table="member">
          </div>
          <div class="col-6 mb-2">
              <label>Моб. телефон</label>
              <input type="text" id="phone" class="form-control form-control-sm" maxlength="50" placeholder="+XXXXXXXXXX" data-field="cell_phone" data-table="member">
          </div>
        </div>
        <?php if (true): // поля для разделов участники, посещаемость? ?>
        <div class="row">
          <div class="col-12">
              <label class="">Дата крещения</label>
              <input id="emBaptized" class="form-control form-control-sm" type="date" valid="date">
          </div>
        </div>
        <div id="handle-passport-info" class="row mt-2 mb-2">
          <div class="col-12">
              <a data-toggle="collapse" href="#block-passport-info" role="button" aria-expanded="false" aria-controls="block-passport-info" style="color: cadetblue; text-decoration: none;"><strong>Паспортные данные</strong>
                <i style="margin-left: 10px;" class="fa fa-chevron-down fa-lg"></i>
              </a>

          </div>
        </div>
        <div id="block-passport-info" class="collapse">
          <div class="row">
            <div class="col-12 passport-info">
                <label class="">Тип документа<?php // if $noEvent // e('<sup>*</sup>'); ?></label>
                <select id="emDocumentType" class="form-control form-control-sm" <?php // if $noEvent // e('valid="required"');?>>
                    <option value='_none_' selected>&nbsp;</option>
                    <?php foreach (Documents::getTypes() as $id => $name) echo "<option value='$id'>".htmlspecialchars ($name)."</option>"; ?>
                </select>
            </div>
            <div class="col-6 passport-info">
                <label class="">Номер документа<?php // if $noEvent // e('<sup>*</sup>'); ?></label>
                <input id="emDocumentNum" class="form-control form-control-sm" type="text" maxlength="20" <?php // if $noEvent // e('valid="required"');?>>
            </div>
            <div class="col-6 passport-info">
                <label class="">Дата выдачи<?php // if $noEvent // e('<sup>*</sup>'); ?></label>
                <input id="emDocumentDate" class="form-control form-control-sm" type="date" valid="<?php // if $noEvent // e('required, ');?>date">
            </div>
            <div class="col-12 passport-info">
                <label class="">Кем выдан<?php // if $noEvent // e('<sup>*</sup>'); ?></label>
                <input id="emDocumentAuth" class="form-control form-control-sm" type="text" maxlength="150" <?php // if $noEvent // e('valid="required"');?>>
            </div>
          </div>

          <div class="row tp-passport-info mt-2">
              <div class="col-12">
                  <label class="">Номер загранпаспорта<?php // if $noEvent // e('<sup>*</sup>'); ?></label>
                      <input id="emDocumentNumTp" class="form-control form-control-sm" type="text" maxlength="20" <?php // if $noEvent // e('valid="required"');?>>
              </div>
              <div class="col-12">
                  <label class="">Страна, которой выдан паспорт (латинскими буквами)<?php // if $noEvent // e('<sup>*</sup>'); ?></label>
                      <input id="emDocumentAuthTp" class="form-control form-control-sm" type="text" maxlength="20" valid="<?php // if $noEvent // e('required, ');?>">
              </div>
              <div class="col-12">
                  <label class="">Дата окончания действия загранпаспорта<?php // if $noEvent // e('<sup>*</sup>'); ?></label>
                      <input id="emDocumentDateTp" class="form-control form-control-sm" type="date" valid="<?php // if $noEvent // e('required, ');?>date">
              </div>
              <div class="col-12">
                  <label class="">Фамилия и имя латинскими буквами (как указано в загранпаспорте)<?php // if $noEvent // e('<sup>*</sup>'); ?></label>
                      <input id="emDocumentNameTp" class="form-control form-control-sm" type="text" maxlength="150" <?php // if $noEvent // e('valid="required"');?>>
              </div>
          </div>
        </div>
        <?php endif; ?>

        <!-- не гость, не индекс пэйдж, не мероприятие -->
        <div class="row school-fields">
            <!--<div class="control-group row-fluid">
                <label class="span12">Школа <span class="emClassLevel"></span></label>
                <input class="span12" type="text" value="Средняя школа" disabled>
            </div>-->
            <div class="col-6">
                <label class="">Год начала учёбы в школе</label>
                <input id="emSchoolStart" class="form-control form-control-sm" type="text" placeholder="ГГГГ" maxlength="4" >
            </div>
            <div class="col-6">
                <label class="">Год окончания школы</label>
                <input id="emSchoolEnd" class="form-control form-control-sm" type="text" placeholder="ГГГГ" maxlength="4" >
            </div>
            <div class="col-12">
                <label class="">Примечание о школе</label>
                <input id="emSchoolComment" class="form-control form-control-sm" type="text" maxlength="100" >
            </div>
        </div>
        <div class="row college-fields">
            <div class="col-12">
                <label class="">Учебное заведение <span class="emCourseLevel"></span></label>
                <input id="emCollege" class="form-control form-control-sm" type="text" list="college_datalist">
                <!-- <i class="fa fa-times fa-lg clear-college"></i>-->
                <datalist id="college_datalist">
                    <option value='_none_'></option>
                    <?php foreach (Colleges::getList() as $id => $name) echo "<option data-id='{$id}' value='".htmlspecialchars($name)."'>"; ?>
                </datalist>
            </div>

            <div class="col-6">
                <label class="">Год поступления</label>
                <input id="emCollegeStart" class="form-control form-control-sm" type="text" placeholder="ГГГГ" maxlength="4" >
            </div>

            <div class="col-6">
                <label class="">Год окончания</label>
                <input id="emCollegeEnd" class="form-control form-control-sm" type="text" placeholder="ГГГГ" maxlength="4" >
            </div>

            <div class="col-12">
                <label class="">Примечание об учебном заведении</label>
                <input id="emCollegeComment" class="form-control form-control-sm" type="text" maxlength="100" >
            </div>
        </div>

        <div class="row">
          <div class="col-12">
            <label>Комментарий администратора</label>
            <br>
            <span class="example">(виден только администраторам)</span>
            <input type="text" id="comment" class="form-control form-control-sm" data-field="comment" data-table="member">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="save_blank" class="btn btn-sm btn-success">Сохранить</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
      </div>
    </div>
  </div>
</div>
