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
          <label class="align-middle" for="new_guest_application"> гостевое</label>
          <button id="btn_add_new_application" type="button" class="btn btn-sm btn-success float-right">Добавить</button>
        </div>
        <hr>
        <div id="member_new_application_list" class="">          
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>
