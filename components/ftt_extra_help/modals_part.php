<?php ?>
<!-- ЗАДАНИЯ -->
<div id="modalAddEditExtraHelp" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-trainee_id="" data-author="" data-date="" data-reason="" data-comment="" data-archive="" data-archive_date="" data-service_one_archived_id = "" data-serving_one="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <h5 id="modalUniTitle">Новое доп. задание</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-7">
            <div class="form-group">
              <label for="fio_field" class="label-google">Обучающийся *</label>
              <select id="fio_field" class="input-google">
                <?php
                if (!$serving_trainee && $ftt_access['group'] === 'trainee') {
                  $trainee_name = $trainee_list[$memberId];
                  echo "<option value='{$memberId}' selected>{$trainee_name}</option>";
                } else {
                  echo '<option value="_none_"></option>';
                  foreach ($trainee_list as $key => $value):
                    echo "<option value='{$key}'>{$value}</option>";
                  endforeach;
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-5">
            <div class="form-group">
              <label class="label-google" for="date_field">Дата *</label>
              <input id="date_field" type="date" class="input-google">
            </div>
          </div>
        </div>
        <div class="form-group">
          <textarea class="input-google" id="reason_field" rows="5" cols="20" placeholder="Укажите причину. *"></textarea>
        </div>
        <?php if ($ftt_access['group'] === 'staff' || ($ftt_access['group'] === 'trainee' && $serving_trainee)) { ?>
        <div class="form-group">
          <span class="label-google">Комментарий (доступен только служащим)</span>
          <input type="text" class="input-google" id="comment_field" placeholder="Текст комментария...">
        </div>
        <?php } ?>
        <div class="form-group" style="margin-bottom: 0px;">
          <input type="checkbox" class="align-middle" id="archive_checkbox_field" <?php echo $serving_trainee_disabled; ?>>
          <label for="archive_checkbox_field" class="align-middle" style="color: #646363;"> выполнено</label>
          <span id="info_of_extrahelp" class="cursor-pointer align-middle float-right" style="border-bottom: 1px dashed lightgrey; font-size: 12px;">Инфо</span>
        </div>
        <div class="text-right" style="font-size: 12px; display: none;">
          <span id="author_of_extrahelp"></span><span id="archivator_of_extrahelp"></span><span id="date_of_archive" ></span>
        </div>
        <div class="form-group" style="display: none;">
          <label for="author_field">Автор</label>
          <select id="author_field" class="form-control form-control-sm">
            <option value="_none_"></option>
            <option value="" disabled>СЛУЖАЩИЕ</option>
            <?php foreach ($serving_ones_list as $key => $value):
              $selected = '';
              if ($key === $memberId) {
                $selected = 'selected';
              }
              echo "<option value='{$key}' $selected>{$value}</option>";
            endforeach; ?>
            <option value="" disabled></option>
            <option value="" disabled>ОБУЧАЮЩИЕСЯ</option>
            <?php foreach ($trainee_list as $key => $value):
              $selected = '';
              if ($key === $memberId) {
                $selected = 'selected';
              }
              echo "<option value='{$key}' $selected>{$value}</option>";
            endforeach; ?>
          </select>
        </div>
        <div class="form-group" style="display: none;">
          <label for="service_one_field">Служащий (закрывший доп. задание)</label>
          <select id="service_one_field" class="form-control form-control-sm" disabled>
            <option value="_none_"></option>
            <?php foreach ($serving_ones_list as $key => $value):
              echo "<option value='{$key}'>{$value}</option>";
            endforeach;
            foreach ($trainee_list as $key => $value):
              echo "<option value='{$key}'>{$value}</option>";
            endforeach; ?>
          </select>
        </div>
        <div class="form-group" style="display: none;">
          <label for="date_closed_field">Дата закрытия</label>
          <input type="date" class="form-control form-control-sm" id="date_closed_field" disabled>
        </div>
      </div>
      <div class="modal-footer" style="">
        <?php if (!$serving_trainee && $ftt_access['group'] !== 'trainee'): ?>
          <button id="delete_extra_help" class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true" style="margin-right: 260px;"><i class="fa fa-trash" aria-hidden="true"></i></button>
        <?php endif; ?>
        <button id="save_extra_help" class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true" style="">Сохранить</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
      </div>
    </div>
  </div>
</div>


<!-- ОПОЗДАНИЯ -->
<div id="modalAddEditLate" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-trainee_id="" data-author="" data-date="" data-reason="" data-comment="" data-archive="" data-archive_date="" data-service_one_archived_id = "" data-serving_one="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <h5 id="modalUniTitle_late">Новое опоздание</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-7">
            <div class="form-group">
              <label for="fio_field" class="label-google">Обучающийся *</label>
              <select id="fio_field_late" class="input-google">
                <option value="_none_"></option>
                <?php
                if (!$serving_trainee && $ftt_access['group'] === 'trainee') {
                  $trainee_name = $trainee_list[$memberId];
                  echo "<option value='{$memberId}' selected>{$trainee_name}</option>";
                } else {
                  foreach ($trainee_list as $key => $value):
                    echo "<option value='{$key}'>{$value}</option>";
                  endforeach;
                }
                ?>
              </select>
            </div>
          </div>
          <div class="col-5">
            <div class="form-group">
              <label class="label-google" for="date_field">Дата *</label>
              <input id="date_field_late" type="date" class="input-google">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-7">
          <div class="form-group">
              <label class="label-google" for="session_name_field">Мероприятие*</label>
              <input class="input-google" id="session_name_field">
            </div>
          </div>
          <div class="col-5">
            <div class="form-group">
              <span class="label-google">Минуты*</span>
              <input type="number" class="input-google" id="minutes_field" placeholder="Минуты...">
            </div>
          </div>
        </div>
        <div class="form-group" style="margin-bottom: 0px;">
          <input type="checkbox" class="align-middle" id="done_checkbox_field" <?php echo $serving_trainee_disabled; ?>>
          <label for="done_checkbox_field" class="align-middle" style="color: #646363;"> учтено</label>
          <span id="info_of_late" class="cursor-pointer align-middle float-right" style="border-bottom: 1px dashed lightgrey; font-size: 12px;">Инфо</span>
        </div>
        <div class="text-right" style="font-size: 12px; display: none;">
          <span id="author_of_late"></span> <span id="archivator_of_late"></span><span id="date_of_archive_late" ></span>
        </div>
        <div class="form-group" style="display: none;">
          <label for="author_field">Автор</label>
          <select id="author_field_late" class="form-control form-control-sm">
            <option value="_none_"></option>
            <option value="" disabled>СЛУЖАЩИЕ</option>
            <?php foreach ($serving_ones_list as $key => $value):
              $selected = '';
              if ($key === $memberId) {
                $selected = 'selected';
              }
              echo "<option value='{$key}' $selected>{$value}</option>";
            endforeach; ?>
            <option value="" disabled></option>
            <option value="" disabled>ОБУЧАЮЩИЕСЯ</option>
            <?php foreach ($trainee_list as $key => $value):
              $selected = '';
              if ($key === $memberId) {
                $selected = 'selected';
              }
              echo "<option value='{$key}' $selected>{$value}</option>";
            endforeach; ?>
          </select>
        </div>
        <div class="form-group" style="display: none;">
          <label for="service_one_field">Служащий (закрывший доп. задание)</label>
          <select id="service_one_field_late" class="form-control form-control-sm" disabled>
            <option value="_none_"></option>
            <?php foreach ($serving_ones_list as $key => $value):
              echo "<option value='{$key}'>{$value}</option>";
            endforeach;
            foreach ($trainee_list as $key => $value):
              echo "<option value='{$key}'>{$value}</option>";
            endforeach; ?>
          </select>
        </div>
        <div class="form-group" style="display: none;">
          <label for="date_closed_field">Дата закрытия</label>
          <input type="date" class="form-control form-control-sm" id="date_closed_field_late" disabled>
        </div>
      </div>
      <div class="modal-footer" style="">
        <button id="save_late" class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true" style="">Сохранить</button>
        <?php if (!$serving_trainee && $ftt_access['group'] !== 'trainee'): ?>
          <button id="delete_late" class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true" style="">Удалить</button>
        <?php endif; ?>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- Фильтры -->
<div id="modalFilrets" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="">Фильтры</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <?php if ($serving_trainee === 1 || $ftt_access['group'] === 'staff') { ?>
        <select id="trainee_select_mbl" class="form-control form-control-sm mb-2">
          <option value="_all_" selected>Все обучающиеся</option>
          <?php foreach ($trainee_list as $key => $value):
            $selected = '';
            if (isset($_COOKIE['trainee_select']) && $_COOKIE['trainee_select'] === $key) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; ?>
        </select>
        <select id="semesters_select_mbl" class="form-control form-control-sm mb-2">
          <option value="_all_" selected>Все семестры</option>
          <?php
          $points = [1,2,3,4,5,6];
          foreach ($points as $key => $value):
            $selected = '';
            if (isset($_COOKIE['semesters_select']) && $_COOKIE['semesters_select'] == $value) {
              $selected = 'selected';
            }
            echo "<option value='{$value}' {$selected}>{$value}</option>";
          endforeach; ?>
        </select>
        <select id="sevice_one_select_mbl" class="form-control form-control-sm mb-2">
          <option value="_all_" <?php echo $serving_trainee_selected; ?>>Все служащие</option>
          <?php foreach ($serving_ones_list as $key => $value):
            $selected = '';
            if (!isset($_COOKIE['sevice_one_select']) && $key === $memberId && !$serving_trainee
            || (isset($_COOKIE['sevice_one_select']) && $_COOKIE['sevice_one_select'] === $key && !$serving_trainee)) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' $selected>{$value}</option>";
          endforeach; ?>
        </select>
        <?php } ?>
        <select id="tasks_select_mbl" class="form-control form-control-sm mb-2">
          <?php
          $selected = '';
          $selected2 = '';
          if (isset($_COOKIE['tasks_select']) && $_COOKIE['tasks_select'] === '_all_') {
            $selected = 'selected';
            $selected2 = '';
          } else {
            $selected2 = 'selected';
          }
          ?>
          <option value="_all_" <?php echo $selected; ?>>Все задания</option>
          <option value="0" <?php echo $selected2; ?>>Текущие</option>
        </select>
      </div>
      <div class="modal-footer" style="">
        <button class="btn btn-sm btn-info" data-dismiss="modal" aria-hidden="true" style="">Применить</button>
      </div>
    </div>
  </div>
</div>

<!-- Фильтры -->
<div id="modalFilrets_late" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="">Фильтры</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <?php if ($serving_trainee === 1 || $ftt_access['group'] === 'staff') { ?>
        <select id="trainee_select_late_mbl" class="form-control form-control-sm mb-2">
          <option value="_all_" selected>Все обучающиеся</option>
          <?php foreach ($trainee_list as $key => $value):
            echo "<option value='{$key}'>{$value}</option>";
          endforeach; ?>
        </select>
        <select id="semesters_select_late_mbl" class="form-control form-control-sm mb-2">
          <option value="_all_" selected>Все семестры</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
        </select>
        <select id="sevice_one_select_late_mbl" class="form-control form-control-sm mb-2">
          <option value="_all_" <?php echo $serving_trainee_selected; ?>>Все служащие</option>
          <?php foreach ($serving_ones_list as $key => $value):
            $selected = '';
            if ($key === $memberId && !$serving_trainee) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' $selected>{$value}</option>";
          endforeach; ?>
        </select>
        <?php } ?>
        <select id="tasks_select_late_mbl" class="form-control form-control-sm mb-2">
          <option value="_all_">Все опоздания</option>
          <option value="0" selected>Неучтённые</option>
        </select>
      </div>
      <div class="modal-footer" style="">
        <button class="btn btn-sm btn-info" data-dismiss="modal" aria-hidden="true" style="">Применить</button>
      </div>
    </div>
  </div>
</div>

<!-- Сортировка
<div id="modalSort" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="modalUniTitle">Порядок</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <?php
          /*$sort_date_checked = '';
          $sort_trainee_checked = '';
          if ($sort_date_ico !== 'hide_element') {
            $sort_date_checked = 'checked';
          } elseif ($sort_trainee_ico !== 'hide_element') {
            $sort_trainee_checked = 'checked';
          } else {
            $sort_date_checked = 'checked';
          }*/
           ?> -->
           <!-- sorting По дате
          <div class="form-check">
            <div class="custom-control custom-radio">
              <input type="radio" class="sort_date custom-control-input" id="sort_date" <?php // echo $sort_date_checked; ?>>
              <label class="custom-control-label" for="sort_date" style="font-size: 16px;">По дате</label>
            </div> -->
            <!-- sorting По обучающемуся
            <div class="custom-control custom-radio">
              <input type="radio" class="custom-control-input sort_trainee" id="sort_trainee" <?php // echo $sort_trainee_checked; ?> style="">
              <label class="custom-control-label" for="sort_trainee" style="font-size: 16px;">По обучающемуся</label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
      </div>
    </div>
  </div>
</div> -->
