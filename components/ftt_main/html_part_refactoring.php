<!-- Меню разделов ПВОМ-->
<?php
if ($ftt_access['group'] === 'staff' || $ftt_access['group'] === 'trainee') {
  include_once 'components/ftt_main/menu_nav_ftt.php';
}
?>
<!-- Основная страница разделов ПВОМ -->
<div id="main_container" class="container-xl" style="margin-top: 10px; padding-left: 20px; padding-bottom: 25px; background-color: white; max-width: 1170px;">
          <?php
          if ($thispage === 'ftt_schedule') {
            if ($ftt_access['group'] === 'staff') {
              include_once 'components/ftt_schedule/staff_content_part.php';
            } elseif ($ftt_access['group'] === 'trainee') {
              include_once 'components/ftt_schedule/content_part.php';
            }
          } elseif ($thispage === 'ftt_announcement') {
            if ($ftt_access['group'] === 'staff') {
              // HTML страница для служащих
              include_once 'components/ftt_announcement/staff_content_part.php';
            } elseif ($ftt_access['group'] === 'trainee') {
              // HTML страница для обучающихся
              include_once 'components/ftt_announcement/content_part.php';
            }
            // HTML модальные окна страниц
            include_once "components/ftt_announcement/modals_part.php";
          } elseif ($thispage === 'ftt_attendance') {
            if ($ftt_access['group'] === 'staff') {
              include_once 'components/ftt_attendance/staff_content_part.php';
            } elseif ($ftt_access['group'] === 'trainee') {
              include_once 'components/ftt_attendance/content_part.php';
            }
          } elseif ($thispage === 'ftt_service') {
            echo "В разработке.";
            //include_once 'components/ftt_service/content_part.php';
            // code...
          } elseif ($thispage === 'ftt_gospel') {
            include_once 'components/ftt_gospel/staff_content_part.php';
            // code...
          } elseif ($thispage === 'ftt_gospel_statistic') {
            include_once 'components/ftt_gospel/stat_content_part.php';
            // code...
          } /*elseif ($_SERVER['REQUEST_URI'] === '/ftt_absence') {
            include_once 'components/ftt_attendance/content_part.php';
            // code...
          } */elseif ($thispage === 'ftt_extrahelp') {
            if ($ftt_access['group'] === 'staff' || $serving_trainee) {
              include_once 'components/ftt_extra_help/staff_content_part.php';
            } elseif ($ftt_access['group'] === 'trainee') {
              // Добавить условие для служащих обучающихся продумать систему распилить строку и проверить в массиве ответствености
              include_once 'components/ftt_extra_help/content_part.php';
            }
          } elseif ($thispage === 'ftt_list') {
            if ($ftt_access['group'] === 'staff') {
              include_once 'components/ftt_list/content_part.php';
            }
          } elseif ($thispage === 'ftt_fellowship') {
            if ($ftt_access['group'] === 'staff') {
              include_once 'components/ftt_fellowship/content_part_staff.php';
            } elseif ($ftt_access['group'] === 'trainee') {
              include_once 'components/ftt_fellowship/content_part.php';
            }
          } elseif ($thispage === 'ftt_reading') {            
            include_once 'components/ftt_reading/content_part.php';
          }
          ?>
</div>
<?php include_once 'components/ftt_main/modal_part.php'; ?>
