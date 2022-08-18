<!-- Меню разделов ПВОМ-->
<?php include_once 'components/ftt_main/menu_nav_ftt.php'; ?>
<!-- Основная страница разделов ПВОМ -->
<div id="main_container" class="container-xl" style="margin-top: 10px; padding-left: 20px; padding-bottom: 25px; background-color: white; max-width: 1170px;">
          <?php
          if ($_SERVER['REQUEST_URI'] === '/ftt_schedule') {
            if ($ftt_access['staff_time_zone'] === '03') {
              ?>
              <p class="">Расписание будет включено позже.</p>
              <?php
              return;
            }
            if ($ftt_access['group'] === 'trainee') {
              include_once 'components/ftt_schedule/content_part.php';
            } elseif ($ftt_access['group'] === 'staff') {
              include_once 'components/ftt_schedule/staff_content_part.php';
              ?>
              <br><br><a id="show_my_5_6" href="#show_my_5_6" style="margin-left: 20px;" title='Кликните по ссылке, что бы увидеть расписание.'>Расписание семестров 5-6</a>
              <?php
              include_once 'components/ftt_schedule/staff_content_part_2.php';
            }
          } elseif ($_SERVER['REQUEST_URI'] === '/ftt_announcement') {
            echo "В разработке.";
            //include_once 'components/ftt_announcement/content_part.php';
            // code...
          } elseif ($_SERVER['REQUEST_URI'] === '/ftt_attendance') {

            if ($ftt_access['group'] === 'trainee') {
              include_once 'components/ftt_attendance/content_part.php';
            } elseif ($ftt_access['group'] === 'staff') {
              include_once 'components/ftt_attendance/staff_content_part.php';
            }
          } elseif ($_SERVER['REQUEST_URI'] === '/ftt_service') {
            echo "В разработке.";
            //include_once 'components/ftt_service/content_part.php';
            // code...
          } elseif ($_SERVER['REQUEST_URI'] === '/ftt_gospel') {
            /*if ($ftt_access['group'] === 'staff') {*/
              include_once 'components/ftt_gospel/staff_content_part.php';
            /*} elseif ($ftt_access['group'] === 'trainee') {
              include_once 'components/ftt_gospel/content_part.php';
            }*/
            // code...
          } /*elseif ($_SERVER['REQUEST_URI'] === '/ftt_absence') {
            include_once 'components/ftt_attendance/content_part.php';
            // code...
          } */elseif ($_SERVER['REQUEST_URI'] === '/ftt_extrahelp') {
            if ($ftt_access['group'] === 'staff' || $serving_trainee) {
              include_once 'components/ftt_extra_help/staff_content_part.php';
            } elseif ($ftt_access['group'] === 'trainee') {
              // Добавить условие для служащих обучающихся продумать систему распилить строку и проверить в массиве ответствености
              include_once 'components/ftt_extra_help/content_part.php';
            }
          } elseif ($_SERVER['REQUEST_URI'] === '/ftt_list') {
              include_once 'components/ftt_list/content_part.php';
          }
          ?>
</div>
<?php include_once 'components/ftt_main/modal_part.php'; ?>
