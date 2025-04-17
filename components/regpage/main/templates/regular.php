<?php
// пути
$linkBlockBtn = "components/regpage/" . THIS_PAGE . "/user/{$tabOfSection}/btn_group.php";
$linkBlockListHeadings = "components/regpage/" . THIS_PAGE . "/user/{$tabOfSection}/list_headings.php";
$linkBlockListData = "components/regpage/" . THIS_PAGE . "/user/{$tabOfSection}/content.php";

// блоки
if (file_exists($linkBlockBtn)): ?>
  <br>
  <div id="temp_btn_group" class="btn-group mb-2">
  <?php require_once $linkBlockBtn; ?>
  </div>
<?php endif; ?>
<?php if (file_exists($linkBlockListHeadings)): ?>
  <div id="temp_list_headings" class="row font-weight-bold pl-1">
    <?php require_once $linkBlockListHeadings; ?>
  </div>
  <hr class="mt-1 mb-1" style="margin-left: -1px; margin-right: -1px;">
<?php endif; ?>
<?php if (file_exists($linkBlockListData)): ?>
  <div id="temp_list_body" class="container pl-0 pr-0">
  <?php require_once $linkBlockListData; ?>
  </div>
<?php endif; ?>
