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
data-meetings_current="" data-first_contacts="" data-further_contacts="" data-homes="" data-place_name="" data-fgt_place="" data-comment="">
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
              <label for="fio_field" class="label-google">Команда *</label>
              <select id="fio_field" class="input-google">
                <option value="_none_"></option>
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
              <label class="label-google" for="date_field">Дата *</label>
              <input id="date_field" type="date" class="input-google">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label for="" class="label-google" style="">Состав группы <span class="cursor-pointer" style="color: #08c;"><u id="gospelGroupNumber"></u></span></label>
              <select id="gospel_group_field" class="select-google" style="display: none;">
                <option value="0"></option>
              <?php
                $old_value = '';
                foreach (getGospelGroupNumber() as $key => $value):
                  echo "<option value='{$value}'>{$value}</option>";
                endforeach;
              ?>
              </select>
              <input id="group_members_field" class="input-google" type="text" value="">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="label-google" for="flyers_field">Сколько было выходов на благовестие?</label>
              <br>
              <input id="number_field" type="number" class="input-google short_number_field" min="0" max="1000000">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="label-google" for="flyers_field">Сколько листовок вы раздали?</label>
              <br>
              <input id="flyers_field" type="number" class="input-google short_number_field" min="0" max="1000000">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="label-google" for="people_field">Скольким людям вы благовествовали?</label>
              <br>
              <input id="people_field" type="number" class="input-google short_number_field" min="0" max="1000000">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="label-google" for="prayers_field">Сколько человек помолилось с вами?</label>
              <br>
              <input id="prayers_field" type="number" class="input-google short_number_field" min="0" max="1000000">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="label-google" for="baptism_field">Сколько человек было крещено?</label>
              <br>
              <input id="baptism_field" type="number" class="input-google short_number_field" min="0" max="1000000">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="label-google" for="meets_last_field">Со сколькими новичками <u>прошлых</u> семестров вы встречались?</label>
              <input id="meets_last_field" type="number" class="input-google short_number_field" min="0" max="1000000">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="label-google" for="meets_current_field">Со сколькими новичками <u>текущего</u> семестра вы встречались?</label>
              <input id="meets_current_field" type="number" class="input-google short_number_field" min="0" max="1000000">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="label-google" for="meetings_last_field">Сколько новичков <u>прошлых</u> семестров было на собрании?</label>
              <input id="meetings_last_field" type="number" class="input-google short_number_field" min="0" max="1000000">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="label-google" for="meets_current_field">Сколько новичков <u>текущего</u> семестра было на собрании?</label>
              <input id="meetings_current_field" type="number" class="input-google short_number_field" min="0" max="1000000">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="label-google" for="homes_field">Сколько домов святых вы посетили?</label>
              <br>
              <input id="homes_field" type="number" class="input-google short_number_field" min="0" max="1000000">
            </div>
          </div>
        </div>
        <h6 class="mt-2">Проект «Библия, открытая для всех»</h6>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="label-google" for="first_contacts_field">Сколько было <u>первых</u> контактов по телефону или в переписке?</label>
              <input id="first_contacts_field" type="number" class="input-google short_number_field" min="0" max="1000000">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="form-group">
              <label class="label-google" for="further_contacts_field">Сколько было <u>повторных</u> контактов по телефону или в переписке?</label>
              <input id="further_contacts_field" type="number" class="input-google short_number_field" min="0" max="1000000">
            </div>
          </div>
        </div>
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
        <button id="save_extra_help" class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true" style="">Сохранить</button>
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
          <div id="tableStatPrint" class="row" style="max-height:400px; overflow-y: auto; padding-left: 7px;">
            <table class="table"><!-- style="width:760px;" -->
              <thead>
                <tr class="tbl-statistics-header">
                  <th style="text-align: left" colspan="8"> <!-- colspan="3"  -->
                    <span id="team_name_print"></span>
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
                  <td style="text-align: left" colspan="3"><b>Проект «Библия, открытая для всех»</b></td>
                </tr>
                <tr>
                  <td id="question_first_contacts" style="text-align: left">Сколько было первых контактов по телефону или в переписке?</td>
                  <td id="range_first_contacts" style="text-align: right"></td>
                  <td  id="first_contacts_all" style="text-align: right"></td>
                </tr>
                <tr>
                  <td id="question_further_contacts" style="text-align: left">Сколько было повторных контактов по телефону или в переписке?</td>
                  <td id="range_further_contacts" style="text-align: right"></td>
                  <td id="further_contacts_all" style="text-align: right"></td>
                </tr>
              </thead>
              <tbody id="listGospelPrint"></tbody>
            </table>
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
            <div class="col-1 pt-1 pl-1"> (<?php echo getValueFttParamByName('min_flyers'); ?>)</div>
          </div>
          <div class="row mb-2">
            <div class="col-12 mb-1"><b>Скольким людям вы хотите благовествовать в течение недели?</b></div>
            <div class="col-2"><input id="semester_people" type="number" class="form-control form-control-sm recom_goal little_number_field" data-field="people"
              value="<?php echo $semester_people; ?>">
            </div>
            <div class="col-1 pt-1 pl-1">
              (<?php echo getValueFttParamByName('min_people'); ?>)
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 mb-1"><b>Сколько спасенных человек вы хотите обретать каждую неделю?</b></div>
            <div class="col-2"><input id="semester_prayers" type="number" class="form-control form-control-sm recom_goal little_number_field" data-field="prayers"
              value="<?php echo $semester_prayers; ?>">
            </div>
            <div class="col-1 pt-1 pl-1">
                (<?php echo getValueFttParamByName('min_prayers'); ?>)
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 mb-1"><b>Сколько человек вы хотите крестить за семестр?</b></div>
            <div class="col-2"><input id="semester_baptism" type="number" class="form-control form-control-sm recom_goal little_number_field" data-field="baptism"
              value="<?php echo $semester_baptism; ?>">
            </div>
            <div class="col-1 pt-1 pl-1">
                (<?php echo getValueFttParamByName('min_baptism'); ?>)
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12 mb-1"><b>Сколько пребывающего плода вы хотите принести за семестр (новые верующие, с которыми вы регулярно проводите встречи и кто участвует в собраниях церкви)?</b></div>
            <div class="col-2"><input id="semester_fruit" type="number" class="form-control form-control-sm recom_goal little_number_field" data-field="fruit"
              value="<?php echo $semester_fruit; ?>">
            </div>
            <div class="col-1 pt-1 pl-1">
              (<?php echo getValueFttParamByName('min_fruit'); ?>)
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
