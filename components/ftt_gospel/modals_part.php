<?php
$number_day_today = date("N");
if ($number_day_today > 0) {
  $date_curent = date("Y-m-d", strtotime("-{$number_day_today} day"));
  $all_days = $number_day_today + 6;
  $date_from = date("Y-m-d", strtotime("-{$all_days} day"));
} else {
  $date_curent = date("Y-m-d");
  $date_from = date("Y-m-d", strtotime("-6 day"));
}


?>
<!-- ЗАДАНИЯ -->
<div id="modalAddEdit" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true"
data-id="" data-date="" data-author="" data-gospel_team="" data-gospel_group="" data-place="" data-group_members="" data-number=""
data-flyers="" data-people="" data-prayers="" data-baptism="" data-meets_last="" data-meets_current="" data-meetings_last=""
data-meetings_current="" data-first_contacts="" data-further_contacts="" data-homes="" data-place_name="" data-fgt_place="" data-comment="" style="overflow: auto;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="modalUniTitle">Статистика благовестия (новая)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-7">
            <div class="form-group">
              <!--<label for="fio_field" class="label-google">Команда *</label>-->
              <select id="fio_field" class="input-google">
                <option value="_none_">Команда</option>
                <?php
                  foreach (getGospelTeam() as $key => $value):
                    echo "<option value='{$key}'>{$value}</option>";
                  endforeach;
                ?>
              </select>
            </div>
          </div>
          <div class="col-5">
            <div class="form-group">
              <!--<label class="label-google" for="date_field">Дата *</label>-->
              <input id="date_field" type="date" class="input-google">
            </div>
          </div>
        </div>
        <div class="row mb-2" style="margin-left: -16px; margin-right: -16px;">
          <div class="col-12 bg-secondary">
              <h5 class="text-white mb-1 mt-1" style="display: inline-block;" class="d-inline-block">Группа <span id="gospelGroupNumber"></span></h5>
                <button id="gospel_group_dropdown" class="btn btn-secondary btn-sm dropdown-toggle float-right" type="button" data-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
                <div id="gospel_group_dropdown_list" class="dropdown-menu dropdown-menu-right" style="min-width: auto;">
                  <span class="dropdown-item cursor-pointer" data-group="1">1</span>
                  <span class="dropdown-item cursor-pointer" data-group="2">2</span>
                  <span class="dropdown-item cursor-pointer" data-group="3">3</span>
                  <span class="dropdown-item cursor-pointer" data-group="4">4</span>
                  <span class="dropdown-item cursor-pointer" data-group="5">5</span>
                  <span class="dropdown-item cursor-pointer" data-group="6">6</span>
                  <span class="dropdown-item cursor-pointer" data-group="7">7</span>
                </div>
                <div id="group_members_block" class="d-none">
                </div>
              <select id="gospel_group_field" class="d-none" style="">
                <option value="0"></option>
              <?php
                $old_value = '';
                foreach (getGospelGroupNumber() as $key => $value):
                  echo "<option value='{$value}'>{$value}</option>";
                endforeach;
              ?>
              </select>
          </div>
        </div>
        <!-- GROUP BLOCK -->
        <div class="row mb-3 mt-3 group_block">
          <div class="col-10">
            <label class="label-google" for="flyers_field">Сколько листовок вы раздали?</label>
          </div>
          <div class="col-2">
            <input id="flyers_field" type="number" class="input-google short_number_field text-right" min="0" max="1000000">
          </div>
        </div>
        <div class="row mb-3 group_block">
          <div class="col-10">
            <label class="label-google" for="people_field">Скольким людям вы благовествовали?</label>
          </div>
          <div class="col-2">
            <input id="people_field" type="number" class="input-google short_number_field text-right" min="0" max="1000000">
          </div>
        </div>
        <div class="row mb-3 group_block">
          <div class="col-10">
            <label class="label-google" for="prayers_field">Сколько человек помолилось с вами?</label>
          </div>
          <div class="col-2">
            <input id="prayers_field" type="number" class="input-google short_number_field text-right" min="0" max="1000000">
          </div>
        </div>
        <div class="row mb-3 group_block">
          <div class="col-10">
            <label class="label-google" for="baptism_field">Сколько человек было крещено?</label>
          </div>
          <div class="col-2">
            <input id="baptism_field" type="number" class="input-google short_number_field text-right" min="0" max="1000000">
          </div>
        </div>
        <div class="row mb-3 group_block">
          <div class="col-10">
            <label class="label-google" for="meets_last_field">Со сколькими новичками <u>прошлых</u> семестров вы встречались?</label>
          </div>
          <div class="col-2 align-bottom" style="height: 48px;">
            <input id="meets_last_field" type="number" class="input-google short_number_field mt-3 text-right" min="0" max="1000000">
          </div>
        </div>
        <div class="row mb-3 group_block">
          <div class="col-10">
            <label class="label-google" for="meets_current_field">Со сколькими новичками <u>текущего</u> семестра вы встречались?</label>
          </div>
          <div class="col-2">
            <input id="meets_current_field" type="number" class="input-google short_number_field mt-3 text-right" min="0" max="1000000">
          </div>
        </div>
        <div class="row mb-3 group_block">
          <div class="col-10">
            <label class="label-google" for="meetings_last_field">Сколько новичков <u>прошлых</u> семестров было на собрании?</label>
          </div>
          <div class="col-2">
            <input id="meetings_last_field" type="number" class="input-google short_number_field mt-3 text-right" min="0" max="1000000">
          </div>
        </div>
        <div class="row mb-3 group_block">
          <div class="col-10">
            <label class="label-google" for="meets_current_field">Сколько новичков <u>текущего</u> семестра было на собрании?</label>
          </div>
          <div class="col-2">
            <input id="meetings_current_field" type="number" class="input-google short_number_field mt-3 text-right" min="0" max="1000000">
          </div>
        </div>
        <div class="row mb-3 group_block">
          <div class="col-10">
            <label class="label-google" for="homes_field">Сколько домов святых вы посетили?</label>
          </div>
          <div class="col-2">
            <input id="homes_field" type="number" class="input-google short_number_field text-right" min="0" max="1000000">
          </div>
        </div>
        <!-- PERSONAL BLOCKS -->
        <button type="button" id="show_gospel_modal_list" class="btn btn-success btn-sm mb-2 mt-1" name="button" data-toggle="modal" data-target="#gospel_modal_list">Добавить участника</button>
        <div id="comment_block" class="form-group">
          <label class="label-google">Комментарий</label>
          <textarea class="input-google" id="comment_field" rows="3" cols="20"></textarea>
        </div>
        <div class="form-group" style="margin-bottom: 0px;">
          <span id="add_comment" class="cursor-pointer float-left">Добавить комментарий</span>
          <span id="info_of" class="cursor-pointer float-right" style="border-bottom: 1px dashed lightgrey; font-size: 12px;">Инфо</span>
        </div>
        <br>
        <div class="text-right" style="font-size: 12px; display: none;">
          <span id="author_of"></span><span id="date_of_archive" ></span>
        </div>
      </div>
      <div class="modal-footer" style="">
        <?php if (!$serving_trainee && $ftt_access['group'] !== 'trainee'): ?>
          <button id="delete_extra_help" class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true" style="margin-right: 260px;"><i class="fa fa-trash" aria-hidden="true"></i></button>
        <?php endif; ?>
        <button id="save_extra_help" class="btn btn-sm btn-success">Сохранить</button>
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
        <?php if ($ftt_access['group'] === 'staff' || $serving_trainee) { ?>
        <select id="team_select_mbl" class="form-control form-control-sm mb-2">
          <option value="_all_">Все команды</option>
          <?php foreach (getGospelTeam() as $key => $value):
            if (isset($serving_ones_list_full[$memberId])) {
              $selected = '';
              if ((!isset($_COOKIE['filter_team']) && $serving_ones_list_full[$memberId][2] === $key)
              || (isset($_COOKIE['filter_team']) && $_COOKIE['filter_team'] === $key)) {
                $selected = 'selected';
              }
            }
            echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; ?>
          </select>
        <?php } ?>


        <?php if ($ftt_access['group'] === 'staff' || $serving_trainee) { ?>
        <select id="author_select_mbl" class="form-control form-control-sm mb-2">
          <option value="_all_" selected>Все обучающиеся</option>
          <?php foreach ($trainee_list as $key => $value):
            $selected = '';
            if ($key === $memberId) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' {$selected}>{$value}</option>";
          endforeach; ?>
        </select>
        <?php } ?>

        <select id="periods_mbl" class="form-control form-control-sm mb-2">
          <?php
          $selected_month = '';
          $selected_all = '';
          $selected_period = '';
          if (isset($_COOKIE['filter_period'])) {
            if ($_COOKIE['filter_period'] === 'month') {
              $selected_month = 'selected';
            } elseif ($_COOKIE['filter_period'] === "_all_") {
              $selected_all = 'selected';
            } else {
              $selected_period = 'selected';
            }
          } else {
            $selected_month = 'selected';
          } ?>
          <option value="month" <?php echo $selected_month; ?>>За месяц</option>
          <option value="_all_" <?php echo $selected_all; ?>>Весь семестр</option>
          <option value="range" <?php echo $selected_period; ?>>Период</option>
        </select>
        <span class="filter_range" style="padding: 5px; display: none;">С </span>
        <input type="date" class="period_from form-control form-control-sm filter_range" style="display: none;" value="<?php echo $_COOKIE['period_from']; ?>">
        <span class="filter_range" style="padding: 5px; display: none;">ПО </span>
        <input type="date" class="period_to form-control form-control-sm filter_range" style="display: none;" value="<?php echo $_COOKIE['period_to']; ?>">
      </div>
      <div class="modal-footer" style="">
        <button id="apply_period" class="btn btn-sm btn-info" data-dismiss="modal" aria-hidden="true" style="">Применить</button>
      </div>
    </div>
  </div>
</div>

<!-- Сортировка
<div id="modalSort" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="">Порядок</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-4 cursor-pointer" style="text-align: center;"><b class="sort_date">По дате <i class="<?php // echo $sort_date_ico; ?>"></i></b></div>
          <div class="col-4 cursor-pointer align-center" style="text-align: center;"><b class="sort_team">По команде <i class="<?php // echo $sort_team_ico; ?>"></i></b></div>
          <div class="col-4 cursor-pointer align-center" style="text-align: center;"><b class="sort_group">По группе <i class="<?php // echo $sort_group_ico; ?>"></i></b></div>
        </div>
      </div>
      <div class="modal-footer" style="">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
      </div>
    </div>
  </div>
</div>
-->
<!-- Печать -->
<div id="modalPrint" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="">Статистика благовестия</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-2" style="align-self: center; max-width: 60px; padding-right: 5px;">
            <span>Период </span>
          </div>
          <div class="col-2" style="min-width: 150px; padding-right: 10px;">
            <input id="period_from_print" type="date" class="form-control form-control-sm" value="<?php echo $date_from; ?>">
          </div>
          <div class="col-1" style="align-self: center;  max-width: 10px;  padding-left: 0px; padding-right: 0px;">
            <span style=""> — </span>
          </div>
          <div class="col-2" style="min-width: 150px; padding-left: 10px;">
            <input id="period_to_print" type="date" class="form-control form-control-sm" value="<?php echo $date_curent; ?>">
          </div>
          <div class="col-2" style="min-width: 150px; padding-left: 10px;">
            <select id="team_select_print" class="form-control form-control-sm">
              <option value="_all_" selected>Все команды</option>
              <?php
              $my_team = '';
               foreach (getGospelTeam() as $key => $value):
              if (isset($serving_ones_list_full[$memberId])) {
                $selected = '';
                if ($serving_ones_list_full[$memberId][2] === $key) {
                  $my_team = $key;
                  $selected = 'selected';
                }
              }
              echo "<option value='{$key}' {$selected}>{$value}</option>";
            endforeach; ?>
            </select>
          </div>
          <div class="col-2" style="min-width: 150px; padding-left: 10px;">
            <select id="group_select_print" class="form-control form-control-sm">
              <?php if ($my_team):
                $same_group = '';
                ?>
                <option value="_all_">Все группы</option>
                <?php foreach (getGospelGroup() as $key => $value):

                    if ($my_team === $value['gospel_team']) {
                      if ($same_group !== $value['gospel_group']) {
                        echo "<option value='{$value['gospel_group']}'>{$value['gospel_group']}</option>";
                        $same_group = $value['gospel_group'];
                      }
                    }
                endforeach; ?>
              <?php endif; ?>
            </select>
          </div>
        </div>
        <div id="gospel_body_print" class="row">
          <div class="col">
          <div id="tableStatPrint" class="row" style="max-height:450px; overflow-y: auto; padding-left: 7px;">
            <table class="table"><!-- style="width:760px;" -->
              <thead>
                <tr class="tbl-statistics-header">
                  <th style="text-align: left" colspan="8"> <!-- colspan="3"  -->
                    <span id="team_name_print"></span><br>
                    <span style="padding-left: 25px;"  id="group_number_print"></span>
                  </th>
                </tr>
                <tr class="tbl-statistics-header">
                  <th  id="th_questions" style="text-align: left;">Вопросы</th>
                  <th style="text-align: right; min-width: 99px;">За период</th>
                  <th style="padding-left: 10px; text-align: right; min-width: 104px;">За семестр</th>
                </tr>
                <tr>
                  <td id="question_flyers" style="text-align: left">Сколько листовок вы раздали?</td>
                  <td id="range_flyers" style="text-align: right"></td>
                  <td id="flyers_all" style="text-align: right"></td>
                </tr>
                <tr>
                  <td id="question_people" style="text-align: left">Скольким людям вы благовествовали?</td>
                  <td id="range_people" style="text-align: right"></td>
                  <td id="people_all" style="text-align: right"></td>
                </tr>
                <tr>
                  <td id="question_prayers" style="text-align: left">Сколько человек помолилось с вами?</td>
                  <td id="range_prayers" style="text-align: right"></td>
                  <td id="prayers_all" style="text-align: right"></td>
                </tr>
                <tr>
                  <td id="question_baptism" style="text-align: left">Сколько человек было крещено?</td>
                  <td id="range_baptism" style="text-align: right"></td>
                  <td id="baptism_all" style="text-align: right"></td>
                </tr>
                <tr>
                  <td id="question_meets_last" style="text-align: left">Со сколькими новичками прошлых семестров вы встречались?</td>
                  <td id="range_meets_last" style="text-align: right"></td>
                  <td id="meets_last_all" style="text-align: right"></td>
                </tr>
                <tr>
                  <td id="question_meets_current" style="text-align: left">Со сколькими новичками текущего семестра вы встречались?</td>
                  <td id="range_meets_current" style="text-align: right"></td>
                  <td id="meets_current_all" style="text-align: right"></td>
                </tr>
                <tr>
                  <td id="question_meetings_last" style="text-align: left">Сколько новичков прошлых семестров было на собрании?</td>
                  <td id="range_meetings_last" style="text-align: right"></td>
                  <td id="meetings_last_all" style="text-align: right"></td>
                </tr>
                <tr>
                  <td id="question_meetings_current" style="text-align: left">Сколько новичков текущего семестра было на собрании?</td>
                  <td  id="range_meetings_current" style="text-align: right"></td>
                  <td id="meetings_current_all" style="text-align: right"></td>
                </tr>
                <tr>
                  <td id="question_homes" style="text-align: left">Сколько домов святых вы посетили?</td>
                  <td id="range_homes" style="text-align: right"></td>
                  <td id="homes_all" style="text-align: right"></td>
                </tr>
                <tr>
                  <td style="text-align: left" colspan="8"><b>Проект «Библия, открытая для всех»</b></td>
                </tr>
                <tr>
                  <td id="question_first_contacts" style="text-align: left">Сколько было первых контактов по телефону или в переписке?</td>
                  <td id="range_first_contacts" style="text-align: right"></td>
                  <td  id="first_contacts_all" style="text-align: right"></td>
                </tr>
                <tr>
                  <td id="question_further_contacts" style="text-align: left">Сколько было повторных контактов по телефону или в переписке?</td>
                  <td id="range_further_contacts" style="text-align: right; vertical-align: top;"></td>
                  <td id="further_contacts_all" style="text-align: right; vertical-align: top;"></td>
                </tr>
              </thead>
              <tbody id="listGospelPrint"></tbody>
            </table>
          </div>
          <div id="groups_members_show">
            <br>
            <b style="padding-left: 5px;">Состав групп</b>
            <span id="members_groups_print"></span>
          </div>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="">
        <button id="print_button" class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true" style="">Печать</button>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
      </div>
    </div>
  </div>
</div>


<!-- рекомендованые показатели -->
<div id="modalRecommended" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="">Цели благовестия</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col-12 mb-2">
              <select id="team_goal_select" class="form-control form-control-sm">
                <option value="_all_">Все команды</option>
                <?php
                $my_team = '';
                $my_group = '';
                ?>
                <?php foreach (getGospelTeam() as $key => $value):
                  if ($ftt_access['group'] === 'staff') {
                    $selected = '';
                    if ($serving_ones_list_full[$memberId][2] === $key) {
                      $selected = 'selected';
                      $my_team = $key;
                    }
                  } else {
                    $selected = '';
                    if ($trainee_data['gospel_team'] === $key) {
                      $selected = 'selected';
                      $my_team = $key;
                      $my_group = $trainee_data['gospel_group'];
                    }
                  }
                  echo "<option value='{$key}' {$selected}>{$value}</option>";
                endforeach; ?>
              </select>
            </div>
            <div class="col-12 mb-2">
              <select id="group_goal_select" class="form-control form-control-sm">
                <?php if ($my_team):
                  $same_group = '';
                  ?>
                  <option value="_all_">Все группы</option>
                  <?php foreach (getGospelGroup() as $key => $value):
                    if ($ftt_access['group'] === 'staff') {
                      if ($my_team === $value['gospel_team']) {
                        if ($same_group !== $value['gospel_group']) {
                          echo "<option value='{$value['gospel_group']}'>{$value['gospel_group']}</option>";
                          $same_group = $value['gospel_group'];
                        }
                      }
                    } else {
                      if ($my_team === $value['gospel_team'] ) {
                        $selected = '';
                        if ($same_group !== $value['gospel_group']) {
                          if ($trainee_data['gospel_group'] === $value['gospel_group']) {
                            $selected = 'selected';
                          }
                          echo "<option value='{$value['gospel_group']}' {$selected}>{$value['gospel_group']}</option>";
                          $same_group = $value['gospel_group'];
                        }
                      }
                    }
                  endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
            <?php
            //$gospel_goals = '';
            $semester_flyers = 0;
            $semester_people = 0;
            $semester_prayers = 0;
            $semester_baptism = 0;
            $semester_fruit = 0;
            foreach (getGospelGoals() as $key => $value) {
              if ($ftt_access['group'] === 'staff') {
                if ($my_team === $value['gospel_team']) {
                  $semester_flyers += $value['flyers'];
                  $semester_people += $value['people'];
                  $semester_prayers += $value['prayers'];
                  $semester_baptism += $value['baptism'];
                  $semester_fruit += $value['fruit'];
                }
              } else {
                if ($my_team === $value['gospel_team'] && $my_group === $value['gospel_group']) {
                  $semester_flyers += $value['flyers'];
                  $semester_people += $value['people'];
                  $semester_prayers += $value['prayers'];
                  $semester_baptism += $value['baptism'];
                  $semester_fruit += $value['fruit'];
                }
              }

            }
            ?>
          </div>
          <!--<hr style="border: 1px solid lightgrey; margin-top: 12px; margin-bottom: 12px;">-->
          <div class="row mb-2">
            <div class="col-12 mb-1"><b>Сколько листовок в неделю вы хотите раздавать?</b></div>
            <div class="col-2"><input id="semester_flyers" type="number" class="form-control form-control-sm recom_goal little_number_field" data-field="flyers"
              value="<?php echo $semester_flyers; ?>">
            </div>
            <div class="col-3 pt-1 pl-1"> (не менее <?php echo getValueFttParamByName('min_flyers'); ?>)</div>
          </div>
          <div class="row mb-2">
            <div class="col-12 mb-1"><b>Скольким людям вы хотите благовествовать в течение недели?</b></div>
            <div class="col-2"><input id="semester_people" type="number" class="form-control form-control-sm recom_goal little_number_field" data-field="people"
              value="<?php echo $semester_people; ?>">
            </div>
            <div class="col-3 pt-1 pl-1">
              (не менее <?php echo getValueFttParamByName('min_people'); ?>)
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 mb-1"><b>Сколько спасенных человек вы хотите обретать каждую неделю?</b></div>
            <div class="col-2"><input id="semester_prayers" type="number" class="form-control form-control-sm recom_goal little_number_field" data-field="prayers"
              value="<?php echo $semester_prayers; ?>">
            </div>
            <div class="col-3 pt-1 pl-1">
                (не менее <?php echo getValueFttParamByName('min_prayers'); ?>)
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 mb-1"><b>Сколько человек вы хотите крестить за семестр?</b></div>
            <div class="col-2"><input id="semester_baptism" type="number" class="form-control form-control-sm recom_goal little_number_field" data-field="baptism"
              value="<?php echo $semester_baptism; ?>">
            </div>
            <div class="col-3 pt-1 pl-1">
                (не менее <?php echo getValueFttParamByName('min_baptism'); ?>)
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 mb-1"><b>Сколько пребывающего плода вы хотите принести за семестр (новые верующие, с которыми вы регулярно проводите встречи и кто участвует в собраниях церкви)?</b></div>
            <div class="col-2"><input id="semester_fruit" type="number" class="form-control form-control-sm recom_goal little_number_field" data-field="fruit"
              value="<?php echo $semester_fruit; ?>">
            </div>
            <div class="col-3 pt-1 pl-1">
              (не менее <?php echo getValueFttParamByName('min_fruit'); ?>)
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer" style="">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true" style="">Закрыть</button>
      </div>
    </div>
  </div>
</div>


<!-- Список получателей -->
<div id="gospel_modal_list" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="mb-0"></h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="container pl-2 pr-0">
          <div class="row pl-2 pr-2">
            <select id="modal_flt_male" class="form-control form-control-sm mb-2 mr-2">
              <option value="_all_">Все</option>
              <option value="1">Братья</option>
              <option value="0">Сёстры</option>
            </select>
            <select id="modal_flt_semester" class="form-control form-control-sm mb-2 mr-2">
              <option value="_all_">Все семестры</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
          </div>
          <div class="row">
            <div class="col pl-2">
              <div class="row">
                <div id="modal_extra_groups" class="col">
                  <h5>Обучающиеся</h5>
                  <div>
                    <label class="form-check-label" style="display: none;"><input id="modal_list_select_all" type="checkbox"> <b>Выбрать все</b></label>
                  </div>
                  <?php
                  foreach ($trainee_list_full as $key => $value) {
                    echo "<div><label class='form-check-label font-weight-normal'><input type='checkbox' ". RenderList::dataAttr($value, array('apartment', 'male', 'semester')) ." value='{$key}'> ".$value[0]."</label></div>";
                  } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- Статистика благовестия -->
<div id="gospel_modal_statistic" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="mb-0">Статистика благовестия</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col">
              <?php gospelStatFun(); ?>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<?php

// hundler START
// служащие
function gospelStatFun()
{
  // список обучающиеся в команде
  $traineesList = GospelStatistic::traineesByTeam($team);
  // группы команды
  $groupsList = getGospelGroups($team);
  // команды
  $teamsList = getGospelTeam();
  $team = '04';

  // html

  $date_day = date('w');
  $remainder = $date_day - 2;
  $gospelTeamReportData = [];
  $date_current_report = date_create(date('Y-m-d'));

  // дней с начала семестра.
  $date1 = date('Y-m-d');
  $date2 = date_convert::ddmmyyyy_to_yyyymmdd(getValueFttParamByName('attendance_start'));
  $reportLength = DatesCompare::diff(date('Y-m-d'), date_convert::ddmmyyyy_to_yyyymmdd(getValueFttParamByName('attendance_start')));

  if ($remainder > 0) {
    $gospelTeamReportData[] = GospelStatistic::teamReport($team, date('Y-m-d') , $remainder);
    date_sub($date_current_report,date_interval_create_from_date_string("{$remainder} days"));
  } elseif ($remainder < 0) {
    $remainder = 7 + $remainder;
    $gospelTeamReportData[] = GospelStatistic::teamReport($team, date('Y-m-d'), $remainder);
    date_sub($date_current_report,date_interval_create_from_date_string("{$remainder} days"));
  }

  // создать массив и в каждый элемент положить статисику за каждую неделю ()и за текущую неполную).
  // if ($w > 3) $x = $w - 3 ($x это текущий период);
  // else ($w =< 3) ???

  // вычисляем предыдущие периоды
  // from date("d.m", mktime(0, 0, 0, date("m"), date("d")-$x))
  // to date('d.m')

  for ($i=0; $i < $reportLength; $i=$i+7) {
    $gospelTeamReportData[] = GospelStatistic::teamReport($team, date_format($date_current_report,"Y-m-d"));
    date_sub($date_current_report,date_interval_create_from_date_string("7 days"));
    // from date("d.m", mktime(0, 0, 0, date("m"), date("d")-(x+7+$i)))
    // to date("d.m", mktime(0, 0, 0, date("m"), date("d")-(x+$i)))
  }

  foreach ($gospelTeamReportData as $key => $value) {
    if ($key == 0) {
      echo "<h5>$teamsList[$team]</h5>";
      $count = count($gospelTeamReportData);
    }
    $block = 0;
    foreach ($value as $key_1 => $value_1) {
      if (!$block) {
        echo "<b>НЕДЕЛЯ {$count}</b><br>";
      }
      echo "<b>Группа {$value_1['gospel_group']}</b><br>";
      echo $value_1['date'].', Л'.$value_1['flyers'].'.<br>';
      $block = 1;
    }
    if ($key != 0) {
      echo "<br>";
    }
    $count--;
  }
}

// hundler STOP
function getServiceOnesWithTraineesss ()
{
  foreach ($result as $key => $value) {

    // НУЛЕВЫЕ (по которым нет отчёта в выбраном периоде) ГРУППЫ И ОБУЧАЮЩИХСЯ

    // ГРУППЫ Найти по ключу и если нет добавить
    if (count($gospelTeamReportData) > 0 || !empty($sOteam)) {
      $gospelText = 'Статистика благовестия за неделю с ' . date("d.m", mktime(0, 0, 0, date("m"), date("d")-7)) . ' по ' . date('d.m') .':<br><br>';
      if (count($gospelTeamReportData) == 0) {
        foreach ($sOGroups as $key_all_group => $value_all_group) {
          $gospelTeamReportData[] = array('gospel_group' => $value_all_group, 'flyers' => 0, 'people' => 0, 'prayers' => 0, 'baptism' => 0, 'meets_last' => 0, 'meets_current' => 0, 'meetings_last' => 0, 'meetings_current' => 0, 'homes' => 0);
        }
      }

      $res = db_query("SELECT `name` FROM `ftt_gospel_team` WHERE `id`='$team'");
      while ($row = $res->fetch_assoc()) $team = $row['name'];
      $gospelText .= "<b>Команда {$team}</b><br>";
      $statistic = [];
      foreach ($gospelTeamReportData as $key_1 => $value_1) {
        if (!isset($statistic[$value_1['gospel_group']])) {
          $statistic[$value_1['gospel_group']] = array($value_1['flyers'], $value_1['people'], $value_1['prayers'], $value_1['baptism'], $value_1['meets_last'], $value_1['meets_current'], $value_1['meetings_last'], $value_1['meetings_current'], $value_1['homes']);
        } else {
          $statistic[$value_1['gospel_group']][0] += $value_1['flyers'];
          $statistic[$value_1['gospel_group']][1] += $value_1['people'];
          $statistic[$value_1['gospel_group']][2] += $value_1['prayers'];
          $statistic[$value_1['gospel_group']][3] += $value_1['baptism'];
          $statistic[$value_1['gospel_group']][4] += $value_1['meets_last'];
          $statistic[$value_1['gospel_group']][5] += $value_1['meets_current'];
          $statistic[$value_1['gospel_group']][6] += $value_1['meetings_last'];
          $statistic[$value_1['gospel_group']][7] += $value_1['meetings_current'];
          $statistic[$value_1['gospel_group']][8] += $value_1['homes'];
        }
      }

      $group_missing = array_diff_key($sOGroups,$statistic);

      if (count($group_missing) > 0) {
        foreach ($group_missing as $key_1 => $value_1) {
          $statistic[$key_1] = array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        }
        ksort($statistic);
      }

      foreach ($statistic as $key_1 => $value_1) {
        $colorRedGrp = '';
        if (!$value_1[0] && !$value_1[1] && !$value_1[2] && !$value_1[3] && !$value_1[4] && !$value_1[5] && !$value_1[6] && !$value_1[7] && !$value_1[8]) {
          $colorRedGrp = 'style="color: red;"';
        }
        $gospelText .= "<span {$colorRedGrp}>Группа ";
         $gospelText .= $key_1 . ': Л' . $value_1[0] . ', Б' . $value_1[1] . ', М' . $value_1[2];
         $gospelText .= ', К' .$value_1[3] . ', В' . (intval($value_1[4]) + intval($value_1[5]));
         $gospelText .= ', С' . (intval($value_1[6]) + intval($value_1[7])) . ', Д' . $value_1[8] . '</span><br>';
      }

      $gospelText .= '<br>';
    }

    $gospelTextData = statistics::gospelPersonalSeven($traine_list);
    if (count($gospelTextData) > 0 || count($sOTrainees) > 0) {
      if (empty($gospelText)) {
        $gospelText = 'Статистика благовестия за неделю с ' . date("d.m", mktime(0, 0, 0, date("m"), date("d")-7)) . ' по ' . date('d.m') . ':<br><br>';
      }
      $trainePrepare = [];
      foreach ($gospelTextData as $key_1 => $value_1) {
        $trainePrepare[$value_1['member_key']] = $value_1['member_key'];
      }

      $trainees_missing = array_diff_key($sOTrainees, $trainePrepare);

      if (count($trainees_missing) > 0) {
        foreach ($trainees_missing as $key_1 => $value_1) {
          $gospelTextData[] = array('member_key' => $key_1, 'number' => 0, 'first_contacts' => 0, 'further_contacts' => 0, 'name' => Member::get_name($key_1));
        }
        // Сортируем
        $nameSort  = array_column($gospelTextData, 'name');
        array_multisort($nameSort, SORT_ASC, $gospelTextData);
      }
      $statisticPersonal = [];
      $gospelText .= '<b>Выходы на благовестие и звонки</b><br>';
      foreach ($gospelTextData as $key_1 => $value_1) {
        if ($value_1['member_key']) {
          if (!isset($statisticPersonal[$value_1['member_key']])) {
            $statisticPersonal[$value_1['member_key']] = array($value_1['number'], $value_1['first_contacts'], $value_1['further_contacts']);
          } else {
            $statisticPersonal[$value_1['member_key']][0] += $value_1['number'];
            $statisticPersonal[$value_1['member_key']][1] += $value_1['first_contacts'];
            $statisticPersonal[$value_1['member_key']][2] += $value_1['further_contacts'];

          }
        }
      }
      foreach ($statisticPersonal as $key_1 => $value_1) {
        $colorRed = '';
        if (!$value_1[0] && !$value_1[1] && !$value_1[2]) {
          $colorRed = 'style="color: red;"';
        }
        $gospelText .= "<span {$colorRed}>" . short_name::no_middle(Member::get_name($key_1)) . " (группа " . $sOTrainees[$key_1] . "): В" . $value_1[0] . ', Н'. $value_1[1]. ', П'. $value_1[2];
        $gospelText .= "</span><br>";
      }
    }

    if ($gospelText) {

    } else {
      // add str to log file
    }
  }
}

?>
