<!-- Churches statistic -->
<div class="container">
  <div id="eventTabs" class="meetings-list">
    <div class="tab-content">
<!-- Botton bar Statistic START -->
      <div class="btn-toolbar">
          <a class="btn btn-success add-statistic" type="button"><i class="fa fa-plus icon-white"></i><span class="hide-name"> Добавить</span></a>
          <div class="dropdown">
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
          <select id="fulfilledBlank" class="span2" style="margin-right: 10px;">
              <option value="_all_" selected>Все бланки</option>
              <option value="1">Заполненные</option>
              <option value="0">Не заполненные</option>
          </select>

          <?php if (!$isSingleCity) { ?>
          <select id="selStatisticLocality" class="span3" style="margin-right: 10px;">
              <option value='_all_' <?php echo $selStatisticLocality =='_all_' ? 'selected' : '' ?> >Все местности (районы)</option>
              <?php
                  foreach ($localities as $id => $name) {
                      echo "<option value='$id' ". ($id==$selStatisticLocality ? 'selected' : '') ." >".htmlspecialchars ($name)."</option>";
                  }
              ?>
          </select>
          <?php } ?>

          <select class="custom-select" multiple id="arhivePeriods" style="width: 255px;" size="3">
            <?php
                foreach ($allPeriods as $key => $name) {
                    echo "<option value='$key'>".$key.'  ('.htmlspecialchars ($name).")</option>";
                }
            ?>
          </select>

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
          <tbody><tr><td colspan="8"><h3 style="text-align: center">Загрузка...</h3></td></tr></tbody>
        </table>
      </div>
      <div class="show-phone" id="statisticListMbl">
        <table id="meetingsPhone" class="table table-hover">
          <tbody><tr><td colspan="8"><h3 style="text-align: center">Загрузка...</h3></td></tr></tbody>
        </table>
      </div>
<!-- List Statistic STOP -->
    </div>
  </div>
</div>
