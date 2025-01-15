<!-- окно добавления и правки звонков -->
<div id="modal_call_edit_add" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" data-id="" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Заявка <span id="call_date">00-00-0000</span>
          <select id="call_time_zone" class="ml-3" style="" data-field="time_zone">
            <option value="">Часовой пояс
            <option value="МСК-1">МСК-1
            <option value="МСК+0">МСК+0
            <option value="МСК+1">МСК+1
            <option value="МСК+2">МСК+2
            <option value="МСК+3">МСК+3
            <option value="МСК+4">МСК+4
            <option value="МСК+5">МСК+5
            <option value="МСК+6">МСК+6
            <option value="МСК+7">МСК+7
            <option value="МСК+8">МСК+8
            <option value="МСК+9">МСК+9
          </select>
        </h5>
        <button type="button" class="close" data-dismiss="modal">x</button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-7 col-xs-12 pl-0 pr-0 pr-md-3">
              <div class="row mb-2">
                <div class="col">
                  <label>ФИО<sup>*</sup></label>
                  <input type="text" id="mdl_fld_fio" class="form-control form-control-sm" value="" data-field="name" maxlength="50">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col pr-1">
                  <label>Телефон<sup>*</sup></label>
                  <input type="tel" id="mdl_fld_phone" name="phone" class="form-control form-control-sm" value="" data-field="phone">
                </div>
                <div class="col pl-1">
                  <label>Email</label>
                  <input id="mdl_fld_email" type="email" class="form-control form-control-sm" value="" data-field="email" maxlength="50">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col pr-1">
                  <label>Страна</label>
                  <select id="mdl_fld_country" class="form-control form-control-sm" value="" data-field="country_key">
                      <?php FTT_Select_fields::rendering($callsCountryListQuick, '', ''); ?>
                      <option disabled>-----------</option>
                      <?php FTT_Select_fields::rendering($callsCountryList, '', ''); ?>
                  </select>
                </div>
                <div class="col pl-1">
                  <label>Пол</label>
                  <select id="mdl_fld_male" class="form-control form-control-sm" value="" data-field="male">
                    <option value="_none_">
                    <option value="1">муж.
                    <option value="0">жен.
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col pr-1">
                  <label>Область</label>
                  <input type="text" id="mdl_fld_region" class="form-control form-control-sm" value="" data-field="region" maxlength="50">
                </div>
                <div class="col pl-1">
                  <label>Район (при наличии)</label>
                  <input type="text" id="mdl_fld_area" class="form-control form-control-sm" value="" data-field="area" maxlength="50">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col pr-1">
                  <label>Населённый пункт</label>
                  <input type="text" id="mdl_fld_locality" class="form-control form-control-sm" value="" data-field="locality" maxlength="50">
                  <!-- list="mdl_fld_datalist_localities" -->
                  <!-- <datalist id="mdl_fld_datalist_localities">
                    <option value="">
                    <?php // foreach ($callsLocalityList as $key => $value): ?>
                        <option value="<?php // echo $value; ?>">
                    <?php // endforeach; ?>
                  </datalist> -->
                </div>
                <div class="col pl-1">
                  <label>Индекс</label>
                  <input type="text" id="mdl_fld_index" class="form-control form-control-sm" value="" data-field="index_post" maxlength="12">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label>Адрес <span id="btn_copy_to_buffer" class="px-1">Копировать</span></label>
                  <input type="text" id="mdl_fld_address" class="form-control form-control-sm" value="" data-field="address" maxlength="250">
                  <textarea id="mdl_fld_copy_text" class="p-0 m-0" style="display: none; max-width: 0px; max-height: 0px;"></textarea>
                </div>
              </div>
            </div>
            <div class="col-md-5 col-xs-12 pl-0 pr-0">
              <div class="row mb-2">
                <div class="col-6 pr-1">
                  <label>Статус</label>
                  <select id="mdl_fld_status" class="form-control form-control-sm" value="" data-field="status">
                    <option value="Входящая" style="display: none;">Входящая</option>
                    <option value="В работе">В работе</option>
                    <option value="Недозвон">Недозвон</option>
                    <option value="Ошибка">Ошибка</option>
                    <option value="Отказ">Отказ</option>
                    <option value="Повтор">Повтор</option>
                    <option value="Уточнение">Уточнение</option>
                    <option value="Заказ">Заказ</option>
                  </select>
                </div>
                <div class="col-6 pl-1">
                  <label>Оператор</label>
                  <select id="mdl_fld_operator" class="form-control form-control-sm" value="" data-field="operator">
                    <?php FTT_Select_fields::rendering($callsUsersList, '', '_none_'); ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <ul class="nav nav-tabs" id="modal_tab_call" role="call_tablist">
                    <li class="nav-item" role="presentation">
                      <a id="call_comment-tab" class="nav-link active" href="#" data-toggle="tab" data-target="#call_comment" role="tab" aria-controls="call_comment" aria-selected="true">Комментарий</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a id="call_history-tab" class="nav-link" href="#" data-toggle="tab" data-target="#call_history" role="tab" aria-controls="call_history" aria-selected="true">История</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="call_tablist">
                    <div class="tab-pane fade show active" id="call_comment" role="tabpanel" aria-labelledby="comment-tab">
                      <textarea id="mdl_fld_comment" class="form-control form-control-sm"  style="height: 280px;" data-field="comment"></textarea>
                    </div>
                    <div class="tab-pane fade" id="call_history" role="tabpanel" aria-labelledby="history-tab">
                      <div id="mdl_cal_history_content" class="pt-2">Здесь будет история...</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="text-right">
          <button id="mdl_btn_dlt_call" type="button" class="btn btn-danger btn-sm mb-2" type="button"><i class="fa fa-trash"></i></button>
          <button id="mdl_btn_order_finished" type="button" class="btn btn-light btn-sm mb-2" disabled type="button" style="display: none;">Заявка завершена</button>
          <button id="mdl_btn_new_order" type="button" class="btn btn-primary btn-sm ml-1 mb-2" type="button">Новый заказ</button>
          <button id="mdl_btn_cancel" type="button" class="btn btn-warning btn-sm ml-1 mb-2" type="button">Отменить заявку</button>
          <button id="mdl_btn_save_call" type="button" class="btn btn-success btn-sm ml-1 mb-2" type="button">Сохранить</button>
          <button type="button" class="btn btn-secondary btn-sm ml-1 mb-2" type="button" data-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Окно подтверждение удаление -->
<div id="mld_confirm_dlt" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0" class="modal-title">Подтвердите действие</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Удалить карточку звонка?</p>
      </div>
      <div class="modal-footer">
        <button id="mdl_btn_dlt_call_confirm" type="button" class="btn btn-primary">Удалить</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>

<!-- Окно подтверждение отправки в СРМ -->
<div id="mld_confirm_crm_send" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0" class="modal-title">Подтвердите действие</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Вы создаёте новый заказ в CRM. При необходимости добавьте комментарий к заказу.</p>
        <textarea id="mdl_fld_comment_extra" name="name" rows="8" class="w-100"></textarea>
      </div>
      <div class="modal-footer">
        <button id="mdl_btn_new_order_send" type="button" class="btn btn-primary">Создать</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>

<!-- Окно фильтров -->
<div id="mdl_mbl_flt" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0" class="modal-title">Фильтры</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Фильтры и кнопки -->
        <div class="row">
          <div class="col-12">
            <select id="flt_author_mbl" class="form-control form-control-sm mr-2 mb-2">
              <?php FTT_Select_fields::rendering($callsUsersList, $fltAuthor, 'Все авторы'); ?>
            </select>
          </div>
          <div class="col-12">
            <?php if ($tabCalls !== 'incomming'): ?>
              <select id="flt_operator_mbl" class="form-control form-control-sm mr-2 mb-2">
                <?php FTT_Select_fields::rendering($callsUsersList, $fltOperator, 'Все операторы'); ?>
              </select>
            <?php endif; ?>
          </div>
          <div class="col-12">
            <?php if ($callsUserData['male'] === '1'): ?>
              <select id="flt_gender_mbl" class="form-control form-control-sm mr-2 mb-2">
              <?php FTT_Select_fields::rendering(['1'=>'муж.', '0'=>'жен.'], $fltGender, 'Все'); ?>
              </select>
            <?php endif; ?>
          </div>
          <div class="col-12">
            <!--<input type="search_mbl" id="flt_search" class="form-control form-control-sm ml-2" value="<?php echo urldecode($fltSearch); ?>"><div class="input-group-append">
              <button id="btn_search_mbl" class="btn btn-success btn-sm" type="submit"><i class="fa fa-search"></i></button>
            </div>-->
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="flt_mbl_apply" class="btn btn-primary" data-dismiss="modal">Применить</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- Окно сортировки -->
<div id="mdl_mbl_sort" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0" class="modal-title">Сортировка</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <!-- заголовки колонок -->
          <div class="col">
            <b class="sort_col" data-sort="c.created_date">Дата <i class="<?php echo $sort_created_date_ico ?>"></i></b>
          </div>
          <div class="col">
            <b class="sort_col" data-sort="c.name">ФИО <i class="<?php echo $sort_fio_ico ?>"></i></b>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
