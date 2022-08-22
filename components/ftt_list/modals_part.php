
<!-- SIDE PANEL -->
<!-- cd-panel -->
<div class="cd-panel cd-panel--from-right js-cd-panel-main" data-id="">
  <!--<header class="cd-panel__header">

  </header>-->
  <!-- cd-panel__container -->
  <div class="cd-panel__container">
    <!-- cd-panel__content -->
    <div class="cd-panel__content">
      <div class="container pl-2 pr-2">
        <div class="row">
          <div class="col-9">
            <span class="">Карточка участника</span>
          </div>
          <div class="col-3">
            <a href="" class="cd-panel__close">Закрыть</a>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <label class="required-for-label">ФИО</label>
            <input type="text" id="name" class="form-control form-control-sm" data-field="name" data-table="member">
          </div>
        </div>
        <div class="row">
          <div class="col-6">
              <label class="">Дата рождения</label>
              <input type="date" id="birth_date" class="form-control form-control-sm" maxlength="10" data-field="birth_date" data-table="member">
          </div>
          <div class="col-6">
              <label class="required-for-label">Пол</label>
              <select id="gender" class="form-control form-control-sm" data-field="gender" data-table="member">
                  <option value="1">MУЖ</option>
                  <option value="0">ЖЕН</option>
              </select>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
              <label class="required-for-label">Гражданство</label>
              <select id="citizenship" class="form-control form-control-sm" data-field="citizenship_key" data-table="member">
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
        <div class="row">
          <div class="col-6">
            <label class="required-for-label">Населенный пункт</label>
            <select id="locality" class="form-control form-control-sm" data-table="member" data-field="locality_key">
              <option value="_none_" selected>
                <?php foreach (localities::get_localities(true) as $id => $name){
                  if ($id) {
                    echo "<option value='$id'>".htmlspecialchars ($name)."</option>";
                  }
                } ?>
            </select>
          </div>
          <div class="col-6">
            <label>Категория</label>
            <select id="category" class="form-control form-control-sm" data-field="category_key" data-table="member">
                <option value="_none_" selected=""></option>
                <?php foreach ($categories_list as $id => $name) echo "<option value='$id'>".htmlspecialchars ($name)."</option>"; ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <label>Почтовый адрес</label>
            <input type="text" id="address" class="form-control form-control-sm" maxlength="150" data-field="address" data-table="member">
            <span class="example">Пример: Россия, 180000, Псковская обл., г. Псков, ул. Труда 5, кв. 6</span>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <label>Email</label>
            <input type="email" id="email" class="form-control form-control-sm" maxlength="50" data-field="email" data-table="member">
          </div>
          <div class="col-6">
              <label>Моб. телефон</label>
              <input type="text" id="phone" class="form-control form-control-sm" maxlength="50" placeholder="+XXXXXXXXXX" data-field="cell_phone" data-table="member">
          </div>
        </div>
        <div class="row">
          <div class="col-12">
              <label>Дата крещения</label>
              <input type="date" id="baptized" class="form-control form-control-sm" data-field="baptized" data-table="member">
          </div>
        </div>
        <!-- PASSPORT -->
        <div class="row">
          <div class="col-12 handle-passport-info" style="margin-bottom: 10px; margin-top: 15px;">
              <a href="#block-passport-info" data-toggle="collapse" style="text-decoration: none; color: cadetblue;"> Паспортные данные
              <i style="margin-left: 10px; color: cadetblue;" class="fa fa-lg fa-chevron-down"></i></a>
          </div>
        </div>
        <div class="row">
          <div id="block-passport-info" class="col-12 block-passport-info collapse">
            <div class="row controls passport-info">
              <div class="col-12 passport-info">
                <label>Тип документа</label>
                <select id="document_type" class="form-control form-control-sm" data-field="document_key" data-table="member">
                  <option value="_none_" selected></option>
                  <?php foreach (MemberProperties::get_documents() as $id => $name) echo "<option value='$id'>".htmlspecialchars ($name)."</option>"; ?>
                </select>
              </div>
              <div class="col-6 passport-info">
                <label>Номер документа</label>
                <input type="text" id="document_num" class="form-control form-control-sm" maxlength="20" data-field="document_num" data-table="member">
              </div>
              <div class="col-6 passport-info">
                <label>Дата выдачи</label>
                <input type="date" id="document_date" class="form-control form-control-sm" data-field="document_date" data-table="member">
              </div>
              <div class="col-12 passport-info">
                <label>Кем выдан</label>
                <input type="text" id="document_auth" class="form-control form-control-sm" maxlength="150" data-field="document_auth" data-table="member">
              </div>
          </div>
          <div class="row controls tp-passport-info">
              <div class="col-12">
                <label>Номер загранпаспорта</label>
                  <input type="text" id="document_num_tp" class="form-control form-control-sm" maxlength="20" data-field="tp_num" data-table="member">
              </div>
              <div class="col-12">
                <label>Страна, которой выдан паспорт. Укажите название страны по-английски</label>
                <input type="text" id="document_auth_tp" class="form-control form-control-sm" maxlength="20" data-field="tp_auth" data-table="member">
              </div>
              <div class="col-12">
                <label>Дата окончания действия загранпаспорта</label>
                  <input type="date" id="document_date_tp" class="form-control form-control-sm" maxlength="10" data-field="tp_date" data-table="member">
              </div>
              <div class="col-12">
                <label>Фамилия и имя латинскими буквами (как указано в загранпаспорте)</label>
                  <input type="text" id="document_name_tp" class="form-control form-control-sm" maxlength="150" data-field="tp_name" data-table="member">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <label>Семестр</label>
            <select id="semester" class="form-control form-control-sm" data-field="semester" data-table="ftt_trainee">
              <option value="_none_" selected></option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
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
    </div> <!-- cd-panel__content -->
  </div> <!-- cd-panel__container -->
</div> <!-- cd-panel -->
