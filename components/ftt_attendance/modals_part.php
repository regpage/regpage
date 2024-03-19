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
                <h6 class="hide_element">Утреннее оживление</h6>
                <div class="input-group mb-3">
                  <span class="align-self-center name_session">Утреннее оживление</span>
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
          <!-- Чтение Библии -->
          <div class="row">
            <div class="col-12">
              <h6 class="hide_element">Пророчествование на собрании</h6>
              <div class="input-group mb-2">
                <span class="align-self-center name_session">Пророчествование на собрании</span>
                <select type="number" id="sunday_prophecy" class="form-control short_number_field" data-field="prophecy" value="" style="margin-left: 0px !important; font-size: 14px; max-width: 95px !important;">
                  <option value=""></option>
                  <option value="1">Да</option>
                  <option value="0">Нет</option>
                </select>
                <span id="note_prophecy" class="ml-2 pl-2 align-self-center text-danger" style="line-height: 1.3;">Вы не пророчествовали<br>на прошлой неделе</span>
              </div>
            </div>
          </div>
          <!-- Чтение Библии -->
          <div class="row">
            <div class="col-12">
              <h6 class="hide_element reading_bible_title">Чтение Библии</h6>
              <div class="input-group justify-content-between mb-3">
                <span class="align-self-center name_session reading_bible_title">Чтение Библии</span>
                <!--<input type="number" id="bible_reading" class="form-control practice_field short_number_field text-right" data-field="bible_reading" value="" min="0" max="30" style="font-size: 14px; max-width: 95px !important;">
                <span class="align-self-center pl-2 mt-2">мин. (<?php if ($ftt_access['group'] === 'staff' || (isset($trainee_data['semester']) && $trainee_data['semester'] < 5)) { ?>15
                  <?php } else { ?>
                    30
                  <?php } ?>
                  мин. в день)
                  <br>-->

                <!--<span>Название книг Библии</span>
                <br>-->
                <div style="min-width: 111px;">
                  <select id="bible_book_ot" class="mr-3 form-control" data-field="book_ot" style="min-width: 95px; max-width: 95px; min-height: 35px; margin-left: 0px !important;">
                    <option value="_none_">
                    <option value="0">Нет
                      <?php
                      $bible_books = $bible_obj->get();
                      foreach ($bible_books as $key => $value) {
                        if ($key < 39) {
                          for ($i=1; $i <= $value[1]; $i++) {
                            echo "<option value='{$i}' data-book='{$value[0]}' data-chapter='{$i}'>{$value[0]} {$i}";
                          }
                        }
                      }
                      ?>
                  </select>
                </div>
                <div style="min-width: 111px;">
                  <select id="bible_book_nt" class="mr-3 form-control" data-field="book_nt" style="min-width: 95px; max-width: 95px; min-height: 35px; margin-left: 0px !important;">
                    <option value="_none_">
                    <option value="0">Нет
                    <?php
                    $bible_books = $bible_obj->get();
                    foreach ($bible_books as $key => $value) {
                      if ($key > 38) {
                        for ($i=1; $i <= $value[1]; $i++) {
                            echo "<option value='{$i}' data-book='{$value[0]}' data-chapter='{$i}'>{$value[0]} {$i}";
                        }
                      }
                    }
                    ?>
                  </select>
                </div>
                <button type="button" id="show_me_start" class="bg-secondary text-light short_select_field rounded" data-toggle="modal" data-target="#mdl_bible_start" style="min-width: 54px !important;">...</button>
              </div>
            </div>
          </div>
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
          <button id="undo_attendance_str" class="btn btn-sm btn-warning" title="Откат записи"><i class="fa fa-undo" aria-hidden="true"></i></button>
          <button id="add_attendance_str" class="btn btn-sm btn-danger" title="Добавить или удалить мероприятия" style="margin-right: 210px;"><i class="fa fa-list" aria-hidden="true"></i></button>
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
        <h5 class="modal-title">Архив посещаемости</h5>
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

<?php include 'components/ftt_reading/modals_part_start.php'; ?>
<?php include 'components/ftt_attendance/modal_permission.php'; ?>
<?php include 'components/ftt_attendance/modal_skip.php'; ?>
