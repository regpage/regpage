<div class="row mb-3">
  <!-- Список подразделов -->
  <select class="form-control form-control-sm members-lists-combo mr-2" tooltip="Выберите нужный вам список здесь" style="max-width: 468px;">
    <option value="members">Общий список</option>
    <option value="attend" selected>Список посещаемости</option>
    <option value="youth">Молодые люди</option>
    <option value="list">Ответственные за регистрацию</option>
    <?php if ($roleThisAdmin===2) { ?>
      <option value="activity">Активность ответственных</option>
    <?php } ?>
  </select>
  <input type="search" id="field_search_text" class="form-control form-control-sm" placeholder="Поиск по фамилии" style="max-width: 468px; margin-bottom: 10px;">
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
  <div class="btn-group">
    <a id="btnPrintOpenModal" class="btn dropdown-toggle" href="#">
      <i class="fa fa-print"></i>
    </a>
  </div>
  <div class="btn-group">
    <a class="btn btn-info show-filters" type="button">
      <i class="fa fa-filter icon-white"></i>
      <span class="hide-name">Фильтры</span>
    </a>
  </div>
  <div class="btn-group" style="display: none;">
    <a id="" class="btn" type="button">
      <i class="fa fa-sort"></i>
    </a>
  </div>-->
  <div class="btn-group">
    <select id="flt_members_localities" class="form-control form-control-sm mr-2">
      <?php FTT_Select_fields::rendering(localities::getAdminLocalities($memberId), '_all_', 'Все местности'); ?>
    </select>
  </div>
  <div class="btn-group">
    <select id="flt_members_category" class="form-control form-control-sm mr-2">
      <?php FTT_Select_fields::rendering(MemberProperties::get_categories(), '_all_', 'Все участники'); ?>
    </select>
  </div>
  <div class="btn-group">
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
</div>
<div class="row mb-2">
  <div class="col-3 pl-1">
    <b class="sort_col" data-sort="name">ФИО <i class="<?php echo $sort_fio_ico; ?>"></i></b>
  </div>
  <div class="col-3">
    <b class="sort_col" data-sort="locality">Город <i class="<?php echo $sort_locality_ico; ?>"></i></b>
  </div>
  <div class="col-1" title="Собрания Господней трапезы"><b>Т</b></div>
  <div class="col-1" title="Молитвенные собрания" style="padding-left: 13px;"><b>М</b></div>
  <div class="col-1" title="Групповые собрания" style="padding-left: 13px;"><b>Г</b></div>
  <div class="col-1" title="Другие виды собраний" style="padding-left: 12px;"><b>Д</b></div>
  <div class="col-1" title="Собрания видеообучения" style="padding-left: 10px;"><b>В</b></div>
  <div class="col-1" style="padding-left: 10px;">
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
          <br>
          <span class="grey_text"><?php echo $value->category_name; ?></span>
        </div>
        <div class="col-3">
          <?php echo $value->locality; ?>
        </div>
        <div class="col-1">
          <input type="checkbox" data-field="attend_meeting" <?php if ($value->attend_meeting) echo 'checked'; ?>>
        </div>
        <div class="col-1">
          <input type="checkbox" data-field="attend_pm" <?php if ($value->attend_pm) echo 'checked'; ?>>
        </div>
        <div class="col-1">
          <input type="checkbox" data-field="attend_gm" <?php if ($value->attend_gm) echo 'checked'; ?>>
        </div>
        <div class="col-1">
          <input type="checkbox" data-field="attend_am" <?php if ($value->attend_am) echo 'checked'; ?>>
        </div>
        <div class="col-1">
          <input type="checkbox" data-field="attend_vt" <?php if ($value->attend_vt) echo 'checked'; ?>>
        </div>
        <div class="col-1">
          <?php
          if ($value->age == 0) {
            echo "-";
          } else {
            echo floor($value->age);
          }
          ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
