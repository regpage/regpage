<?php
$modalTitle = 'Пророчество';
$modalButtons = '<button type="button" id="mdl_edit_btn_send_md" type="button" class="btn btn-primary btn-sm ml-1">Отправить</button>';

$modalSection = "components/" . THIS_PAGE . "/modals.php";
/*
$modalSection = "components/" . THIS_PAGE . "/{$ftt_access['group']}/{$tabOfSection}/modal.php";
$modalSectionCtrl = "components/" . THIS_PAGE . "/{$ftt_access['group']}/{$tabOfSection}/modal_ctrl.php";

if (file_exists($modalsExtra)) {
  require_once $modalsExtra;
}
*/
?>

<?php require_once 'components/ftt_main/templates/modal.php'; ?>
