<!-- РАЗРЕШЕНИЯ -->
<div id="edit_skip_blank" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true"
data-id="" data-member_key="" data-serving_one="" data-status="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Пропущенное занятие</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <?php if ($ftt_access['group'] === 'staff') { ?>
          <select id="trainee_select_skip" class="form-control form-control-sm mt-2 mb-2" disabled>
            <?php foreach ($trainee_list as $key => $value):
              echo "<option value='{$key}'>{$value}</option>";
            endforeach; ?>
          </select>
        <?php } ?>
        <div class="row">
          <div class="col-4" style="max-width: 150px;">
            <label class="required-for-label" style="min-width: 130px;">Дата пропуска</label>
            <input type="date" id="skip_modal_date" class="form-control form-control-sm mb-2" value="" disabled>
          </div>
          <div class="col-2 pr-1" style="margin-top:30px;">
            <span id="day_of_week_skip_blank"></span>
          </div>
          <div class="col-6 pr-1" style="margin-top:30px;">
            <span id="show_status_in_skip_blank" class="float-right badge badge-secondary">не отправлен</span>
          </div>
        </div>
        <div class="">
          <input type="text" id="skip_modal_session" class="form-control form-control-sm mt-2" placeholder="Мероприятие" disabled>
        </div>
        <div class="">
          <input type="text" id="skip_modal_topic" class="form-control form-control-sm mt-2" value="" placeholder="Тема">
        </div>
        <div class="">
          <input type="text" id="skip_modal_comment" class="form-control form-control-sm mt-2" value="" placeholder="Комментарий">
        </div>
        <div class="mt-2">
          <label for="skip_modal_file">Приложить файл</label><br>
          <input type="file" id="skip_modal_file" class="" accept="image/*" value="">
          <div class="float-right"><i id="pic_skip_delete" class="fa fa-trash text-danger cursor-pointer" aria-hidden="true" style="font-size: 1.5rem;"></i></div>
        </div>
        <div class="mt-2">
          <a id="skip_pic" href="#" target="_blank"></a>
        </div>
        <?php if ($ftt_access['group'] === 'staff') { ?>
        <div class="row">
          <div class="col-6 mt-2">
            <input type="checkbox" id="skip_modal_done" class="align-middle">
            <label class="align-middle" for="skip_modal_done">выполнено</label>
          </div>
          <div class="col-6 mt-2 text-right">
            <span id="info_of_skip" class="cursor-pointer" style="border-bottom: 1px dashed lightgrey; font-size: 12px;">Инфо</span>
            <div class="text-right" style="font-size: 12px; display: none;">
              <span id="author_of_skip">Отправлено </span>
              <span id="send_date_of_skip"></span>
              <br>
              <span id="sevice_one_of_skip">Проверено </span>
              <span id="allow_date_of_skip"></span>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <div class="text-right w-100">
          <button id="delete_skip_blank" class="btn btn-sm btn-secondary float-left"><i class="fa fa-trash"></i></button>
          <button id="send_skip_blank" class="btn btn-sm btn-warning">Отправить</button>
          <button id="save_skip_blank" class="btn btn-sm btn-primary">Сохранить</button>
          <button id="close_skip_blank" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ФИЛЬТРЫ -->
<div id="skip_ftr_modal" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Фильтры</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <select id="modal_flt_skip_active" class="form-control form-control-sm mb-2">
          <option value="_all_" <?php if ($flt_skip_active === '_all_') echo 'selected'; ?>>Все</option>
          <option value="0" <?php if ($flt_skip_active === '0') echo 'selected'; ?>>На рассмотрении</option>
        </select>
        <select id="modal_flt_sevice_one_skip" class="form-control form-control-sm mb-2">
          <option value="_all_">Все служащие</option>
          <?php foreach ($serving_ones_list as $key => $value):
            $selected = '';
            if ($key === $serving_one_skip) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' $selected>{$value}</option>";
          endforeach; ?>
        </select>
        <select id="modal_ftr_trainee_skip" class="form-control form-control-sm mb-2">
          <option value="_all_">Все обучающиеся</option>
          <?php foreach ($trainee_list as $key => $value):
            $selected = '';
            if ($key === $trainee_skip) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; ?>
        </select>
      </div>
      <div class="modal-footer">
        <button id="skip_ftr_modal_apply" class="btn btn-sm btn-primary" data-dismiss="modal" aria-hidden="true">Применить</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Закрыть</button>
      </div>
    </div>
  </div>
</div>
