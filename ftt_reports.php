<?php
include_once "header2.php";
include_once "nav2.php";
include_once "db/ftt_db.php";

// Проверка прав пользователя.
// служащий ПВОМ
$accessToPage = 0;
// Права
include_once "db/modules/ftt_reports_access.php";

if($accessToPage > 0) { //!$hasMemberRightToSeePage &&
  // всем привет!
} else {
  echo '<h1 style="margin-top: 70px; margin-left: 70px;">Пожалуйста, выберите другой раздел.</h1>';
  die();
}

$member_categories = db_getCategories();

?>

<div class="container" style="margin-top: 60px; padding-top: 20px; background-color: white;">
  <!-- Nav tabs -->

</div>
<div class="tab-content">
<!-- TAB APPLICATION CONTAINER -->
  <?php // include_once 'components/ftt_reports/.php'; ?>


<!-- TAB ATTENDANCE CONTAINER -->
   <?php // include_once "components/ftt_reports/.php"; ?>

<!-- TAB OTHER CONTAINER -->
   <?php // include_once "components/ftt_reports/.php"; ?>
</div>
<script>
  let data_page = {};
  // get admin ID
  data_page.admin_id = <?php echo $memberId; ?>;
  // get members category
  data_page.category = {
  <?php foreach ($member_categories as $key => $value) { ?>
    "<?php echo $key; ?>":"<?php echo $value; ?>",
  <?php } ?>
};
</script>

<script src="/js/ftt_reports.js?v1"></script>

<?php
include_once "footer2.php";
?>
