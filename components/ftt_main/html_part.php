<!-- Меню разделов ПВОМ-->
<?php
if ($ftt_access['group'] === 'staff' || $ftt_access['group'] === 'trainee') {
  include_once 'components/ftt_main/menu_nav_ftt.php';
}
?>
<!-- Основная страница разделов ПВОМ -->
<div id="main_container" class="container-xl" style="margin-top: 10px; padding-top: 20px; padding-bottom: 25px; background-color: white; max-width: 1170px;">
  <div id="main_row" class="row">
    <!-- Сделать одинаковый контент на всех страницах, в расписании сейчас иначе исполнено -->
    <div id="col-main-content" class="col" style="min-width: 350px;">
      <!-- Блоки разделов  -->
        <div id="ftt_sub_container" class="container tab-pane active" style="background-color: white; min-width: 350px; padding-left: 5px; padding-right: 5px;">
          <?php
          if ($thispage === 'ftt_schedule') {
            if ($ftt_access['staff_time_zone'] === '03') {
              ?>
              <p class="">Расписание будет включено позже.</p>
              <?php
              return;
            }
            if ($ftt_access['group'] === 'staff') {
              include_once 'components/ftt_schedule/staff_content_part.php';
              ?>
              <!--<br><br><a id="show_my_5_6" href="#show_my_5_6" style="margin-left: 20px;" title='Кликните по ссылке, что бы увидеть расписание.'>Расписание семестров 5-6</a>-->
              <?php
              //include_once 'components/ftt_schedule/staff_content_part_2.php';
            } elseif ($ftt_access['group'] === 'trainee') {
              include_once 'components/ftt_schedule/content_part.php';
            }
          } elseif ($thispage === 'ftt_announcement') {
            // REFACTORING Перенесено в новый файл
          } elseif ($thispage === 'ftt_attendance') {
            if ($ftt_access['group'] === 'staff') {
              include_once 'components/ftt_attendance/staff_content_part.php';
            } elseif ($ftt_access['group'] === 'trainee') {
              include_once 'components/ftt_attendance/content_part.php';
            }
          } elseif ($thispage === 'ftt_service') {
            // REFACTORING Разрабатывать в новом файле
          } elseif ($thispage === 'ftt_gospel') {
            if ($ftt_access['group'] === 'staff' || $ftt_access['group'] === 'trainee') {
              include_once 'components/ftt_gospel/staff_content_part.php';
            }/* elseif ($ftt_access['group'] === 'trainee') {
              include_once 'components/ftt_gospel/content_part.php';
            }*/
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
          }
          ?>
        </div>
    </div>
  </div>
</div>
<?php include_once 'components/ftt_main/modal_part.php'; ?>
