<div id="list_requests" class="container tab-pane active" style="background-color: white;" data-role="<?php echo $accessToPage; ?>">
<!-- МЕНЮ СПИСКА ЗАЯВЛЕНИЙ -->
<?php // include_once 'menu_applications_part.php'; ?>
  <!-- Кнопки и фильтры -->
  <div class="row btn-group mb-2 mr-2">
    <div class="">
      <button type="button" class="btn btn-sm btn-primary mr-3" data-toggle="modal" data-target="#modal_dlt_add_new_application">
        Добавить заявление
      </button>
    </div>
    <div class="">
      <select id="flt_allow_deny" class="form-control form-control-sm">
        <option value="_all_">Все</option>
        <option value="badge-success">принят</option>
        <option value="badge-danger">отклонён</option>
      </select>
    </div>
  </div>
  <!-- Список заявлений -->
  <!-- К А Н Д И Д А Т Ы -->
  <div class="row align-center"><div class="col mr-1 pl-1"><h3>Кандидаты</h3></div></div>
  <div id="header_candidate" class="row mb-1">
    <div class="col-3 cursor-pointer text_blue pl-1">
      <b class="sort_fio">ФИО <i class="<?php echo $sort_fio_ico; ?>"></i>
      </b>
    </div>
    <div class="col cursor-pointer text_blue">
      <b class="sort_locality">Местность <i class="<?php echo $sort_locality_ico; ?>"></i>
      </b>
    </div>
    <div class="col"><b>Телефон</b></div>
    <div class="col-2"><b>Статус</b></div>
    <div class="col-2"><b>Решение</b></div>
    <!--<div class="col-1">X</div>-->
  </div>
  <div id="requests-list" class="">
   <span>З А Г Р У З К А</span>
  </div>

  <!-- Г О С Т И -->
  <div class="row"><div class="col pl-1 mt-3"><h3>Гости</h3></div></div>
  <div id="header_guest" class="row mb-1">
    <div class="col-3 cursor-pointer text_blue pl-1">
      <b class="sort_fio">ФИО <i class="<?php echo $sort_fio_g_ico; ?>"></i>
      </b>
    </div>
    <div class="col cursor-pointer text_blue">
      <b class="sort_locality">Местность <i class="<?php echo $sort_locality_g_ico; ?>"></i>
      </b>
    </div>
    <div class="col"><b>Телефон</b></div>
    <div class="col-2"><b>Статус</b></div>
    <div class="col-2"><b>Решение</b></div>
    <!--<div class="col-1">X</div>-->
  </div>
  <div id="requests-guest-list"><span>З А Г Р У З К А</span></div>
</div>
<?php require_once 'components/ftt_application_list/modal_part.php'; ?>
