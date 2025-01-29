<!-- Вкладки -->
<div class="row mb-3">
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_incomming_active; ?>" data-toggle="tab" href="#" data-tab_name="incomming">
        Входящие<sup class="text-danger"><?php echo $indexTabIncomming; ?></sup>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_currents_active; ?>" data-toggle="tab" href="#" data-tab_name="currents">
         В работе<sup class="text-danger"><?php echo $indexTabInWork; ?></sup>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_finished_active; ?>" data-toggle="tab" href="#" data-tab_name="finished">
         Завершённые
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo $tab_statistics_active; ?>" data-toggle="tab" href="#" data-tab_name="statistics">
        Статистика
      </a>
    </li>
  </ul>
</div>
<!-- Фильтры и кнопки -->
<div id="btns_flts_panel" class="row mb-3">
  <div class="btn-group">
    <?php if ($tabCalls === 'incomming'): ?>
      <button id="addCalls" class="btn btn-success btn-sm mr-2" type="button" title="Добавить новый звонок" data-toggle="modal" data-target="#modal_call_edit_add">
        <i class="fa fa-plus"></i> <span class="d-none d-md-inline">Новая заявка</span>
      </button>
    <?php endif; ?>
    <button class="btn btn-primary btn-sm mr-2 d-md-none" type="button" data-toggle="modal" data-target="#mdl_mbl_flt">
      <i class="fa fa-filter"></i>
    </button>
    <?php if ($tabCalls !== 'statistics'): ?>
    <button class="btn btn-primary btn-sm mr-2 d-md-none" type="button" data-toggle="modal" data-target="#mdl_mbl_sort">
      <i class="fa fa-sort"></i>
    </button>
    <?php endif; ?>
  </div>
  <?php if ($tabCalls !== 'statistics'): ?>
    <select id="flt_author" class="form-control form-control-sm mr-2 d-none d-md-block">
      <?php FTT_Select_fields::rendering($callsUsersList, $fltAuthor, 'Все администраторы'); ?>
    </select>
  <?php endif; ?>
    <?php if ($tabCalls !== 'incomming' && $tabCalls !== 'statistics'): ?>
      <select id="flt_operator" class="form-control form-control-sm mr-2 d-none d-md-block">
        <?php FTT_Select_fields::rendering($callsUsersList, $fltOperator, 'Все операторы'); ?>
      </select>
    <?php endif; ?>
    <?php if ($tabCalls === 'incomming'): // $callsUserData['male'] === '1' ?>
      <select id="flt_gender" class="form-control form-control-sm mr-2 d-none d-md-block">
      <?php FTT_Select_fields::rendering(['1'=>'муж.', '0'=>'жен.'], $fltGender, 'Все'); ?>
      </select>
    <?php endif; ?>
    <?php if ($tabCalls === 'statistics'): ?>
      <select id="flt_all_users" class="form-control form-control-sm mr-2 d-none d-md-block">
        <?php FTT_Select_fields::rendering($callsUsersList, $fltAllUsers, 'Все'); ?>
      </select>
      <span class="pt-1 pr-2 pl-1 d-none d-md-inline">с </span>
      <input type="date" id="flt_date_begin" class="form-control form-control-sm mr-2 d-none d-md-block" value="<?php echo $dateBegin ?>" min="2025-01-01" max="<?php echo date('Y-m-d') ?>">
      <span class="pt-1 pr-2 d-none d-md-inline">по </span>
      <input type="date" id="flt_date_end" class="form-control form-control-sm mr-2 d-none d-md-block" value="<?php echo $dateEnd ?>" min="2025-01-01" max="<?php echo date('Y-m-d') ?>">
    <?php endif; ?>
    <!--<input type="search" id="flt_search" class="form-control form-control-sm ml-2" value="<?php echo urldecode($fltSearch); ?>">
    <div class="input-group-append">-->
    <?php if ($tabCalls !== 'statistics'): ?>
      <button type="button" id="btn_search_mdl_show" class="btn btn-success btn-sm" data-toggle="modal" data-target="#mld_search"><i class="fa fa-search"></i></button>
    <?php endif; ?>
    <!-- </div> -->
</div>
<!-- список фильтров  -->
<div class="row pl-0">
  <strong id="flt_list" class="text-danger"></strong>
</div>
<?php if ($tabCalls !== 'statistics'): ?>
<!-- заголовки колонок -->
<div class="row pb-2 mr-0 border-bottom d-none d-sm-flex">
  <div class="col-1 pl-0">
    <b class="sort_col" data-sort="c.created_date">Дата <i class="<?php echo $sort_created_date_ico ?>"></i></b>
  </div>
  <div class="col-2 pl-3">
    <b>Телефон</b>
  </div>
  <div class="col-3 pl-3">
    <b class="sort_col" data-sort="c.name">ФИО <i class="<?php echo $sort_fio_ico ?>"></i></b>
  </div>
  <div class="col-4 pl-3">
    <b>Комментарий</b>
  </div>
  <div class="col-2 pl-3">
    <b></b>
  </div>
</div>
<?php endif; ?>
<?php
if ($tabCalls === 'currents') {
  // вкладка текущие
  require_once 'components/regpage/calls/content_currents.php';
} elseif ($tabCalls === 'finished') {
  // вкладка завершённые
  require_once 'components/regpage/calls/content_finished.php';
} elseif ($tabCalls === 'statistics') {
  // вкладка статистика
  require_once 'components/regpage/calls/content_statistics.php';
} else {
  // вкладка входящие
  require_once 'components/regpage/calls/content_incomming.php';
}
