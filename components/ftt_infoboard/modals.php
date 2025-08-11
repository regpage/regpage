<!-- Модальное окно раздела управления содержимым на информационном экране -->
<div class="modal-content">
  <!-- Modal Header -->
  <div class="modal-header">
    <h5 class="mb-0">Информационная доска</h5>
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
                <input id="" type="checkbox" class="mr-1">
                Семестры 1-4
              </label>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <label class="form-check-label font-weight-normal">
                <input id="" type="checkbox" class="mr-1">
                Семестры 5-6
              </label>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <label class="form-check-label font-weight-normal">
                <input id="" type="checkbox" class="mr-1">
                Координаторы
              </label>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <label class="form-check-label font-weight-normal">
                <input id="" type="checkbox" class="mr-1">
                Служащие
              </label>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <label class="form-check-label font-weight-normal">
                <input id="" type="checkbox" class="mr-1">
                По списку <span id="" class="cursor-pointer pl-2" style="display: none;"><i class="fa fa-list"></i></span>
              </label>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="row mb-2">
            <div class="col-8 pr-1" style="max-width: 150px;">
              <label class="form-check-label">Дата публикации</label>
              <input id="" type="date" class="form-control form-control-sm input_date_width">
            </div>
            <div class="col-4 pl-1" >
              <label id="" class="form-check-label">Время</label>
              <input id="" type="text" class="form-control form-control-sm" maxlength="5" style="width: 60px;">
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-8 pr-1" style="max-width: 150px;">
              <label class="form-check-label">Дата архивации</label>
              <input id="" type="date" class="form-control form-control-sm input_date_width">
            </div>
            <div class="col-4 pl-1" style="margin-top: 22px;">
              <button type="button" id="" class="btn btn-secondary btn-sm" name="button" style="width: 60px;"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="form-check-label">Часовой пояс</label>
              <select id="" class="form-control form-control-sm mr-2" style="width: 198px;">
                <?php // FTT_Select_fields::rendering($gl_time_zones, '01'); ?>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col">
          <input id="mdl_text_header" type="text" name="" class="form-control form-control-sm" placeholder="Введите заголовок..." maxlength="50">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col">
            <textarea id="mdl_text_editor" name="announcement_editor" style="width: 466px; height: 300px;">

            </textarea>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col">
          <input type="text" id="mdl_staff_comment" name="" class="form-control form-control-sm" placeholder="Комментарий служащих">
        </div>
      </div>
      <div class="mb-0 pr-3 pt-1 text-right" style="width: 100%;">
          <span id="" class="cursor-pointer" style="font-size: 12px; border-bottom: 1px dashed lightgrey;">Инфо</span>
          <div class="text-right pt-1" style="font-size: 12px; width: 100%; display: none;">
            <span id=""></span>
            &nbsp;
            <span id=""></span>
          </div>
      </div>
    </div>
  </div>
  <!-- Modal footer -->
  <div class="modal-footer">
    <div class="" style="text-align: right;">
      <button id="" class="btn btn-sm btn-secondary float-left" data-dismiss="modal" aria-hidden="true" ><i class="fa fa-trash" aria-hidden="true"></i></button>
      <button type="button" id="" class="btn btn-warning btn-sm">Сохранить</button>
      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
    </div>
  </div>
</div>
