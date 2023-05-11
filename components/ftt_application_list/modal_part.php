<!-- ADD  -->
<div id="modal_dlt_add_new_application" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id=""></h5>
      </div>
      <div class="modal-body">
        <div class="">
          <select id="member_new_application" class="form-control form-control-sm mb-3">
            <?php foreach (FttCandidates::members() as $key => $value):
              echo "<option value='{$key}'>{$value}</option>";
            endforeach; ?>
          </select>
          <input id="new_guest_application" class="align-middle" type="checkbox">
          <label class="align-middle" for="new_guest_application"> гостевое</label>
          <button id="btn_add_new_application" type="button" class="btn btn-sm btn-success float-right">Добавить</button>
        </div>
        <hr>
        <div id="member_new_application_list" class="">
          <?php
          foreach (FttCandidates::list() as $key => $value):
            echo "<div class='row mb-3' data-id='{$key}'><div class='col-11'>{$value}</div><div class='col-1'><i class='fa fa-trash cursor-pointer' style='font-size:18px;' aria-hidden='true'></i></div></div>";
          endforeach;
          ?>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>
