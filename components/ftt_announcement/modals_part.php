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
                    <input id="announcement_to_14" type="checkbox" class="mr-1">
                    Семестры 1-4
                  </label>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label class="form-check-label font-weight-normal">
                    <input id="announcement_to_56" type="checkbox" class="mr-1">
                    Семестры 5-6
                  </label>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label class="form-check-label font-weight-normal">
                    <input id="announcement_to_coordinators" type="checkbox" class="mr-1">
                    Координаторы
                  </label>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label class="form-check-label font-weight-normal">
                    <input id="announcement_to_servingones" type="checkbox" class="mr-1">
                    Служащие
                  </label>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label class="form-check-label font-weight-normal">
                    <input id="announcement_by_list" type="checkbox" class="mr-1">
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
                  <label class="form-check-label">Часовой пояс</label>
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
          <div class="row mb-2">
            <div class="col">
              <input type="text" id="announcement_staff_comment" name="" class="form-control form-control-sm" placeholder="Комментарий служащих">
            </div>
          </div>
          <div class="mb-0 pr-3 pt-1 text-right" style="width: 100%;">
              <span id="info_of_announcement" class="cursor-pointer" style="font-size: 12px; border-bottom: 1px dashed lightgrey;">Инфо</span>
              <div class="text-right pt-1" style="font-size: 12px; width: 100%; display: none;">
                <span id="author_of_announcement"></span>
                &nbsp;
                <span id="public_date_of_announcement"></span>
              </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <div class="" style="text-align: right;">
          <button id="announcement_blank_delete" class="btn btn-sm btn-secondary float-left" data-dismiss="modal" aria-hidden="true" ><i class="fa fa-trash" aria-hidden="true"></i></button>
          <button type="button" id="announcement_blank_publication" class="btn btn-success btn-sm">Опубликовать</button>
          <button type="button" id="announcement_btn_save" class="btn btn-warning btn-sm">Сохранить</button>
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
        <div class="container pl-2 pr-0">
          <div class="row pl-2 pr-2">
            <select id="modal_flt_male" class="form-control form-control-sm mb-2 mr-2">
              <option value="_all_">Все</option>
              <option value="1">Братья</option>
              <option value="0">Сёстры</option>
            </select>
            <select id="modal_flt_apartment" class="form-control form-control-sm mb-2 mr-2">
              <?php FTT_Select_fields::rendering(FttExtraLists::getApartments(), '_all_', 'Все квартиры'); ?>
            </select>
            <select id="modal_flt_semester" class="form-control form-control-sm mb-2 mr-2">
              <option value="_all_">Все семестры</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
          </div>
          <div class="row">
            <div class="col-6 pl-2">
              <div class="row">
                <div id="modal_extra_groups" class="col">
                  <h5>Обучающиеся</h5>
                  <div>
                    <label class="form-check-label" style="display: none;"><input id="modal_list_select_all" type="checkbox"> <b>Выбрать все</b></label>
                  </div>
                  <?php
                  foreach ($list_trainee_full as $key => $value) {
                    echo "<div><label class='form-check-label'><input type='checkbox' ". RenderList::dataAttr($value, array('apartment', 'male', 'semester')) ." value='{$key}'> ".short_name::no_middle($value['name'])."</label></div>";
                  } ?>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="row">
                <div class="col">
                  <h5>Служащие</h5>
                  <?php foreach ($serving_ones_list as $key => $value) {
                    echo "<label class='form-check-label'><input type='checkbox' value='{$key}'> {$value}</label><br>";
                  } ?>
                </div>
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

<!-- Просмотр объявления -->
<div id="announcement_show" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="mb-0">Объявление <span id="modal_announcement_date_text"></span></h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="container pl-0 pr-0">
          <div class="row">
            <div class="col">
              <h6 id="announcement_title" class="font-weight-bold"></h6>
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

<!-- ФИЛЬТРЫ -->
<div id="announcement_modal_flt" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Фильтры</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <select id="modal_flt_service_ones" class="form-control form-control-sm mb-2">
          <?php FTT_Select_fields::rendering($serving_ones_list, $memberId, 'Все служащие') ?>
        </select>
        <select id="modal_flr_time_zones" class="form-control form-control-sm mb-2">
          <?php FTT_Select_fields::rendering($gl_time_zones, '01'); ?>
        </select>
        <select id="modal_flt_public" class="form-control form-control-sm mb-2">
          <option value="_all_" selected>Текущие</option>
          <option value="2">Архивные</option>
        </select>
        <select id="modal_flt_recipients" class="form-control form-control-sm mb-2">
          <option value="_all_">Все</option>
          <option value="1-4">Семестры 1-4</option>
          <option value="5-6">Семестры 5-6</option>
          <option value="координаторы">Координаторы</option>
          <option value="служащие">Служащие</option>
          <option value="по списку">Получатель</option>
        </select>
        <select id="modal_flt_recipients_list" class="form-control form-control-sm mb-2" style=" display: none;">
          <option disabled>--- Служащие ---</option>
          <?php FTT_Select_fields::rendering($serving_ones_list, '_all_', 'Все служащие') ?>
          <option disabled>--- Обучающиеся ---</option>
          <?php FTT_Select_fields::rendering($trainee_list) ?>
        </select>
      </div>
      <div class="modal-footer">
        <button id="modal_flt_apply" class="btn btn-sm btn-primary" data-dismiss="modal" aria-hidden="true">Применить</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>
