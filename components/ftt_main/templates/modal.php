<?php
// Шаблон большого окна добавления и правки
if (file_exists($modalSection)): ?>
<div id="modal_edit_add_md" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" data-id="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0"><?php echo $modalTitle; ?></h5>
        <button type="button" class="close" data-dismiss="modal">x</button>
      </div>
      <div class="modal-body">
        <div class="container-fluid px-0 px-md-3">
          <?php require_once $modalSection; ?>
        </div>
      </div>
      <div class="modal-footer px-md-4">
        <div class="text-right w-100">
          <button id="mdl_edit_btn_dlt_md" type="button" class="btn btn-secondary btn-sm mb-2 float-left" type="button"><i class="fa fa-trash"></i></button>
          <?php echo $modalButtons; ?>
          <button id="mdl_edit_btn_save_md" type="button" class="btn btn-success btn-sm ml-1 mb-2" type="button">Сохранить</button>
          <button type="button" class="btn btn-secondary btn-sm ml-1 mb-2" type="button" data-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
