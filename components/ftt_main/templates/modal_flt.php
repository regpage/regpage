<!-- ФИЛЬТРЫ -->
<?php if (!empty($modalSectionFlt)): ?>
<div id="modal_mobile_fiters" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Фильтры</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <?php require_once $modalSectionFlt; ?>
      </div>
      <div class="modal-footer">
        <button id="modal_ftr_apply" class="btn btn-sm btn-primary" data-dismiss="modal" aria-hidden="true">Применить</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
