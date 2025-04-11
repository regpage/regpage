<?php
// пути
$linkBlockBtn = "components/" . THIS_PAGE . "/{$ftt_access['group']}/{$tabOfSection}/btn_group.php";
$linkBlockListHeadings = "components/" . THIS_PAGE . "/{$ftt_access['group']}/{$tabOfSection}/list_headings.php";
$linkBlockListData = "components/" . THIS_PAGE . "/{$ftt_access['group']}/{$tabOfSection}/content.php";
// блоки
if (file_exists($linkBlockBtn)): ?>
  <div id="temp_btn_group" class="btn-group mb-2">
  <?php require_once $linkBlockBtn; ?>
  </div>
<?php endif; ?>
<?php if (file_exists($linkBlockListHeadings)): ?>
  <div id="temp_list_headings" class="row">
    <?php require_once $linkBlockListHeadings; ?>
  </div>
<?php endif; ?>
<?php if (file_exists($linkBlockListData)): ?>
  <div id="temp_list_body" class="container">
  <?php require_once $linkBlockListData; ?>
  </div>
<?php endif; ?>
