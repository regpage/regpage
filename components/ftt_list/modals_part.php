
<!-- КАРТОЧКА УЧАСТНИКА ПВОМ
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
                <?php foreach ($localities_select as $id => $name){
                  if ($id) {
                    echo "<option value='$id'>".htmlspecialchars ($name)."</option>";
                  }
                } ?>
            </select>
            <input id="emNewLocality" class="form-control form-control-sm required_field" style="display: none;" type="text" maxlength="50" list="localities_list" data-field="new_locality" data-table="member" placeholder="Введите название местности" title="Введите название. Если нужный населённый пункт появится в списке, выберите его">
            <span id="reset_locality" class="close_x cursor-pointer h4">&times;</span>
            <datalist id="localities_list">
              <option value="">
              <?php foreach ($localities_select as $id => $name){
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
-->
