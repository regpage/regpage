<!-- Churches statistic -->

<!-- Botton bar Statistic START -->
      <div class="row">
          <div class="mr-2">
            <button class="btn btn-success btn-sm add-statistic" type="button"><i class="fa fa-plus icon-white"></i><span class="hide-name"> Добавить</span></button>
          </div>
          <!-- фильтры для моб. версии -->
          <div class="dropdown d-none">
              <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <span class="sortName fa fa-list"><?php echo $s = isset($_COOKIE['sort'])? $_COOKIE['sort'] : ' ' ?></span>
                  <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" id="dropdownMenu" aria-labelledby="dropdownMenu1">
                <li><a id="sort-id" href="#" title="сортировать">Код</a>&nbsp;<i class="<?php echo $sort_field=='id' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></li>
                  <li><a id="sort-city" href="#" title="сортировать">Город</a>&nbsp;<i class="<?php echo $sort_field=='city' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></li>
                  <li><a id="sort-status" href="#" title="сортировать">Статус</a>&nbsp;<i class="<?php echo $sort_field=='status' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></li>
                  <!--<li>
                      //<?php
                      /*if (!$isSingleCity)
                          echo '<th><a id="sort-locality_key" href="#" title="сортировать">Местность (район)</a>&nbsp;<i class="'.($sort_field=='locality_key' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none').'"></i></th>';*/
                      //?>
                  </li>-->
                  <li><a id="sort-half_year" href="#" title="сортировать">Крещ. за полгода</a>&nbsp;<i class="<?php echo $sort_field=='half_year' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></li>
                  <li><a id="sort-attended" href="#" title="сортировать">Посещают собран.</a>&nbsp;<i class="<?php echo $sort_field=='attended' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></li>
                  <li><a id="sort-count_ltmeeting" href="#" title="сортировать">На трапезе</a>&nbsp;<i class="<?php echo $sort_field=='count_ltmeeting' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></li>
                  <li><a id="sort-completed" href="#" title="сортировать">Заполнено</a>&nbsp;<i class="<?php echo $sort_field=='completed' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></li>
              </ul>
          </div>
          <div class="mr-2">
            <select id="fulfilledBlank" class="form-control form-control-sm" style="margin-right: 10px;">
              <option value="_all_" selected>Все бланки</option>
              <option value="1">Заполненные</option>
              <option value="0">Не заполненные</option>
            </select>
          </div>
          <?php if (!$isSingleCity) { ?>
          <div class="mr-2">
            <select id="selStatisticLocality" class="form-control form-control-sm" style="margin-right: 10px;">
              <option value='_all_' <?php echo $selStatisticLocality =='_all_' ? 'selected' : '' ?> >Все местности (районы)</option>
              <?php
                  foreach ($localities as $id => $name) {
                      echo "<option value='$id' ". ($id==$selStatisticLocality ? 'selected' : '') ." >".htmlspecialchars ($name)."</option>";
                  }
              ?>
            </select>
          </div>
          <?php } ?>
          <div class="">
            <select class="form-control form-control-sm" multiple id="arhivePeriods" style="width: 255px;" size="3">
            <?php
                foreach ($allPeriods as $key => $name) {
                    echo "<option value='$key'>".$key.'  ('.htmlspecialchars ($name).")</option>";
                }
            ?>
            </select>
          </div>

          <div id="blanksArchive" class="" data-id="<?php echo $periodActual; ?>" data-period="<?php echo $periodInterval; ?>">

          </div>
      </div>
<!-- Botton bar Statistic STOP -->
<!-- List Statistic BEGIN -->
      <div class="desctopVisible" id="statisticList">
        <table id="" class="table table-hover">
          <thead>
            <tr>
                <th style="text-align: left; min-width:70px"><a id="sort-id" href="#" title="сортировать">Код</a>&nbsp;<i class="<?php echo $sort_field=='id' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></th>
                <th style=""><a id="sort-city" href="#" title="сортировать">Город</a>&nbsp;<i class="<?php echo $sort_field=='city' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></th>
                <?php /*
                if (!$isSingleCity)
                    echo '<th><a id="sort-locality_key" href="#" title="сортировать">Местность (район)</a>&nbsp;<i class="'.($sort_field=='locality_key' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none').'"></i></th>';
                    */?>
                <th style="text-align: left; min-width:70px"><a id="sort-status" href="#" title="сортировать">Статус</a>&nbsp;<i class="<?php echo $sort_field=='status' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></th>
                <th style="text-align: left;"><a id="sort-bptz_half_year" href="#" title="сортировать">Крещены за полгода</a>&nbsp;<i class="<?php echo $sort_field=='half_year' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></th>
                <th style="text-align: left;"><a id="sort-attended" href="#" title="сортировать">Посещают собрания</a>&nbsp;<i class="<?php echo $sort_field=='attended' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></th>
                <th style="text-align: left;"><a id="sort-count_ltmeeting" href="#" title="сортировать">Количество на трапезе</a>&nbsp;<i class="<?php echo $sort_field=='count_ltmeeting' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></th>
                <th style="text-align: center;"><a id="sort-completed" href="#" title="сортировать">Заполнено</a>&nbsp;<i class="<?php echo $sort_field=='completed' ? ($sort_type=='desc' ? 'icon-chevron-up' : 'icon-chevron-down') : 'icon-none'; ?>"></i></th>
            </tr>
          </thead>
          <tbody>
          <?php
          $list_statistic = db_getStatisticStrings ($memberId, array_keys($localities));
          foreach ($list_statistic as $key => $value) {
            echo "<tr class='row-statistic' style='cursor: pointer;";
            if ($value['status_completed'] == '1') {
              echo "background-color: lightgreen";
            }
            echo "'";
            // data-
            echo "data-id='{$value['statistic_card_id']}' data-locality_key='{$value['locality_key']}' data-author='{$value['author']}' data-locality_status='{$value['locality_status_id']}'";
            echo "data-archive='{$value['archive']}' data-comment='{$value['comment']}' data-bptz17='{$value['bptz_younger_17']}' data-bptz1725='{$value['bptz_17_25']}' data-bptzAll='{$value['bptz_count']}'";
            echo "data-attended60='{$value['attended_older_60']}' data-attended17='{$value['attended_younger_17']}' data-attended1725='{$value['attended_17_25']}' data-attended25='{$value['attended_older_25']}'";
            echo "data-attendedAll='{$value['attended_count']}' data-meeting_average='{$value['lt_meeting_average']}' data-completed='{$value['status_completed']}'";
            echo "data-periods='{$value['period_start']} - {$value['period_end']}' data-id_statistic='{$value['id_statistic']}'";
            echo ">";
            // srting
            echo "<td>{$value['statistic_card_id']}</td><td>{$value['locality_name']}</td><td>{$value['status_name']}</td><td class='bptz_half_year'>{$value['bptz_count']}</td>";
            echo "<td class='attended_count'>{$value['attended_count']}</td><td class='lt_meeting_average'>{$value['lt_meeting_average']}</td>";
            echo "<td style='text-align: center;'>";
            if ($value == '1') {
              echo '<i class="fa fa-check" aria-hidden="true"></i>';
            }
            echo '</td></tr>';

            /*
            '<tr class="row-statistic" '+(item.status_completed == '1' ? 'style="background-color: lightgreen"' : '')+' '+dataString+'>'+
              '<td>'+item.statistic_card_id+'</td>' +
              '<td>'+item.locality_name+'</td>'+
              '<td><span>Крещены за полгода: '+item.bptz_count+'</span><br><span>Посещают собрания: '+item.attended_count+'</span><br><span>Кол. на трапезе: '+item.lt_meeting_average+'</span></td></tr>'
              */
            }
          ?>
          </tbody>
        </table>
      </div>
<!-- List Statistic STOP -->
