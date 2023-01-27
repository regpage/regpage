<!-- Спинер -->
<?php require_once 'components/main/spinner.php'; ?>

<!-- Кастомные фильтры -->
<div id="modal_custom_filters" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Фильтры</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <div class="btn-group">
            <span class="btn btn-sm btn-success fa fa-plus create_filter" title="Создать фильтр"></span>
        </div>
        <div class="btn-group filter_name_block" >
            <input class="filter_name" type="text" placeholder="Название" style="margin-bottom: 0; margin-left: 10px;"/>
            <span class="fa fa-check add-filter" title="Сохранить фильтр" style="font-size: 20px;"></span>
        </div>
        <div class="filters_list" style="margin-top: 20px;">

        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- modal_show_custom_filters -->
<div id="modal_show_custom_filters" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3></h3>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <div class="show_filters_list">

        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success save-filter-localities" data-dismiss="modal" aria-hidden="true">Сохранить</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- modalRemoveFilterConfirmation -->
<div id="modalRemoveFilterConfirmation" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Подтверждение удаления фильтра</h3>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger remove_filter_confirm" data-dismiss="modal" aria-hidden="true">Подтвердить</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
      </div>
    </div>
  </div>
</div>

<!-- Print list Modal -->
<div id="modalPrintList" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3></h3>
      </div>
      <div class="modal-body">
        <div id="show_print_list">

        </div>
      </div>
      <div class="modal-footer">
        <button id="printListButton" class="btn btn-success" data-dismiss="modal" aria-hidden="true">Печать</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>
