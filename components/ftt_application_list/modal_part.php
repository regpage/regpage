<!-- ADD  -->
<div id="modal_dlt_add_new_application" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Добавить заявление на ПВОМ</h5>
      </div>
      <div class="modal-body">
        <div class="">
          <input id="select_member_new_application" class="form-control form-control-sm mb-3" list="select_member_new_application_list" placeholder="Выберите кандидата">
          <datalist id="select_member_new_application_list">
            <?php foreach (FttCandidates::members() as $key => $value):
              echo "<option data-id='{$key}' value='{$value}'>";
            endforeach; ?>
          </datalist>
          <input id="new_guest_application" class="align-middle" type="checkbox">
          <label class="align-middle" for="new_guest_application"> гость</label>
        </div>
      </div>
      <div class="modal-footer">
        <button id="btn_add_new_application" type="button" class="btn btn-sm btn-success float-right">Добавить</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- OPEN RECRUIT  -->
<div id="modal_open_recruit" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Открыть приём заявок на заявления?</h5>
      </div>
      <div class="modal-footer">
        <button id="btn_open_recruit" class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Открыть</button>
        <button id="btn_stop_recruit" class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true">Остановить</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- ADD APPLICATION  -->
<div id="modal_add_request_for" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Создать заявление</h5>
      </div>
      <div class="modal-footer">
        <button id="mdl_btn_approve_request" class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Основное</button>
        <button id="mdl_btn_approve_request_guest" class="btn btn-sm btn-primary" data-dismiss="modal" aria-hidden="true">В качестве гостя</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- DELETE APPLICATION  -->
<div id="modal_dlt_request_for" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Удалить запрос на заявление?</h5>
      </div>
      <div class="modal-footer">
        <button id="mdl_btn_delete_request" class="btn btn-sm btn-danger">Удалить</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>
