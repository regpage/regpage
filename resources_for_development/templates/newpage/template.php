<?php
require_once "preheader.php";
include_once "header2.php";
include_once "nav2.php";

$hasMemberRightToSeePage = db_isAdmin($memberId);
if(!$hasMemberRightToSeePage){
    die();
}

?>

<div class="container" style="margin-top: 60px; padding-top: 20px; background-color: white;">
  <div class="row">
    <div class="btn-group col-12">
      <button type="button" class="btn btn-primary">Button 1</button>
    </div>
  </div>
  <div class="row">
    <div id="ftt-request" class="col-12">
      <p>Some content should be here</p>
    </div>
  </div>
</div>

<script>
</script>

<script src="js/template.js?v1"></script>

<?php
include_once "footer2.php";
?>
