
<!-- ПОСЕЩАЕМОСТЬ -->
<div id="modalAddEdit" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true"
data-id="" data-date="" data-author="" data-date_send="" data-comment="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="modalUniTitle">Лист посещаемости <span id="date_attendance_modal"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <?php if ($ftt_access['group'] === 'staff') { // Подставляем имя обучающегося для служащего ?>
          <div class="row pb-2 mb-3" style="border-bottom: 1px solid #dee2e6">
            <div class="col-7">
              <h6><b id="name_of_trainee"></b></h6>
            </div>
            <div class="col-5 text-right" id="status_of_blank">
            </div>
          </div>
        <?php } ?>
        <!-- ПОДСТОВЛЯЕМ РАСПИСАНИЕ -->
        <div id="modal-block_1">

        </div>
        <div id="modal-block_2">
            <!--<div class="row">
              <div class="col-12">
                <label>Чтение Библии (20 мин. в день) <input id="bible_field" type="checkbox" value="" class="align-middle practice_field" data-field="bible"></label>
              </div>
            </div>-->
        <?php if($ftt_access['group'] === 'staff' || (isset($trainee_data['semester']) && $trainee_data['semester'] > 4)) { ?>
            <div class="row">
              <div class="col-12">
                <h6 class="hide_element">Личное утреннее оживление</h6>
                <div class="input-group mb-3">
                  <span class="align-self-center name_session">Личное утреннее оживление</span>
                  <input type="number" id="morning_revival" class="form-control practice_field short_number_field text-right" data-field="morning_revival" value="" min="0" max="30" style="font-size: 14px; max-width: 95px !important;">
                  <span class="pl-2 align-self-center">мин. (30 мин. в день)</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <h6 class="hide_element">Личная молитва</h6>
                <div class="input-group mb-3">
                  <span class="align-self-center name_session">Личная молитва</span>
                  <input type="number" id="personal_prayer" class="form-control practice_field short_number_field text-right" data-field="personal_prayer" value="" min="0" max="30" style="font-size: 14px; max-width: 95px !important;">
                  <span class="align-self-center pl-2">мин. (30 мин. в день)</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <h6 class="hide_element">Молитва с товарищем</h6>
                <div class="input-group mb-3">
                  <span  class="align-self-center name_session">Молитва с товарищем</span>
                  <input type="number" id="common_prayer" class="form-control practice_field short_number_field text-right" data-field="common_prayer" value="" min="0" max="60" style="font-size: 14px; max-width: 95px !important;">
                  <span class="align-self-center pl-2">мин. (60 мин. в неделю)</span>
                </div>
              </div>
            </div>
          <?php } ?>
            <div class="row">
              <div class="col-12">
                <h6 class="hide_element">Чтение Библии</h6>
                <div class="input-group mb-3">
                  <span class="align-self-center name_session">Чтение Библии</span>
                  <input type="number" id="bible_reading" class="form-control practice_field short_number_field text-right" data-field="bible_reading" value="" min="0" max="30" style="font-size: 14px; max-width: 95px !important;">
                  <span class="align-self-center pl-2">мин. (<?php if ($ftt_access['group'] === 'staff' || (isset($trainee_data['semester']) && $trainee_data['semester'] < 5)) { ?>15
                    <?php } else { ?>
                      30
                    <?php } ?>
                    мин. в день)</span>
                </div>
              </div>
            </div>
            <?php if($ftt_access['group'] === 'staff' || (isset($trainee_data['semester']) && $trainee_data['semester'] > 4)) { ?>
            <div class="row">
              <div class="col-12">
                <h6 class="hide_element">Чтение служения</h6>
                <div class="input-group mb-3">
                  <span class="align-self-center name_session">Чтение служения</span>
                  <input type="number" id="ministry_reading" class="form-control practice_field short_number_field text-right" data-field="ministry_reading" value="" min="0" max="30" style="font-size: 14px; max-width: 95px !important;">
                  <span class="align-self-center pl-2">мин. (30 мин. в день)</span>
                </div>
              </div>
            </div>
          <?php } ?>
          <div class="row">
            <div class="col-12">
              <div class="input-group">
                <input type="text" id="comment_modal" class="form-control practice_field" data-field="comment" placeholder="Комментарий">
              </div>
            </div>
          </div>
        </div>
        <?php if ($ftt_access['group'] !== 'trainee'): ?>
        <div id="modal-block_staff" class="container" style="display:none;">
          <div class="row">
            <div id="modal-block_staff_body" class="col">

            </div>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <!--<span id="show_error_span_mdl" style="color: red; font-weight: bold; display: none; padding-left:20px;">Заполните выделенные поля или укажите причину.</span>-->
        <?php if (!$serving_trainee && $ftt_access['group'] !== 'trainee'): ?>
          <button id="undo_attendance_str" class="btn btn-sm btn-warning"><i class="fa fa-undo" aria-hidden="true" title="Откат записи"></i></button>
          <button id="add_attendance_str" class="btn btn-sm btn-danger" style="margin-right: 215px;"><i class="fa fa-list" aria-hidden="true"></i></button>
        <?php endif; ?>
        <button id="send_blank" class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true" style="">Отправить</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- Архивный список листков посещаемости -->
<div class="modal fade" id="archive_list">
  <div class="modal-dialog">
    <div class="modal-content" style="width: 600px;">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Архив посещаемости</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div id="archive_content" class="container">

        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
