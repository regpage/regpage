<?php
// include
include_once "header2.php";
include_once "nav2.php";
// Переменные раздела
include_once "components/ftt_application_page/var_part.php";
?>

<div id="main_container" class="container-xl" style="margin-top: 60px; padding-top: 20px; padding-bottom: 20px; background-color: white;" data-id="<?php echo $request_data['fr_id']; ?>" data-guest="<?php echo $is_guest ?>" <?php echo $request_status ?>
  data-status="<?php echo $request_data['request_status']; ?>">

  <!-- специальные блоке (иконка загрузки, всплывающие подсказки) -->
  <?php include_once "components/ftt_application_page/special_part.php"; ?>

  <!-- БЛОК ЗАЯВЛЕНИЯ -->
  <?php include_once "components/ftt_application_page/wizard.php"; ?>

  <!-- Рекомендации, служащие и решения -->
  <?php if (!$applicant): ?>
  <?php include_once "components/ftt_application_page/service_part.php"; ?>
  <?php endif; ?>
</div>

<!-- Модальные окна -->
<?php include_once "components/ftt_application_page/modal_application_part.php"; ?>

<!-- JS -->
<?php include_once "components/ftt_application_page/js_part.php"; ?>

<?php
include_once "footer2.php";
?>
