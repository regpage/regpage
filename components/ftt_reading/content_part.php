<!-- Название раздела -->
<!-- СОЗДАТЬ ФОРМУ И СПИСОК КНИГ
ФОРМУ ДОБАВИТЬ В БЛАНК И КНОПКУ СТАРТА
ЕСЛИ ТЕКУЩИЙ БЛАНК НЕ ЗАПОЛНЕН СОВСЕМ ПРОВЕРЯТЬ БЫЛ ЛИ СТАРТ И ОТ ЭТОГО ЗАПОЛНЯТЬ
-->
<?php
require_once  '../private/vendor/autoload.php'; //ROOT_PATH .
use App\Infrastructure\Database\DbQuery;
$dbConnect = new DbQuery($db);
use App\Repositories\Ftt\Reading\FttReadingReadRepository;
use App\Services\Ftt\Reading\FttReadingStartStopService;

require_once 'components/ftt_reading/content_part_cntrl.php';
?>
<div class="container">
  <!-- Уведомление о чтении кол-ва глав в день -->
  <?php if (!empty($bible_reading_calculate['ot_current']) || !empty($bible_reading_calculate['nt_current'])): ?>
  <div class="row pt-2">
    <div class="col-12">
      <div class="text-center">
        <strong class="text-danger">
          <?php
          $bible_reading_calculate_nt = 0;
          $bible_reading_calculate_ot = 0;
          // если книги прочитаны
          if ($bible_reading_calculate['nt_deff'] > 0) {
            $bible_reading_calculate_nt = $bible_reading_calculate['nt_deff'];
          }

          if ($bible_reading_calculate['ot_deff'] > 0) {
            $bible_reading_calculate_ot = $bible_reading_calculate['ot_deff'];
          }

          $text_deff = '';
          if ((!empty($bible_reading_calculate['ot_current']) && ($bible_reading_calculate['semester'] === '1' || $bible_reading_calculate['semester'] === '2')) || ($bible_reading_calculate['semester'] === '5' || $bible_reading_calculate['semester'] === '6')) {
            $text_deff = "Чтобы успеть до конца текущего года обучения, нужно прочитывать не менее {$bible_reading_calculate_ot} глав Ветхого Завета в день. ";
          }

          if ((!empty($bible_reading_calculate['nt_current']) && ($bible_reading_calculate['semester'] === '1' || $bible_reading_calculate['semester'] === '2')) || ($bible_reading_calculate['semester'] === '3' || $bible_reading_calculate['semester'] === '4')) {
            if (empty($text_deff)) {
              $text_deff .= "Чтобы успеть до конца текущего года обучения, нужно прочитывать не менее {$bible_reading_calculate_nt} глав Нового Завета в день.";
            } else {
              $text_deff .= "И не менее {$bible_reading_calculate['nt_deff']} глав Нового Завета в день.";
            }
          }

          echo $text_deff;
          ?>
        </strong>
      </div>
    </div>
  </div>
  <?php endif; ?>
  <?php if (empty($bible_reading_calculate['ot_current']) && empty($bible_reading_calculate['nt_current'])): ?>
    <div class="row pt-2">
      <div class="col-12">
        <div class="text-center">
          <strong class="text-danger">
            Задайте старт чтения Библии.
          </strong>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <?php
  // БЛОК РАБОТАЕТ ТОЛЬКО НА ПЕРЕРЫВЕ
  if (ftt_info::pause()): ?>
  <div id="" class="row border-bottom pb-2">
    <div class="container border mt-3 mb-3 p-2" style="max-width: 400px;">  <!--d-none-->
      <div class="row">
        <div class="col-5" style="max-width: 170px;">
          <select id="bible_book_ot" class="col mr-3 px-1 form-control"
            data-book="<?php echo $book_current['ot']['book']; ?>" data-id="<?php echo $book_current['ot']['id']; ?>" data-chapter="<?php echo $book_current['ot']['chapter']; ?>" data-field="book_ot" data-notes="<?php echo $book_current['ot']['footnotes']; ?>"
            style="min-width: 95px; min-height: 35px; margin-left: 0px !important;" <?php echo $disabled_ot; ?>>
            <option value="_none_">ВЗ
              <option value="0">Нет
                <?php
                $counter = 0;
                foreach ($bible_books as $key => $value) {
                  if ($key < 39) {
                    for ($i=1; $i <= $value[1]; $i++) {
                      if (($book_current['ot']['book'] ===  $value[0] && $book_current['ot']['chapter'] == $i) || $counter || empty($book_current['ot']['book'])) {
                        $selected = '';
                        if ($book_current['ot']['book'] ===  $value[0] && $book_current['ot']['chapter'] == $i && !empty($book_current['ot']['id'])) {
                          $selected = 'selected';
                        }
                        echo "<option value='{$value[0]} {$i}' data-book='{$value[0]}' data-chapter='{$i}' {$selected}>{$value[0]} {$i}";
                        if (!empty($book_current['ot']['book'])) {
                          $counter++;
                          if ($counter === 10) {
                            break;
                          }
                        }
                      }
                    }
                  }
                  if ($counter === 10) {
                    break;
                  }
                }
                ?>
          </select>
        </div>
        <div class="col-5" style="max-width: 170px;">
          <select id="bible_book_nt" class="col mr-3 px-1 form-control"
          data-book="<?php echo $book_current['nt']['book']; ?>" data-id="<?php echo $book_current['nt']['id']; ?>" data-chapter="<?php echo $book_current['nt']['chapter']; ?>" data-field="book_nt" data-notes="<?php echo $book_current['nt']['footnotes']; ?>"
          style="min-width: 95px; min-height: 35px; margin-left: 0px !important;" <?php echo $disabled_nt; ?>>
            <option value="_none_">НЗ
              <option value="0">Нет
                <?php
                $counter = 0;
                foreach ($bible_books as $key => $value) {
                  if ($key > 38) {
                    for ($i=1; $i <= $value[1]; $i++) {
                      if (($book_current['nt']['book'] ===  $value[0]  && $book_current['nt']['chapter'] == $i) || $counter || empty($book_current['nt']['book'])) {
                        $selected = '';
                        if ($book_current['nt']['book'] ===  $value[0] && $book_current['nt']['chapter'] == $i && !empty($book_current['nt']['id'])) {
                          $selected = 'selected';
                        }
                        echo "<option value='{$value[0]} {$i}' data-book='{$value[0]}' data-chapter='{$i}' {$selected}>{$value[0]} {$i}";
                        if (!empty($book_current['nt']['book'])) {
                          $counter++;
                          if ($counter === 10) {
                            break;
                          }
                        }
                      }
                    }
                  }
                  if ($counter === 10) {
                    break;
                  }
                }
                ?>
          </select>
        </div>
        <div class="col-2 pl-0">
          <button type="button" id="show_me_start" class="col bg-secondary text-light short_select_field rounded" style="min-width: 54px !important; height: 38px;">...</button>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-5" style="max-width: 170px;">
          <input type="date" id="date_read" class="form-control" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="col-7">
          <button id="save_book_read" class="btn btn-sm btn-success float-right w-100 h-100" type="button" data-toggle="modal" data-target="#" <?php echo $disabled; ?>>Записать</button>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- СПИСОК КНИГ БИБЛИИ -->
  <div id="" class="row">
    <div class="container text-center mt-3"> <!-- style="max-width: 600px;"-->
      <div class="row mb-3">
        <div class="col-12">
          <?php
          $start_data = (new FttReadingStartStopService(new FttReadingReadRepository($dbConnect), $memberId))->getLastPositionPair();
          $notes_ot = '';
          $notes_nt = '';
          if (!empty($start_data['testament']) && $start_data['testament'] === 'ot') {
            if ($start_data['footnotes'] == 1) {
              $notes_ot = '(с прим.)';
            } else {
              $notes_ot = '(без прим.)';
            }
          }
          if (!empty($start_data['testament']) && $start_data['testament'] === 'nt') {
            if ($start_data['footnotes'] == 1) {
              $notes_nt = '(с прим.)';
            } else {
              $notes_nt = '(без прим.)';
            }
          }
          ?>
          <h5>Ветхий завет <?php echo $notes_ot; ?></h5>
          <div style="font-size: 16px;">
            <?php
            $bible_books_no_space = $bible_obj->getNoSpace();
            foreach ($bible_books_no_space as $key => $value) {
              $green = '';
              $border = '';
              for ($i=0; $i < count($read_bible_books); $i++) {
                if ($bible_books[$key][0] === $read_bible_books[$i][0]) {
                  $green = 'bg_green';
                }
              }
              if ($bible_books[$key][0] === $book_current['nt']) {
                $border = 'border border-dark';
              }
              if ($bible_books[$key][0] === $book_current['ot']) {
                $border = 'border border-dark';
              }
              if ($key === 39) {
                echo "</div></div></div><div class='row mb-3'><div class='col-12'><h5>Новый завет {$notes_nt}</h5><div style='font-size: 16px;'>";
              }
              echo "<span class='{$green} {$border} d-inline-block mb-1 p-1' data-book='{$bible_books[$key][0]}'>{$value[0]} </span>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
