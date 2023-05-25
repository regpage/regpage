<!-- РАЗРЕШЕНИЯ -->
<div id="edit_meet_blank" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-member_key="" data-serving_one="" data-status="">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Запись на общение</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <div class="text-right w-100">
          <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- РАЗРЕШЕНИЯ -->
<div id="edit_meet_blank_confirm" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-member_key="" data-serving_one="" data-status="">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Записаться на общение?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">

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

<!-- РАЗРЕШЕНИЯ -->
<div id="edit_meet_blank_record" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-member_key="" data-serving_one="" data-status="">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Запись на общение</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <div class="text-right w-100">
          <button id="undo_meet_blank" class="btn btn-sm btn-warning">Отменить</button>
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
            if ($key === $flt_sevice_one_skip) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; ?>
        </select>
        <select id="ftr_trainee_meet_mbl" class="form-control form-control-sm mr-2">
          <option value="_all_">Все обучающиеся</option>
          <?php foreach ($trainee_list as $key => $value):
            $selected = '';
            if ($key === $ftr_trainee_skip) {
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
