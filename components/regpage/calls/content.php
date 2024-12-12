<div id="btns_flts_panel" class="row mb-3">
  <div class="btn-group">
    <button id="addCalls" class="btn btn-success btn-sm" type="button" title="Добавить новый звонок" data-toggle="modal" data-target="#modal_call_edit_add">
      <i class="fa fa-plus"></i> Добавить
    </button>
  </div>

    <select id="flt_localities" class="form-control form-control-sm ml-2">
      <?php FTT_Select_fields::rendering($callsUsersList, MEMBER_ID, 'Все'); ?>
    </select>

    <select id="flt_countries" class="form-control form-control-sm ml-2" value="">
        <?php FTT_Select_fields::rendering($callsCountryListQuick, '', 'Все'); ?>
        <option disabled>-----------</option>
        <?php FTT_Select_fields::rendering($callsCountryList, '', ''); ?>
    </select>

    <select id="flt_users" class="form-control form-control-sm ml-2" value="">
        <?php FTT_Select_fields::rendering($callsLocalityList, '', 'Все'); ?>
    </select>


</div>
<!-- заголовки колонок -->
<div class="row mb-2">
  <div class="col pl-1">
    <b class="sort_col" data-sort="m.name">ФИО <i class="<?php echo $sort_fio_ico ?>"></i></b>
  </div>
  <div class="col">
    <b class="sort_col" data-sort="c.locality">Местность <i class="<?php echo $sort_locality_ico ?>"></i></b>
  </div>
  <div class="col">
    <span>Телефон</span>
  </div>
  <div class="col">
    <b class="sort_col" data-sort="c.status">Статус <i class="<?php echo $sort_status_ico ?>"></i></b>
  </div>
  <div class="col">
    <b class="sort_col" data-sort="operator_name">Ответственный <i class="<?php echo $sort_operator_ico ?>"></i></b>
  </div>
</div>

<div class="row">
  <div class="calls_list container pt-2 pl-2">
  <?php foreach (CallsDB::getCalls('', '', $sort_setting[0], $sort_setting[1]) as $key => $value): ?>
    <div class="row call_str pl-1" data-id="<?php echo $value['id'] ?>" data-date="<?php echo $value['created_date'] ?>">
      <div class="col pl-0">
        <div class="">
          <?php echo $value['name'] ?>

        </div>
      </div>
      <div class="col">
        <div class="">
          <?php echo $value['locality'] ?>

        </div>
      </div>
      <div class="col">
        <div class="">
          <?php echo $value['phone'] ?>

        </div>
      </div>
      <div class="col">
        <div class="">
          <span class="badge badge-secondary"><?php echo $value['status'] ?></span>
        </div>
      </div>
      <div class="col">
        <div class="">
          <?php echo short_name::short($value['operator_name']) ?>

        </div>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</div>
