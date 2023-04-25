<?php
include_once 'components/ftt_application_list/var_part.php';
if($accessToPage > 0) { //!$hasMemberRightToSeePage &&

} else {
  echo '<h1 style="margin-top: 70px; margin-left: 70px;">Пожалуйста, выберите другой раздел.</h1>';
  die();
}

$member_categories = db_getCategories();

?>
<!-- Меню разделов ПВОМ-->
<?php include_once 'components/ftt_main/menu_nav_ftt.php'; ?>
<!-- раздел заявлений на ПВОМ -->
<div class="container-xl" style="max-width: 1170px; margin-top: 10px; padding-bottom: 10px; background-color: white;">

  <div class="" style="padding-top: 20px;">
  <!-- TAB APPLICATION CONTAINER -->
    <?php include_once 'components/ftt_application_list/applications_part.php'; ?>
  </div>
</div>

<?php
include_once "components/ftt_application_list/js_part.php";
include_once "footer2.php";
?>
