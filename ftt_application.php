<?php
include_once "header2.php";
include_once "nav2.php";
include_once "db/ftt_db.php";

// Проверка прав пользователя.
// служащий ПВОМ
$accessToPage = 0;
// Права
include_once "db/modules/ftt_page_access.php";

if($accessToPage > 0) { //!$hasMemberRightToSeePage &&
  // всем привет!
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
  <!-- Nav tabs -->
  <ul class="nav nav-tabs">
    <li class="nav-item" style="padding-right: 20px;">
      <h3>Заявления для участия в обучении</h3>
    </li>
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#list_requests">Заявление</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#list_attendance">Посещаемость</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#list_others">Прочее</a>
    </li>
  </ul>
  <div class="tab-content" style="padding-top: 20px;">
  <!-- TAB APPLICATION CONTAINER -->
    <?php include_once 'components/ftt_page/applications_part.php'; ?>


  <!-- TAB ATTENDANCE CONTAINER -->
     <?php include_once "components/ftt_page/attendance_part.php"; ?>

  <!-- TAB OTHER CONTAINER -->
     <?php include_once "components/ftt_page/other_part.php"; ?>
  </div>
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

<script src="/js/ftt.js?v1"></script>

<?php
include_once "footer2.php";
?>
