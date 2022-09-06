<!-- РАЗРЕШЕНИЯ -->
<div id="edit_permission_blank" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true"
data-id="" data-date="" data-author="" data-date_send="" data-comment="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Лист отсутствия</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <h6>Отметьте мероприятия на которые требуется разрешение на отсутствие.</h6>
        <div class="">
          <label class="required-for-label">Дата отсутствия</label>
          <input type="date" id="permission_modal_date" class="form-control form-control-sm" value="">
        </div>
        <!-- ПОДСТОВЛЯЕМ РАСПИСАНИЕ -->
        <div id="modal_permission_block" class="container mt-2 mb-2">

        </div>
        <div class="">
          <input type="text" id="permission_modal_comment" class="form-control form-control-sm" value="" placeholder="Комментарий">
        </div>
      </div>
      <div class="modal-footer">
        <button id="send_permission_blank" class="btn btn-sm btn-success">Отправить</button>
        <button id="save_permission_blank" class="btn btn-sm btn-primary">Сохранить</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
      </div>
    </div>
  </div>
</div>
