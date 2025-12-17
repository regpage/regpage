<!-- START confirm universal Modal -->
  <div id="modalUniversalConfirm" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="modalUniversalTitle" class="mb-0">?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        </div>
        <div class="modal-body">
          <div id="modalUniversalText" class="">
            ?
          </div>
        </div>
          <div class="modal-footer">
            <button id="modalUniversalOK" class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true">Да</button>
            <button class="btn  btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Отмена</button>
          </div>
        </div>
      </div>
    </div>
<!-- STOP confirm universal Modal -->
<!-- START edit universal Modal -->
  <div id="modalUniversalEdit" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="modalUniversalEditTitle" class="mb-0"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <b>Внимание!</b> Даты должны заполняться строго в соответсвующем формате <b>дд.мм.гггг</b>.<br>Там, тде указаны числа, допускаются только числа.
          </div>
          <div class="grey_text mb-2"><i>(<span id="param_name_header"></span>)</i></div>
          <textarea rows="8" cols="80" style="width: 100%;"></textarea>
        </div>
          <div class="modal-footer">
            <button id="modalUniversalEditOK" class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Сохранить</button>
            <button class="btn  btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Отмена</button>
          </div>
        </div>
      </div>
    </div>
<!-- STOP confirm universal Modal -->
