<!-- Новое объявление -->
<div class="modal fade" id="announcement_modal_edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="mb-0">Объявление</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="container pl-0 pr-0">
          <div class="row">
            <div class="col">
              <label class="form-check-label">
                <input id="" type="checkbox" class="">
                Семестрам 1-4
              </label>
            </div>
            <div class="col">
              <label class="form-check-label">
                <input id="" type="checkbox" class="">
                Координаторам
              </label>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="form-check-label">
                <input id="" type="checkbox" class="">
                Семестрам 5-6
              </label>
            </div>
            <div class="col font-weight-normal">
              <label class="form-check-label">
                <input id="announcement_by_list" type="checkbox" class="">
                По списку <span id="announcement_list_editor" class="cursor-pointer pl-2" style="display: none;"><i class="fa fa-list"></i> выбрать</span>
              </label>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <label class="form-check-label">
                <input id="" type="checkbox" class="">
                Служащим
              </label>
            </div>
            <div class="col">
              <select id="" class="form-control form-control-sm mr-2">
                <?php FTT_Select_fields::rendering(extra_lists::get_time_zones_list(), '01'); ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="form-check-label">Дата и время публикации</label>
            </div>
            <div class="col">
              <label class="form-check-label">Дата архивации</label>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-4 input_date_width">
              <input id="" type="date" class="form-control form-control-sm">
            </div>
            <div class="col-2 pl-0">
              <input id="public_time_field" type="text" class="form-control form-control-sm" maxlength="5">
            </div>
            <div class="col-4 input_date_width">
              <input id="" type="date" class="form-control form-control-sm">
            </div>
            <div class="col-1 pl-0">
              <button type="button" class="btn btn-secondary btn-sm" name="button"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <input type="text" name="" class="form-control form-control-sm" placeholder="Введите заголовок...">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
                <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
                <script type="text/javascript">
                  bkLib.onDomLoaded(function() {
                    new nicEditor({fullPanel : true}).panelInstance("announcement_text_editor");
                  });
                </script>
                <textarea id="announcement_text_editor" name="announcement_editor" style="width: 466px; height: 300px;">
                  <span class="text-secondary">Текст объявления...</span>
                </textarea>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <input type="text" name="" class="form-control form-control-sm" placeholder="Комментарий служащих">
            </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button id="announcement_blank_delete" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="margin-right: 165px;"><i class="fa fa-trash" aria-hidden="true"></i></button>
        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Отправить</button>
        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Сохранить</button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- Список получателей -->
<div id="announcement_modal_list" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="mb-0">Получатели</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="container pl-0 pr-0">
          <div class="row">
            <div class="col">
              <h5>Служащие</h5>
              <?php foreach ($serving_ones_list as $key => $value) {
                echo "<label class='form-check-label'><input type='checkbox' value='{$key}'> {$value}</label><br>";
              } ?>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <br>
              <h5>Обучающиеся</h5>
              <?php foreach ($trainee_list as $key => $value) {
                echo "<label class='form-check-label'><input type='checkbox' value='{$key}'> {$value}</label><br>";
              } ?>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
