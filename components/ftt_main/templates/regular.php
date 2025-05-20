<?php
// пути
$linkBlockBtn = "components/" . THIS_PAGE . "/{$ftt_access['group']}/{$tabOfSection}/btn_group.php";
$linkBlockListHeadings = "components/" . THIS_PAGE . "/{$ftt_access['group']}/{$tabOfSection}/list_headings.php";
$linkBlockListData = "components/" . THIS_PAGE . "/{$ftt_access['group']}/{$tabOfSection}/content.php";
$linkCtrlBlockListData = "components/" . THIS_PAGE . "/{$ftt_access['group']}/{$tabOfSection}/ctrl.php";
// блоки
if (file_exists($linkCtrlBlockListData)) {
  require_once $linkCtrlBlockListData;
}
if (file_exists($linkBlockBtn)): ?>
  <br>
  <div id="temp_btn_group" class="btn-group mb-2">
  <?php require_once $linkBlockBtn; ?>
  </div>
<?php endif; ?>
<?php if (file_exists($linkBlockListHeadings)): ?>
  <div id="temp_list_headings" class="row font-weight-bold pl-1 mr-0 d-none d-md-flex">
    <?php require_once $linkBlockListHeadings; ?>
  </div>
  <hr class="mt-1 mb-0" style="margin-left: -1px; margin-right: -1px;">
<?php endif; ?>
<?php if (file_exists($linkBlockListData)): ?>
  <div id="temp_list_body" class="container px-0">
  <?php require_once $linkBlockListData; ?>
  </div>
<?php endif; ?>
