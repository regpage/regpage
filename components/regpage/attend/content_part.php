<div class="row" style="margin-bottom: 19px;">
  <!-- Список подразделов -->
  <select id="members-lists-combo" class="form-control form-control-sm mr-2" tooltip="Выберите нужный вам список здесь" style="max-width: 468px;">
    <option value="members">Общий список</option>
    <option value="attend" selected>Список посещаемости</option>
    <option value="youth">Молодые люди</option>
    <option value="list">Ответственные за регистрацию</option>
    <?php if ($roleThisAdmin===2) { ?>
      <option value="activity">Активность ответственных</option>
    <?php } ?>
  </select>
  <input type="search" id="field_search_text" class="form-control form-control-sm" placeholder="Поиск по фамилии" style="max-width: 468px;">
</div>
<div class="row mb-3">
  <!--<div class="btn-group">
    <a class="btn btn-success add-member" data-locality="001013" type="button"><i class="fa fa-plus icon-white"></i> <span class="hide-name">Добавить</span></a>
  </div>
  <div class="btn-group">
    <a class="btn dropdown-toggle btnDownloadMembers" data-toggle="dropdown" href="#">
      <i class="fa fa-download"></i> <span class="hide-name">Скачать</span>
    </a>
  </div>
  <div class="btn-group">
    <a class="btn dropdown-toggle btnShowStatistic" data-toggle="dropdown" href="#">
      <i class="fa fa-bar-chart"></i> <span class="hide-name">Статистика</span>
    </a>
  </div>
  <div class="btn-group" style="display: none;">
    <a id="" class="btn" type="button">
      <i class="fa fa-sort"></i>
    </a>
  </div>
  <?php // if (!$singleCity): ?>
  <div class="">
    <button id="btn_show_custom_filters" type="button" class="btn btn-primary btn-sm rounded mr-2">
      <i class="fa fa-filter icon-white"></i>
      <span class="hide-name">Фильтры</span>
    </button>
  <?php // endif; ?>
  </div>-->
  <?php if (!$singleCity): ?>
  <div class="mr-2">
    <select id="flt_members_localities" class="form-control form-control-sm">
      <?php FTT_Select_fields::rendering($adminLocalitiesList, '_all_', 'Все местности'); ?>
    </select>
  </div>
  <?php endif; ?>
  <div class="mr-2">
    <select id="flt_members_category" class="form-control form-control-sm">
      <?php
      $memberCategoriesFilter = [];
      foreach (MemberProperties::get_categories() as $key => $value) {
        $memberCategoriesFilter[$key] = $value;
        if ($key === 'FT') {
          $memberCategoriesFilter['NF'] = 'Без обучающихся ПВОМ';
        }
      }
      FTT_Select_fields::rendering($memberCategoriesFilter, '_all_', 'Все участники'); ?>
    </select>
  </div>
  <div class="mr-2">
  	<select id="flt_members_attend" class="form-control form-control-sm">
      <option value="_all_">Все участники</option>
  		<option value="1">Посещают Господню трапезу</option>
      <option value="2">Посещают молитвенные собрания</option>
      <option value="3">Посещают групповые собрания</option>
      <option value="4">Посещают другие собрания</option>
      <option value="5">Посещают какие-либо собрания</option>
      <option value="6">Участвуют в видеообучении</option>
      <option value="0">Не посещают собрания</option>
  	</select>
  </div>
  <div class="mr-2">
    <div class="dropdown">
      <button type="button" class="btn btn-light btn-sm rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-print"></i>
        <i class="fa fa-caret-down" aria-hidden="true"></i>
      </button>
      <div class="dropdown-menu">
        <button id="btnPrintOpenModal" class="dropdown-item" type="button">Таблица посещаемости</button>
        <button id="btnPrintOpenModalBlank" class="dropdown-item" type="button">Таблица посещаемости (бланк)</button>
        <button id="btnPrintOpenModalControlListVT" class="dropdown-item" type="button">Контрольный список ВО</button>
        <button id="btnPrintOpenModalControlListVTBlank" class="dropdown-item" type="button">Контрольный список ВО (бланк)</button>
        <button id="btnPrintOpenModalBadgesVT" class="dropdown-item" type="button">Значки для Видеообучения</button>
        <button id="btnPrintOpenModalVT" class="dropdown-item" type="button">Список участников Видеообучения</button>
      </div>
    </div>
  </div>
</div>
<div id="col_name" class="row mb-2">
  <div class="col-3 pl-1">
    <b class="sort_col" data-sort="name">ФИО <i class="<?php echo $sort_fio_ico; ?>"></i></b>
  </div>
  <?php if (!$singleCity): ?>
  <div class="col-2">
    <b class="sort_col" data-sort="locality">Город <i class="<?php echo $sort_locality_ico; ?>"></i></b>
  </div>
  <?php endif; ?>
  <div class="col-1 m_width_check" title="Собрания Господней трапезы"><b>Т</b></div>
  <div class="col-1 m_width_check" title="Молитвенные собрания" style="padding-left: 13px;"><b>М</b></div>
  <div class="col-1 m_width_check" title="Групповые собрания" style="padding-left: 15px;"><b>Г</b></div>
  <div class="col-1 m_width_check" title="Другие виды собраний" style="padding-left: 15px;"><b>Д</b></div>
  <div class="col-1 m_width_check" title="Собрания видеообучения" style="padding-left: 15px;"><b>В</b></div>
  <div class="col-1" title="Комментарий" style="min-width: 220px; padding-left: 10px;"><b>Коммент</b></div>
  <div class="col-1" style="padding-left: 10px;" title="Возраст">
    <b class="sort_col" data-sort="age">Возраст <i class="<?php echo $sort_birth_date_ico; ?>"></i></b>
  </div>
</div>
<div class="row">
  <div id="attend_list" class="container pl-2">
    <?php
    //print_r($membersList);
     foreach ($membersList as $key => $value):
      // print_r($value);
       ?>
      <div class="row attend_str pl-1" data-member_key="<?php echo $value->id; ?>"
        data-locality_key="<?php echo $value->locality_key; ?>"
        data-category_key="<?php echo $value->category_key; ?>">
        <div class="col-3 pl-0">
          <span class="data_name"><?php echo $value->name; ?></span>
          <?php if (in_array(5, $userSettings)): ?>
            <br>
            <span class="grey_text"><?php echo $value->category_name; ?></span>
          <?php endif; ?>
        </div>
        <?php if (!$singleCity): ?>
        <div class="col-2">
          <?php echo $value->locality; ?>
        </div>
        <?php endif; ?>
        <div class="col-1 m_width_check">
          <input type="checkbox" data-field="attend_meeting" <?php if ($value->attend_meeting) echo 'checked'; ?>>
        </div>
        <div class="col-1 m_width_check">
          <input type="checkbox" data-field="attend_pm" <?php if ($value->attend_pm) echo 'checked'; ?>>
        </div>
        <div class="col-1 m_width_check">
          <input type="checkbox" data-field="attend_gm" <?php if ($value->attend_gm) echo 'checked'; ?>>
        </div>
        <div class="col-1 m_width_check">
          <input type="checkbox" data-field="attend_am" <?php if ($value->attend_am) echo 'checked'; ?>>
        </div>
        <div class="col-1 m_width_check">
          <input type="checkbox" data-field="attend_vt" <?php if ($value->attend_vt) echo 'checked'; ?>>
        </div>
        <div class="col-1 pl-1 pr-1" style="min-width: 220px;">
          <i class="fa fa-comment pl-2" <?php if ($value->at_comment) echo "style='display: none;'"; ?>></i>
          <input maxlength="25" type="text" class="form-control form-control-sm vt_comment_field"
          value="<?php echo $value->at_comment; ?>"
          title="<?php if($value->editors) echo "Редактор ".short_name::short(Member::get_name($value->editors)); ?>"
          style="display: none;" data-field="comment" data-editors="<?php echo $value->editors; ?>">
          <span class="vt_comment_text" <?php if (!$value->at_comment) echo "style='display: none;'"; ?>><?php echo $value->at_comment; ?></span>
        </div> <!-- style="display: none;" -->
        <div class="col-1">
          <span class="data_age">
          <?php
          if ($value->age == 0) {
            echo "-";
          } else {
            echo floor($value->age);
          }
          ?>
          </span>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
