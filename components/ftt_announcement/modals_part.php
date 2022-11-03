<!-- Новое объявление -->
<div class="modal fade" id="announcement_modal_edit" data-id="" data-publication="" data-recipients="" data-author="">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="mb-0">Объявление</h5>
        <span class="badge badge-success mt-1 ml-3"></span>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="container pl-0 pr-0">
          <div class="row mb-2">
            <div class="col-6">
              <div class="row">
                <div class="col mb-2">
                  <label class="form-check-label">
                    Получатели
                  </label>
                </div>
              </div>
              <div class="row">
                <div class="col mb-2">
                  <label class="form-check-label font-weight-normal">
                    <input id="announcement_to_14" type="checkbox" class="">
                    Семестры 1-4
                  </label>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label class="form-check-label font-weight-normal">
                    <input id="announcement_to_56" type="checkbox" class="">
                    Семестры 5-6
                  </label>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label class="form-check-label font-weight-normal">
                    <input id="announcement_to_coordinators" type="checkbox" class="">
                    Координаторы
                  </label>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label class="form-check-label font-weight-normal">
                    <input id="announcement_to_servingones" type="checkbox" class="">
                    Служащие
                  </label>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label class="form-check-label font-weight-normal">
                    <input id="announcement_by_list" type="checkbox" class="">
                    По списку <span id="announcement_list_editor" class="cursor-pointer pl-2" style="display: none;"><i class="fa fa-list"></i></span>
                  </label>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="row mb-2">
                <div class="col-8 pr-1" style="max-width: 150px;">
                  <label class="form-check-label">Дата публикации</label>
                  <input id="announcement_date_publication" type="date" class="form-control form-control-sm input_date_width">
                </div>
                <div class="col-4 pl-1" >
                  <label id="label_time_field" class="form-check-label">Время</label>
                  <input id="announcement_time_publication" type="text" class="form-control form-control-sm" maxlength="5" style="width: 60px;">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-8 pr-1" style="max-width: 150px;">
                  <label class="form-check-label">Дата архивации</label>
                  <input id="announcement_date_archivation" type="date" class="form-control form-control-sm input_date_width">
                </div>
                <div class="col-4 pl-1" style="margin-top: 22px;">
                  <button type="button" id="announcement_to_archive" class="btn btn-secondary btn-sm" name="button" style="width: 60px;"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label class="form-check-label">Часовые пояса</label>
                  <select id="announcement_modal_time_zone" class="form-control form-control-sm mr-2" style="width: 198px;">
                    <?php FTT_Select_fields::rendering($gl_time_zones, '01'); ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <input id="announcement_text_header" type="text" name="" class="form-control form-control-sm" placeholder="Введите заголовок..." maxlength="50">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
                <textarea id="announcement_text_editor" name="announcement_editor" style="width: 466px; height: 300px;">

                </textarea>
            </div>
          </div>
          <div class="row mb-0">
            <div class="col">
              <input type="text" id="announcement_staff_comment" name="" class="form-control form-control-sm" placeholder="Комментарий служащих">
            </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <div class="" style="text-align: right;">
          <button id="announcement_blank_delete" class="btn btn-sm btn-secondary float-left" data-dismiss="modal" aria-hidden="true" ><i class="fa fa-trash" aria-hidden="true"></i></button>
          <button type="button" id="announcement_blank_publication" class="btn btn-warning btn-sm">Опубликовать</button>
          <button type="button" id="announcement_btn_save" class="btn btn-primary btn-sm">Сохранить</button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
        </div>
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

<!-- Просмотр объявления -->
<div id="announcement_show" class="modal fade">
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
              <h6 id="announcement_title"></h6>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div id="announcement_content">
              </div>
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
