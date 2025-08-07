<!-- ОБЩЕНИЕ СПИСОК-->
<div id="edit_meet_blank" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-member_key="" data-serving_one="" data-status="">
  <div class="modal-dialog" style="max-width: 400px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Запись на общение</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">
        <select id="meet_serving_ones_list_calendar" class="form-control form-control-sm mr-2">
          <option value="_all_">Все служащие</option>
          <?php
          global $serving_ones_flt;
          foreach ($serving_ones_list_meet as $key => $value):
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
<div id="mdl_edit_fellowship_staff" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-date="" data-trainee="" data-comment="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Запись на общение</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">
        <div class="container">
          <?php if ($ftt_access['group'] === 'staff'): ?>
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
          <?php endif; ?>
          <div class="row mb-2">
            <div class="col">
              <select id="mdl_meet_serving_ones_list" class="form-control form-control-sm">
                <option value="_none_"></option>
                <?php
                if ($fellowship_bbd_tab_active !== 'active') {
                 foreach ($serving_ones_list_meet as $key => $value):
                   echo "<option value='{$key}'>{$value}</option>";
                  endforeach;
                } else {
                  foreach ($kbk_list as $key => $value):
                    echo "<option value='{$key}'>{$value}</option>";
                  endforeach;
                }
                ?>
              </select>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-6">
              <input type="date" id="mdl_meet_date" class="form-control form-control-sm">
            </div>
            <div class="col-4">
              <input type="time" id="mdl_meet_time" class="form-control form-control-sm" style="max-width: 100% !important;">
            </div>
            <div class="col-2">
              <input type="text" id="mdl_meet_duration" class="form-control form-control-sm" style="max-width: 100% !important;">
            </div>
          </div>
          <div class="row mb-2">
            <div class="col">
              <textarea id="mdl_meet_comment_trainee" class="form-control form-control-sm" rows="4" placeholder="Комментарий" style="width: 100%;"></textarea>
            </div>
          </div>
          <!--<div class="row mb-2">
            <div class="col">
              <textarea id="mdl_meet_comment_serving_one" class="form-control form-control-sm" rows="4" placeholder="Комментарий служащего" style="width: 100%;"></textarea>
            </div>
          </div>-->
        </div>
      </div>
      <div class="modal-footer">
        <div class="text-right w-100 pl-1 pr-1">
          <button id="dlt_fellowship_record" class="btn btn-sm btn-danger float-left ml-2" title="Удалить запись">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>
          </button>
          <button id="meet_cancel" title="Отменить общение" class="btn btn-sm btn-secondary float-left ml-2" style="width: 34px"><b>X</b></button>
          <button id="mdl_btn_meet_ok" class="btn btn-sm btn-success">Сохранить</button>
          <button class="btn btn-sm btn-secondary mr-2" data-dismiss="modal" aria-hidden="true">Отмена</button>
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

<!-- Фильтры -->
<div id="modal_meet_filters" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="">Фильтры</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">
        <select id="flt_sevice_one_meet_mbl" class="form-control form-control-sm mr-2 mb-2">
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
        <select id="ftr_trainee_meet_mbl" class="form-control form-control-sm mr-2 mb-2">
          <option value="_all_">Все обучающиеся</option>
          <?php
          global $trainee_flt;
          foreach ($trainee_list as $key => $value):
            $selected = "";
            if ($trainee_flt === $key) {
              $selected = "selected";
            }
            echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; ?>
        </select>
        <select id="fellowship_active_mbl" class="form-control form-control-sm mr-2">
          <?php global $active_flt; ?>
          <option value="1" <?php if ($active_flt === '1') echo 'selected'; ?>>Активные</option>
          <option value="0" <?php if ($active_flt === '0') echo 'selected'; ?>>Архивные</option>
        </select>
      </div>
      <div class="modal-footer" style="">
        <button id="apply_filters_meet_mbl" class="btn btn-sm btn-info" data-dismiss="modal" aria-hidden="true" style="">Применить</button>
      </div>
    </div>
  </div>
</div>

<!-- ПОДТВЕРЖДЕНИЕ ЗАПИСИ ВРЕМЕНИ -->
<div id="edit_meet_blank_record_confirm" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-member_key="" data-serving_one="" data-status="" data-comment="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Подтвердите запись</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">
        <strong id="time_record_for_success"></strong>
        <input type="text" class="meet_comment_trainee_time form-control form-control-sm d-inline-block mt-2" placeholder="Ваш комментарий здесь">
      </div>
      <div class="modal-footer">
        <div class="text-right w-100">
          <button id="confirm_meet_record" data-dismiss="modal" aria-hidden="true" class="btn btn-sm btn-success">Записаться</button>
          <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>
