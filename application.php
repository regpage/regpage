<?php
// include
require_once "preheader.php";
// Переменные раздела
require_once "components/ftt_application_page/var_part.php";
// main
require_once "header2.php";
require_once "nav2.php";
require_once "components/main/spinner.php";
?>

<div id="main_container" class="container-xl" style="margin-top: 60px; padding-top: 20px; padding-bottom: 20px; background-color: white;" data-id="<?php echo $request_data['id']; ?>" data-guest="<?php echo $is_guest ?>"
  data-status="<?php echo $request_data['stage']; ?>">

  <!-- специальные блоки (иконка загрузки, всплывающие подсказки) -->
  <?php require_once "components/ftt_application_page/special_part.php"; ?>

  <!-- БЛОК ЗАЯВЛЕНИЯ -->
  <?php require_once "components/ftt_application_page/wizard.php"; ?>

  <!-- Рекомендации, служащие и решения -->
  <?php if (!$applicant): ?>
  <?php require_once "components/ftt_application_page/service_part.php"; ?>
  <?php endif; ?>
</div>

<!-- Модальные окна -->
<?php require_once "components/ftt_application_page/modal_application_part.php"; ?>

<!-- JS -->
<?php require_once "components/ftt_application_page/js_part.php"; ?>

<?php
require_once "footer2.php";
?>
