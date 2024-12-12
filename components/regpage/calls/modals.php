<!-- окно добавления и правки звонков -->
<div id="modal_call_edit_add" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Заявка <span id="call_date">00-00-0000</span>
          <select id="call_time_zone" class="ml-3" style="text-decoration: underline dotted; border: none; background-color: inherit; color: #333;" data-field="time_zone">
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
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-7">
              <div class="row mb-2">
                <div class="col">
                  <label>ФИО<sup>*</sup></label>
                  <input type="text" class="form-control form-control-sm" value="" data-field="name">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label>Телефон<sup>*</sup></label>
                  <input type="text" class="form-control form-control-sm" value="" data-field="phone">
                </div>
                <div class="col">
                  <label>Email</label>
                  <input type="text" class="form-control form-control-sm" value="" data-field="email">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label>Страна</label>
                  <select class="form-control form-control-sm" value="" data-field="country_key">
                      <?php FTT_Select_fields::rendering($callsCountryListQuick, '', '_none_'); ?>
                      <option disabled>-----------</option>
                      <?php FTT_Select_fields::rendering($callsCountryList, '', ''); ?>
                  </select>
                </div>
                <div class="col">
                  <label>Пол</label>
                  <select class="form-control form-control-sm" value="" data-field="male">
                    <option value="_none_">
                    <option value="1">муж.
                    <option value="0">жен.
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                  <label>Область</label>
                  <input type="text" class="form-control form-control-sm" value="" data-field="region">
                </div>
                <div class="col">
                  <label>Район(прим)</label>
                  <input type="text" class="form-control form-control-sm" value="" data-field="area">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col">
                    <label>Насел. пункт</label>
                  <input type="text" id="mdl_fld_locality" list="mdl_fld_datalist_localities" class="form-control form-control-sm" value="" data-field="locality">
                  <datalist id="mdl_fld_datalist_localities">
                    <option value="">
                    <?php foreach ($callsLocalityList as $key => $value): ?>
                        <option value="<?php echo $value; ?>">
                    <?php endforeach; ?>
                  </datalist>
                </div>
                <div class="col">
                  <label>Индекс</label>
                  <input type="text" id="mdl_fld_index" class="form-control form-control-sm" value="" data-field="index_post">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-10">
                  <label>Адрес</label>
                  <input type="text" id="mdl_fld_address" class="form-control form-control-sm" value="" data-field="address">
                </div>
                <div class="col-2">
                  <label class="text-light pr-2"> </label>
                  <button type="button" id="btn_copy_to_buffer" class="btn btn-light btn-sm mb-0 pt-0" style="font-size: 18px;"><i class="fa fa-copy"></i></button>
                  <textarea id="mdl_fld_copy_text" class="p-0 m-0" style="display: none; max-width: 0px; max-height: 0px;"></textarea>
                </div>
              </div>
            </div>
            <div class="col-5">
              <div class="row mb-3 pb-1">
                <div class="col-6">
                  <label>Статус</label>
                  <select class="form-control form-control-sm" value="" data-field="status">
                    <option value="Входящая">Входящая
                    <option value="В работе">В работе
                    <option value="Недозвон">Недозвон
                    <option value="Ошибка">Ошибка
                    <option value="Отказ">Отказ
                    <option value="Повтор">Повтор
                    <option value="Уточнение">Уточнение
                    <option value="Заказ">Заказ
                  </select>
                </div>
                <div class="col-6">
                  <label>Оператор</label>
                  <select class="form-control form-control-sm" value="" data-field="operator">
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
                      <textarea class="form-control form-control-sm" rows="12"  data-field="comment"></textarea>
                    </div>
                    <div class="tab-pane fade" id="call_history" role="tabpanel" aria-labelledby="history-tab">
                      <div id="mdl_cal_history_content" class="pt-2">Скоро здесь будет история...</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="w-100">
          <div class="float-left">
          <button id="mdl_btn_dlt_call" type="button" class="btn btn-danger btn-sm" type="button"><i class="fa fa-trash"></i></button>
        </div>
        <div class="float-right">
          <button id="mdl_btn_new_order" type="button" class="btn btn-primary btn-sm" type="button">Новый заказ</button>
          <button id="mdl_btn_cancel" type="button" class="btn btn-warning btn-sm" type="button">Отменить</button>
          <button id="mdl_btn_save_call" type="button" class="btn btn-success btn-sm" type="button">Сохранить</button>
          <button type="button" class="btn btn-secondary btn-sm" type="button" data-dismiss="modal" aria-hidden="true">Закрыть</button>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Окно подтверждение -->
<div id="mld_confirm_dlt" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0" class="modal-title">Подтвердите действие</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
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
