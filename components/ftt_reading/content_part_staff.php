<!-- ЧТЕНИЕ БИБЛИИ -->
<!-- СОЗДАТЬ ФОРМУ И СПИСОК КНИГ
ФОРМУ ДОБАВИТЬ В БЛАНК И КНОПКУ СТАРТА
ЕСЛИ ТЕКУЩИЙ БЛАНК НЕ ЗАПОЛНЕН СОВСЕМ ПРОВЕРЯТЬ БЫЛ ЛИ СТАРТ И ОТ ЭТОГО ЗАПОЛНЯТЬ
-->
<?php
require_once  '../private/vendor/autoload.php'; //ROOT_PATH .
use App\Infrastructure\Database\DbQuery;
$dbConnect = new DbQuery($db);
use App\Repositories\Ftt\Reading\FttReadingReadRepository;
use App\Repositories\Ftt\Reading\FttReadingWriteRepository;
use App\Repositories\Ftt\Roster\FttRosterRepository;

use App\Services\Ftt\Reading\FttReadingProgressService;
use App\Services\Ftt\Roster\FttRosterService;

$rosterRepository = new FttRosterRepository($dbConnect);
$rosterService = new FttRosterService($rosterRepository);

if (!empty($_COOKIE['flt_serving_one_read'])) {
  $flt_sevice_one_read = $_COOKIE['flt_serving_one_read'];
} else {
  $flt_sevice_one_read = $memberId;
}
if (!empty($_COOKIE['flt_semester_read'])) {
  $fltSemesterRead = $_COOKIE['flt_semester_read'];
} else {
  $fltSemesterRead = '_all_';
}
?>
<div class="container">
  <br>
  <div id="" class="row mb-2">
    <div class="col-4 col-md-2 pl-0 pr-2">
      <select id="read_sevice_one_select" class="form-control form-control-sm" data-cookie="flt_serving_one_read">
        <?php FTT_Select_fields::rendering($serving_ones_list, $flt_sevice_one_read, 'Все служащие') ?>
      </select>
    </div>
    <div class="col-4 col-md-2 pl-0 pr-2">
      <select id="read_semester_select" class="form-control form-control-sm" data-cookie="flt_semester_read">
        <?php FTT_Select_fields::rendering(['1_2'=>'Семестры 1-2','3_4'=>'Семестры 3-4','5_6'=>'Семестры 5-6'], $fltSemesterRead, 'Все семестры') ?>
      </select>
    </div>
    <div class="col-2 pl-0 pr-2">
      <button id="show_mdl_bible_statistic_semester" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mdl_bible_statistic_semester">Статистика</button>
    </div>
  </div>
</div>
<hr class="m-0">
<div id="list_readin_bible" class="container">
    <div class="row">
    <?php
    $readingProgressService = new FttReadingProgressService(new FttReadingReadRepository($dbConnect), new FttReadingWriteRepository($dbConnect), $memberId);
    $reading_data = $readingProgressService->getDataReadingForStaff($flt_sevice_one_read, $fltSemesterRead, $rosterService->trainee());

    foreach ($reading_data as $key => $valuesDays) {
      if (!isset($trainee_list[$key])) {
        continue;
      }

      $counter = 0;
      foreach ($valuesDays as $key_2 => $value_2) {
        if ($counter == 0) {
          echo "</div><div class='row border-bottom pb-1 pt-1'><div class='col-3 read_name'><button class='btn btn-link' data-member_key='{$key}'>{$trainee_list[$key]} ({$trainee_list_list[$key]['semester']})</button></div>";
        }

        $bg_success = '';
        $date_record = '';
        if (!empty($key_2)) {
          $date_record = date_convert::yyyymmdd_to_ddmm($key_2);
        }
        // Всплывающий текст с прочитанными в этот день книгами и главами
        $title = '';
        $simGreenString = false;
        foreach ($value_2 as $valueTitles) {
          if (!empty($valueTitles['testament']) && $valueTitles['testament'] === 'ot') {
            $title = $valueTitles['book'];
            if ($valueTitles['chapter'] > 0) {
              $simGreenString = true;
              $title .= ' ' . $valueTitles['chapter'];
            } else {
              $title .= ' нет';
            }
            $title .= '; ';
          }

          if (!empty($valueTitles['testament']) && $valueTitles['testament'] === 'nt') {
            $title .= $valueTitles['book'];
            if ($valueTitles['chapter'] > 0) {
              $simGreenString = true;
              $title .= ' ' . $valueTitles['chapter'];
            } else {
              $title .= ' нет';
            }
            $title .= ';';
          }
        }

        if ($simGreenString) {
          $bg_success = 'green_string';
        }
        echo "<div class='col-1 read_day mr-2 {$bg_success}' title='{$title}' data-toggle='tooltip'>{$date_record}</div>";
        $counter++;
      }
      echo "<div class='col-1' style='max-width: 20px;'><i class='fa fa-pencil cursor-pointer edit_read' aria-hidden='true'></i></div>";
      echo "<div class='col-1' style='max-width: 20px;'><i class='fa fa-check-square cursor-pointer edit_read_books_str align-bottom' aria-hidden='true'></i></div>";
      //echo '<div class="col-1"><button type="button" class="btn btn-warning btn-sm bible_statistic_btn" data-toggle="modal" data-target="#mdl_bible_statistic" style="height: 30px;" data-member_key="'.$key.'">С</button></div>';

    }
    ?>
    </div>
</div>


  <!-- СПИСОК КНИГ БИБЛИИ -->
<div class="container">
  <div id="" class="row d-none">
    <div class="container text-center mt-3"> <!-- style="max-width: 600px;"-->
      <div class="row mb-3">
        <div class="col-12">
          <?php
          $bible_books = $bible_obj->get();
          foreach ($bible_books as $key => $value) {
            if ($key === 39) {
              echo "</div></div><div class='row mb-3'><div class='col-12'>";
            }
            echo "<span class='custom_link' value='{$value[0]}'>{$value[0]} </span>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- СТАРАЯ ФОРМА И СТАТИСТИКА
    <div class="row mb-2">
        <div class="col">
          <button type="button" class="btn btn-warning btn-sm bible_statistic_btn" data-toggle="modal" data-target="#mdl_bible_statistic" style="height: 30px;">Статистика</button>
        </div>
    </div>
-->
