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
        <div class="row pb-2 mb-3" style="border-bottom: 1px solid #dee2e6">
          <h6 class="col-12 font-weight-bold">Отметьте мероприятия, для которых требуется разрешение на отсутствие.</h6>
        </div>
        <?php if ($ftt_access['group'] === 'staff') { ?>
          <select id="trainee_select_permission" class="form-control form-control-sm mt-2 mb-2">
            <?php foreach ($trainee_list as $key => $value):
              $selected = '';
              if (empty($selected)) {
                $selected = 'selected';
              }
              echo "<option value='{$key}' {$selected}>{$value}</option>";
            endforeach; ?>
          </select>
        <?php } ?>
        <div class="">
          <label class="required-for-label">Дата отсутствия</label>
          <input type="date" id="permission_modal_date" class="form-control form-control-sm mb-2" value="">
        </div>
        <!-- ПОДСТОВЛЯЕМ РАСПИСАНИЕ -->
        <div id="modal_permission_block" class="container mt-2 mb-2">

        </div>
        <div class="">
          <input type="text" id="permission_modal_comment" class="form-control form-control-sm mt-2" value="" placeholder="Комментарий">
        </div>
        <?php if ($ftt_access['group'] === 'staff') { ?>
        <div class="">
          <label class="">
          <span id="info_of_permission" class="cursor-pointer" style="border-bottom: 1px dashed lightgrey; font-size: 12px; margin-left: 420px;">Инфо</span>
          <div class="text-right" style="font-size: 12px; display: none;">
            <span id="author_of_permission">Одобрено </span>
            <span id="allow_of_permission"></span>
            <span id="date_of_permission"></span>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <?php if ($ftt_access['group'] === 'staff') { ?>
        <button id="send_permission_blank" class="btn btn-sm btn-success">Отправить</button>
        <?php } ?>
        <button id="save_permission_blank" class="btn btn-sm btn-primary">Сохранить</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- ФИЛЬТРЫ -->
<div id="permission_ftr_modal" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Фильтры</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <select id="modal_flt_permission_active" class="form-control form-control-sm mb-2">
          <option value="_all_" <?php if ($flt_permission_active === '_all_') echo 'selected'; ?>>Все</option>
          <option value="0" <?php if ($flt_permission_active === '0') echo 'selected'; ?>>На рассмотрении</option>
        </select>
        <select id="modal_flt_sevice_one_permissions" class="form-control form-control-sm mb-2">
          <option value="_all_">Все служащие</option>
          <?php foreach ($serving_ones_list as $key => $value):
            $selected = '';
            if ($key === $serving_one_permissions) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' $selected>{$value}</option>";
          endforeach; ?>
        </select>
        <select id="modal_ftr_trainee_permissions" class="form-control form-control-sm mb-2">
          <option value="_all_">Все обучающиеся</option>
          <?php foreach ($trainee_list as $key => $value):
            $selected = '';
            if ($key === $trainee_permissions) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; ?>
        </select>
      </div>
      <div class="modal-footer">
        <button id="permission_ftr_modal_apply" class="btn btn-sm btn-primary" data-dismiss="modal" aria-hidden="true">Применить</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>
