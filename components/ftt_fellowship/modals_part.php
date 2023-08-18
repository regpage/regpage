<!-- ОБЩЕНИЕ СПИСОК-->
<div id="edit_meet_blank" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-member_key="" data-serving_one="" data-status="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Запись на общение</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">
        <select id="meet_serving_ones_list_calendar" class="form-control form-control-sm mr-2">
          <option value="_all_">Все служащие</option>
          <?php foreach ($serving_ones_list_meet as $key => $value):
            $selected = "";
            if ($serving_ones_flt === $key) {
              $selected = "selected";
            }
            echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; ?>
          <option disabled>----КБК----</option>";
          <?php foreach ($kbk_list as $key => $value):
            echo "<option value='{$key}'>{$value}</option>";
          endforeach; ?>
        </select>
        <div class="calendar-wrapper">
    		  <button id="btnPrev" type="button">Предыдущий</button>
    		  <button id="btnNext" type="button">Следующий</button>
			    <div id="divCal"></div>
		    </div>
        <!-- <h5>Служащие ПВОМ</h5>
        <div id="list_staff_pvom">

        </div>
        <h5>Служащие КБК</h5>
        <div id="list_staff_kbk">

        </div>-->
      </div>
      <div class="modal-footer">
        <div class="text-right w-100">
          <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ОБЩЕНИЕ ЗАПИСЬ -->
<div id="mdl_edit_fellowship_staff" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-date="" data-duration="" data-cancel="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Запись на общение</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row mb-2">
            <div class="col">
              <select id="mdl_meet_trainee_list" class="form-control form-control-sm">
                <option value="_none_"></option>
                <?php foreach ($trainee_list as $key => $value):
                  echo "<option value='{$key}'>{$value}</option>";
                endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <select id="mdl_meet_serving_ones_list" class="form-control form-control-sm">
                <option value="_none_"></option>
                <?php foreach ($serving_ones_list_meet as $key => $value):
                  echo "<option value='{$key}'>{$value}</option>";
                endforeach; ?>
                <option disabled>----КБК----</option>";
                <?php foreach ($kbk_list as $key => $value):
                  echo "<option value='{$key}'>{$value}</option>";
                endforeach; ?>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-6">
              <input type="date" id="mdl_meet_date" class="form-control form-control-sm">
            </div>
            <div class="col-6">
              <input type="time" id="mdl_meet_time" class="form-control form-control-sm" style="max-width: 100% !important;">
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <textarea id="mdl_meet_comment_trainee" class="form-control form-control-sm" rows="4" placeholder="Комментарий обучающегося" style="width: 100%;"></textarea>
            </div>
          </div>
          <!--<div class="row mb-2">
            <div class="col">
              <textarea id="mdl_meet_comment_serving_one" class="form-control form-control-sm" rows="4" placeholder="Комментарий служащего" style="width: 100%;"></textarea>
            </div>
          </div>-->
          <div class="row mb-2">
            <div class="col">
              <label for="meet_cancel"><input id="meet_cancel" type="checkbox" class=""> Общение отменено</label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="text-right w-100">
          <button id="mdl_btn_meet_ok" class="btn btn-sm btn-success">Записать</button>
          <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Отмена</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ОБЩЕНИЕ ЗАПИСЬ 2 -->
<div id="mdl_meet_trainee_to_record" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-member_key="" data-serving_one="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Запись на общение</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">
        <div id="list_possible_records">

        </div>
      </div>
      <div class="modal-footer">
        <div class="text-right w-100">
          <!--<button id="" class="btn btn-sm btn-success">Записаться</button>-->
          <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ОБЩЕНИЕ ПОДТВЕРЖДЕНИЕ -->
<div id="edit_meet_blank_confirm" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-trainee="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-footer">
        <div class="text-right w-100">
          <button id="send_meet_blank" class="btn btn-sm btn-success">Записаться</button>
          <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Отменить</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ОБЩЕНИЕ ОТМЕНА-->
<div id="edit_meet_blank_record" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-member_key="" data-serving_one="" data-status="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Отменить запись на общение?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>

      <div class="modal-footer">
        <div class="text-right w-100">
          <button id="undo_meet_blank" class="btn btn-sm btn-danger">Отменить</button>
          <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Фильтры -->
<div id="modal_meet_filters" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="">Фильтры</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">
        <select id="flt_done_meet_mbl" class="form-control form-control-sm mr-2 mb-2">

        </select>
        <select id="flt_sevice_one_meet_mbl" class="form-control form-control-sm mr-2 mb-2">
          <option value="_all_">Все служащие</option>
          <?php foreach ($serving_ones_list as $key => $value):
            $selected = '';
            if ($key === $serving_ones_flt) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; ?>
        </select>
        <select id="ftr_trainee_meet_mbl" class="form-control form-control-sm mr-2">
          <option value="_all_">Все обучающиеся</option>
          <?php foreach ($trainee_list as $key => $value):
            $selected = '';
            if ($key === $trainee_flt) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; ?>
        </select>
      </div>
      <div class="modal-footer" style="">
        <button id="apply_filters_meet_mbl" class="btn btn-sm btn-info" data-dismiss="modal" aria-hidden="true" style="">Применить</button>
      </div>
    </div>
  </div>
</div>
