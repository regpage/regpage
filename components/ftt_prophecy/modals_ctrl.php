<?php
// окно редактирования пророчество
$modalTitle = 'Пророчество';
$modalButtons = '<button type="button" id="mdl_edit_btn_send_md" type="button" class="btn btn-primary btn-sm ml-1">Отправить</button>';
$idMlodal = '';
$modalSection = "components/" . THIS_PAGE . "/modals.php";
require 'components/ftt_main/templates/modal.php';
// окно статистики
require 'components/ftt_prophecy/staff/tab_default/modal_statistics.php';
// окно с фильтрами
$modalSectionFlt = "components/" . THIS_PAGE . "/staff/tab_default/modal_flt.php";
require 'components/ftt_main/templates/modal_flt.php';
