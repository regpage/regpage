<div id="extra_help_staff" class="container">
  <!-- Nav tabs -->
  <!--<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#gospel_tab">Благовестие</a>
    </li>
  </ul>-->
  <!-- Tab panes -->
  <div id="tab_content_extra_help" class="tab-content">
    <div id="gospel_tab" class="container tab-pane active"><br>
      <div id="bar_extra_help" class="btn-group">
        <button id="showModalAddEdit" type="button" class="btn btn-success btn-sm">Добавить</button>
        <button id="filters_button" type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalFilrets" style="display: none;">Фильтры</button>
        <button id="modalRecommended_open" type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalRecommended">Цели</button>
        <?php if ($ftt_access['group'] === 'staff' || $serving_trainee) { ?>
          <!--<button id="sort_button" type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalSort" style="display: none;">Порядок</button>-->
          <button id="print_modal_open" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalPrint" >Отчёт</button>
        <!--<select id="sort_select" class="form-control form-control-sm" style="display: none;">
          <option value="">По дате</option>
          <option value="">По команде</option>
          <option value="">По группе</option>
        </select>-->
        <select id="team_select" class="form-control form-control-sm">
          <option value="_all_">Все команды</option>
          <?php foreach ($teamsList as $key => $value):
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
          <select id="author_select_desk" class="form-control form-control-sm" name="">
            <option value="_all_">Все обучающиеся</option>
            <?php foreach ($trainee_list as $key => $value):
              $selected = '';
              if ($key === $memberId) {
                $selected = 'selected';
              }
              echo "<option value='{$key}' {$selected}>{$value}</option>";
            endforeach; ?>
          </select>
        <?php } ?>

        <select id="periods" class="form-control form-control-sm">
          <?php
          $selected_month = '';
          $selected_all = '';
          $selected_range = '';
          if (isset($_COOKIE['filter_period'])) {
            if ($_COOKIE['filter_period'] === 'month') {
              $selected_month = 'selected';
            } elseif ($_COOKIE['filter_period'] === '_all_') {
              $selected_all = 'selected';
            } else {
              $selected_range = 'selected';
            }
          } else {
            $selected_month = 'selected';
          } ?>
          <option value="month" <?php echo $selected_month; ?>>За месяц</option>
          <option value="_all_" <?php echo $selected_all; ?>>За семестр</option>
          <option value="range" <?php echo $selected_range; ?>>За период</option>
        </select>
        <span class="filter_range" style="padding: 5px; padding-right: 10px; display: none;">Период</span>
        <input id="period_from" type="date" class="form-control form-control-sm filter_range" style="display: none;" value="<?php echo $_COOKIE['period_from']; ?>">
        <span class="filter_range" style="padding: 5px; padding-right:10px; padding-left:10px; display: none;"> — </span>
        <input id="period_to" type="date" class="form-control form-control-sm filter_range" style="display: none;" value="<?php echo $_COOKIE['period_to']; ?>">
        <!--<select id="service_one_select" class="form-control form-control-sm">
          <option value="_all_">Все служащие</option>
          <?php /* foreach ($serving_ones_list as $key => $value):
            $selected = '';
            if ($key === $memberId) {
              $selected = 'selected';
            }
            echo "<option value='{$key}' $selected>{$value}</option>";
          endforeach; */?>
        </select>-->
      </div>
      <?php

      $sort_date_ico = 'hide_element';
      $sort_team_ico = 'hide_element';
      $sort_group_ico = 'hide_element';
      $sort_flyers_ico = 'hide_element';
      $sort_people_ico = 'hide_element';
      $sort_prayers_ico = 'hide_element';
      $sort_homes_ico = 'hide_element';
      $sort_meets_ico = 'hide_element';
      $sort_meetings_ico = 'hide_element';
      $sort_first_ico = 'hide_element';
      $sort_further_ico = 'hide_element';

      if (isset($_COOKIE['sorting'])) {
        if ($_COOKIE['sorting'] === 'sort__date-desc') {
          $sort_date_ico = 'fa fa-sort-asc';
        } elseif ($_COOKIE['sorting'] === 'sort__date-asc') {
          $sort_date_ico = 'fa fa-sort-desc';
        } elseif ($_COOKIE['sorting'] === 'sort__team-desc') {
          $sort_team_ico = 'fa fa-sort-asc';
        } elseif ($_COOKIE['sorting'] === 'sort__team-asc') {
          $sort_team_ico = 'fa fa-sort-desc';
        } elseif ($_COOKIE['sorting'] === 'sort__gospel_group-desc') {
          $sort_group_ico = 'fa fa-sort-asc';
        } elseif ($_COOKIE['sorting'] === 'sort__gospel_group-asc') {
          $sort_group_ico = 'fa fa-sort-desc';
        } elseif ($_COOKIE['sorting'] === 'sort__flyers-asc') {
          $sort_flyers_ico = 'fa fa-sort-desc';
        } elseif ($_COOKIE['sorting'] === 'sort__flyers-desc') {
          $sort_flyers_ico = 'fa fa-sort-asc';
        } elseif ($_COOKIE['sorting'] === 'sort__people-asc') {
          $sort_people_ico = 'fa fa-sort-desc';
        } elseif ($_COOKIE['sorting'] === 'sort__people-desc') {
          $sort_people_ico = 'fa fa-sort-asc';
        } elseif ($_COOKIE['sorting'] === 'sort__prayers-asc') {
          $sort_prayers_ico = 'fa fa-sort-desc';
        } elseif ($_COOKIE['sorting'] === 'sort__prayers-desc') {
          $sort_prayers_ico = 'fa fa-sort-asc';
        } elseif ($_COOKIE['sorting'] === 'sort__homes-asc') {
          $sort_homes_ico = 'fa fa-sort-desc';
        } elseif ($_COOKIE['sorting'] === 'sort__homes-desc') {
          $sort_homes_ico = 'fa fa-sort-asc';
        } elseif ($_COOKIE['sorting'] === 'sort__meets-asc') {
          $sort_meets_ico = 'fa fa-sort-desc';
        } elseif ($_COOKIE['sorting'] === 'sort__meets-desc') {
          $sort_meets_ico = 'fa fa-sort-asc';
        } elseif ($_COOKIE['sorting'] === 'sort__meetings-asc') {
          $sort_meetings_ico = 'fa fa-sort-desc';
        } elseif ($_COOKIE['sorting'] === 'sort__meetings-desc') {
          $sort_meetings_ico = 'fa fa-sort-asc';
        } elseif ($_COOKIE['sorting'] === 'sort__first-asc') {
          $sort_first_ico = 'fa fa-sort-desc';
        } elseif ($_COOKIE['sorting'] === 'sort__first-desc') {
          $sort_first_ico = 'fa fa-sort-asc';
        } elseif ($_COOKIE['sorting'] === 'sort__further-asc') {
          $sort_further_ico = 'fa fa-sort-desc';
        } elseif ($_COOKIE['sorting'] === 'sort__further-desc') {
          $sort_further_ico = 'fa fa-sort-asc';
        } else {
          $sort_date_ico = 'fa fa-sort-asc';
        }
      } else {
        $sort_date_ico = 'fa fa-sort-desc';
      } ?>
      <div class="row"><span class="col-12 text_grey font-weight-bold text-muted mt-3 mb-3" id="filters_list"></span></div>
      <div id="list_header" class="row">
        <div class="col-2 pl-1" style="max-width: 90px !important;"><b class="sort_col sort__date">Дата <i class="<?php echo $sort_date_ico; ?>"></i></b></div>
        <div class="col-2" style="max-width: 120px !important;"><b class="sort_col sort__team">Команда <i class="<?php echo $sort_team_ico; ?>"></i></b></div>
        <div class="col-2" style="min-width: 260px !important;"><b class="sort_col sort__gospel_group">Состав группы <i class="<?php echo $sort_group_ico; ?>"></i></b></div>
        <div class="col-1 text-right col_w_60" title="Сколько листовок раздали?"><b class="sort_col sort__flyers">Л <i class="<?php echo $sort_flyers_ico; ?>"></i></b></div>
        <div class="col-1 text-right text_grey col_w_60" title="Скольким людям благовествовали?"><b class="sort_col sort__people">Б <i class="<?php echo $sort_people_ico; ?>"></i></b></div>
        <div class="col-1 text-right text_grey col_w_60" title="Сколько человек помолилось?"><b class="sort_col sort__prayers">М <i class="<?php echo $sort_prayers_ico; ?>"></i></b></div>
        <div class="col-1 text-right text_grey col_w_60" title="Сколько было новых контактов?"><b class="sort_col sort__first">Н <i class="<?php echo $sort_first_ico; ?>"></i></b></div>
        <div class="col-1 text-right text_grey col_w_60" title="Сколько было повторных контактов?"><b class="sort_col sort__further">П <i class="<?php echo $sort_further_ico; ?>"></i></b></div>
        <div class="col-1 text-right text_grey col_w_60" title="сумма двух видов встреч"><b class="sort_col sort__meets">В <i class="<?php echo $sort_meets_ico; ?>"></i></b></div>
        <div class="col-1 text-right text_grey col_w_60" title="сумма двух видов собраний"><b class="sort_col sort__meetings">С <i class="<?php echo $sort_meetings_ico; ?>"></i></b></div>
        <div class="col-1 text-left text_grey col_w_60" style="padding-left: 35px;" title="Сколько домов святых вы посетили?"><b class="sort_col sort__homes">Д <i class="<?php echo $sort_homes_ico; ?>"></i></b></div>
      </div>
      <div id="list_content">
        <?php
          $periods_cookie;
          if (isset($_COOKIE['filter_period'])) {
            $periods_cookie = $_COOKIE['filter_period'];
          } else {
            $periods_cookie = 'month';
          }
          if ($ftt_access['group'] === 'staff' || $serving_trainee) {
            $traineeId = false;
          } else {
            $traineeId = $memberId;
          }

          // sorting
          if (isset($_COOKIE['sorting'])) {
            $sort_cookie = $_COOKIE['sorting'];
          } else {
            $sort_cookie = 'sort__date-desc';
          }

          $period_from_cookie = '';
          $period_to_cookie = '';

          if (isset($_COOKIE['period_from'])) {
            $period_from_cookie = $_COOKIE['period_from'];
          }

          if (isset($_COOKIE['period_to'])) {
            $period_to_cookie = $_COOKIE['period_to'];
          }
          // data
          $gospelBlanksList = getGospel($periods_cookie, $traineeId, $sort_cookie, $period_from_cookie, $period_to_cookie);
          // personal data sorting
          if ($sort_cookie == 'sort__first-desc' || $sort_cookie == 'sort__further-desc' || $sort_cookie == 'sort__first-asc' || $sort_cookie == 'sort__further-asc') {

            $membersBlankStatistic = GospelStatistic::membersBlanksStatistic();

            for ($i=0; $i < count($gospelBlanksList); $i++) {
              $gospelBlanksList[$i]['first_contacts_sum'] = $membersBlankStatistic[$gospelBlanksList[$i]['id']]['first_contacts'];
              $gospelBlanksList[$i]['further_contacts_sum'] = $membersBlankStatistic[$gospelBlanksList[$i]['id']]['further_contacts'];
              $gospelBlanksList[$i]['number_sum'] = $membersBlankStatistic[$gospelBlanksList[$i]['id']]['number'];
            }
            // Сортируем
            $column = 'first_contacts_sum';
            if ($sort_cookie == 'sort__first-desc') {
              $nameSort  = array_column($gospelBlanksList, 'first_contacts_sum');
              array_multisort($nameSort, SORT_DESC, $gospelBlanksList);
            } elseif ($sort_cookie == 'sort__first-asc') {
              $nameSort  = array_column($gospelBlanksList, 'first_contacts_sum');
              array_multisort($nameSort, SORT_ASC, $gospelBlanksList);
            } elseif ($sort_cookie == 'sort__further-desc') {
              $nameSort  = array_column($gospelBlanksList, 'further_contacts_sum');
              array_multisort($nameSort, SORT_DESC, $gospelBlanksList);
            } elseif ($sort_cookie == 'sort__further-asc') {
              $nameSort  = array_column($gospelBlanksList, 'further_contacts_sum');
              array_multisort($nameSort, SORT_ASC, $gospelBlanksList);
            }
          }

          foreach ($gospelBlanksList as $key => $value):
          //$short_name_service_one = short_name::no_middle($serving_ones_list[$value['serving_one']]);

          $str_number = 0;
          $str_first = 0;
          $str_further = 0;

          foreach ($gospelMembersList as $key_1 => $value_1) {
            if ($value_1['blank_id'] === $value['id']) {
              $str_number += $value_1['number'];
              $str_first += $value_1['first_contacts'];
              $str_further += $value_1['further_contacts'];
            }
          }

          $str_id = $value['id'];
          $str_date = $value['date'];
          $str_date_short = date_convert::yyyymmdd_to_ddmm($str_date);
          $str_author = $value['author'];
          $str_gospel_team = $value['gospel_team'];
          $fltr_team_cookie;
          if (!$serving_ones_list_full[$memberId][2]) {
            if (!isset($_COOKIE['filter_team'])) {
              $fltr_team_cookie = '_all_';
            }
          }
          $str_gospel_group = $value['gospel_group'];
          $str_place = $value['place'];
          $str_group_members = $value['group_members'];
          $group_members_text = '';
          if ($str_group_members) {
            $str_pieces = explode(',', $str_group_members);
            for ($i=0; $i < count($str_pieces); $i++) {
              $group_members_text .= short_name::short($trainee_list[trim($str_pieces[$i])]);
            }
            //$group_members_text .= $str_pieces[$i]."&#8239;".$str_pieces[$i+1];
          }

          $str_flyers = $value['flyers'];
          $str_people = $value['people'];
          $str_prayers = $value['prayers'];
          $str_baptism = $value['baptism'];
          $str_meets_last = $value['meets_last'];
          $str_meets_current = $value['meets_current'];
          $str_meets_sum = $value['meets_last'] + $value['meets_current'];
          $str_meetings_last = $value['meetings_last'];
          $str_meetings_current = $value['meetings_current'];
          $str_meetings_sum = $value['meetings_last'] + $value['meets_current'];
          $str_homes = $value['homes'];
          $str_changed = $value['changed'];
          $str_place_name = $value['place_name'];
          $str_fgt_place = $value['fgt_place'];
          $str_m_name = short_name::no_middle($value['m_name']);
          $str_male = $value['male'];
          $str_comment = $value['comment'];
          if ($str_comment) {
            $str_comment_hide = "";
          } else {
            $str_comment_hide = 'hide_element';
          }

          $col_n_4_disabled = '';
          $done_string = '';
          $show_string = '';
          $show_col_n_2_3 = '';
          $col_n_4_disabled = '';
          $checked_string = '';

          if (isset($trainee_data['gospel_group'])) {
            if ($trainee_data['gospel_group'] !== $str_gospel_group || $trainee_data['gospel_team'] !== $str_gospel_team) {
              $show_string = "style='display: none;'";
            }
          }

          if (isset($serving_ones_list_full[$memberId])) {
            if ((!isset($_COOKIE['filter_team']) && !$fltr_team_cookie && $serving_ones_list_full[$memberId][2] !== $str_gospel_team)
            || (isset($_COOKIE['filter_team']) && $_COOKIE['filter_team'] !== $str_gospel_team && $_COOKIE['filter_team'] !== '_all_')) {
              $show_string = "style='display: none;'";
            }
          }
          $dayOfTheWeek = date_convert::week_days($str_date, true);
          echo "<div class='row list_string {$done_string}' {$show_string} data-id='{$str_id}' data-date='{$str_date}' data-author='{$str_author}' data-gospel_team='{$str_gospel_team}' data-gospel_group='{$str_gospel_group}' data-place='{$str_place}' data-group_members='{$str_group_members}' data-number='{$str_number}' data-flyers='{$str_flyers}' data-people='{$str_people}' data-prayers='{$str_prayers}' data-baptism='{$str_baptism}'
          data-meets_last='{$str_meets_last}' data-meets_current='{$str_meets_current}' data-meetings_last='{$str_meetings_last}' data-meetings_current='{$str_meetings_current}'
          data-homes='{$str_homes}' data-place_name='{$str_place_name}' data-fgt_place='{$str_fgt_place}' data-comment='{$str_comment}'
          data-toggle='modal' data-target='#modalAddEdit'>
            <div class='col-1 pl-1 col_n_1'><span class='col_n_1_2'>{$str_date_short} {$dayOfTheWeek}</span></div>
            <div class='col-1 col_n_2' style='min-width: 120px !important;'><span class='col_n_2_2'>{$str_place_name}</span><span class='col_n_2_3'></span><br><span class='col_n_2_3' style='font-size: 12px; color: #AAA;'></span></div>
            <div class='col-1 col_n_10'><span class='col_n_10_2'>{$str_gospel_group}: {$group_members_text}</span></div>
            <div class='col-1 col_n_4 col_w_60 text-right'><span class='col_n_4_2'>{$str_flyers}</span></div>
            <div class='col-1 col_n_5 col_w_60 text-right'><span class='col_n_5_2'>{$str_people}</span></div>
            <div class='col-1 col_n_6 col_w_60 text-right'><span class='col_n_6_2'>{$str_prayers}</span></div>
            <div class='col-1 col_n_7 col_w_60 text-right'><span class='col_n_7_2'>{$str_first}</span></div>
            <div class='col-1 col_n_8 col_w_60 col_w_40 text-right'><span class='col_n_8_2'>{$str_further}</span></div>
            <div class='col-1 col_w_60 text-right'><span>{$str_meets_sum}</span></div>
            <div class='col-1 col_w_60 text-right'><span>{$str_meetings_sum}</span></div>
            <div class='col-1 text-left' style='padding-left: 35px;'><span>{$str_homes}</span><span class='float-right {$str_comment_hide}' title='{$str_comment}'><i class='fa fa-sticky-note' aria-hidden='true'></i></span></div>
            <div class='col-12 col_n_11 pl-1 hide_element'><span class='col_n_11_2' style='font-size: 14px; color: #AAA;'>{$str_gospel_group}: {$group_members_text}</span></div>
          </div>";
        endforeach; ?>
      </div>
    </div>
    <div id="current_late" class="container tab-pane fade"><br>
      <?php // include_once 'components/ftt_extra_help/staff_content_part_late.php'; ?>
    </div>
  </div>
</div>
