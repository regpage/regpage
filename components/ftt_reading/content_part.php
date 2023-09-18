<!-- Название раздела -->
<!-- СОЗДАТЬ ФОРМУ И СПИСОК КНИГ
ФОРМУ ДОБАВИТЬ В БЛАНК И КНОПКУ СТАРТА
ЕСЛИ ТЕКУЩИЙ БЛАНК НЕ ЗАПОЛНЕН СОВСЕМ ПРОВЕРЯТЬ БЫЛ ЛИ СТАРТ И ОТ ЭТОГО ЗАПОЛНЯТЬ
-->
<?php
require_once 'db/classes/ftt_info.php';

$read_bible_books = get_read_book($memberId);
$bible_books = $bible_obj->get();
$book_current = get_reading_data($memberId, date('Y-m-d'));
$disabled_ot = '';
$disabled_nt = '';
$disabled = '';
if (empty($book_current['book_ot'])) {
  $disabled_ot = 'disabled';
}
if (empty($book_current['book_nt'])) {
  $disabled_nt = 'disabled';
}
if ($book_current['start_today'] == 1) {
  $disabled = 'disabled';
  $disabled_ot = 'disabled';
  $disabled_nt = 'disabled';
}
?>
<div class="container">
  <?php
  // БЛОК РАБОТАЕТ ТОЛЬКО НА ПЕРЕРЫВЕ
  if (!ftt_info::pause()): ?>
  <div id="" class="row border-bottom pb-2">
    <div class="container border mt-3 mb-3 p-2" style="max-width: 400px;">
      <div class="row">
        <div class="col-5" style="max-width: 170px;">
          <select id="bible_book_ot" class="col mr-3 form-control"
            data-book="<?php echo $book_current['book_ot']; ?>" data-chapter="<?php echo $book_current['chapter_ot']; ?>" data-field="book_ot" data-notes="<?php echo $book_current['read_footnotes_ot']; ?>"
            style="min-width: 95px; min-height: 35px; margin-left: 0px !important;" <?php echo $disabled_ot; ?>>
            <option value="_none_">ВЗ
              <option value="0">Нет
                <?php
                $counter = 0;
                foreach ($bible_books as $key => $value) {
                  if ($key < 39) {
                    for ($i=1; $i <= $value[1]; $i++) {
                      if (($book_current['book_ot'] ===  $value[0] && $book_current['chapter_ot'] == $i) || $counter || empty($book_current['book_ot'])) {
                        $selected = '';
                        if ($book_current['book_ot'] ===  $value[0] && $book_current['chapter_ot'] == $i && $book_current['today_ot'] == 1) {
                          $selected = 'selected';
                        }
                        echo "<option value='{$value[0]} {$i}' data-book='{$value[0]}' data-chapter='{$i}' {$selected}>{$value[0]} {$i}";
                        if (!empty($book_current['book_ot'])) {
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
          <select id="bible_book_nt" class="col mr-3 form-control"
          data-book="<?php echo $book_current['book_nt']; ?>" data-chapter="<?php echo $book_current['chapter_nt']; ?>" data-field="book_nt" data-notes="<?php echo $book_current['read_footnotes_nt']; ?>"
          style="min-width: 95px; min-height: 35px; margin-left: 0px !important;" <?php echo $disabled_nt; ?>>
            <option value="_none_">НЗ
              <option value="0">Нет
                <?php
                $counter = 0;
                foreach ($bible_books as $key => $value) {
                  if ($key > 38) {
                    for ($i=1; $i <= $value[1]; $i++) {
                      if (($book_current['book_nt'] ===  $value[0]  && $book_current['chapter_nt'] == $i) || $counter || empty($book_current['book_nt'])) {
                        $selected = '';
                        if ($book_current['book_nt'] ===  $value[0] && $book_current['chapter_nt'] == $i && $book_current['today_nt'] == 1) {
                          $selected = 'selected';
                        }
                        echo "<option value='{$value[0]} {$i}' data-book='{$value[0]}' data-chapter='{$i}' {$selected}>{$value[0]} {$i}";
                        if (!empty($book_current['book_nt'])) {
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
          <button type="button" id="show_me_start" class="col bg-secondary text-light short_select_field rounded" data-toggle="modal" data-target="#mdl_bible_start" style="min-width: 54px !important; height: 38px;">...</button>
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
          $start_data = get_start_position($memberId);
          $notes_ot = '';
          $notes_nt = '';
          if (isset($start_data['book_ot']) && !empty($start_data['book_ot'])) {
            if ($start_data['read_footnotes_ot'] == 1) {
              $notes_ot = '(с примечаниями)';
            } else {
              $notes_ot = '(без примечаний)';
            }
          }
          if ($start_data['book_nt']) {
            if ($start_data['read_footnotes_nt'] == 1) {
              $notes_nt = '(с примечаниями)';
            } else {
              $notes_nt = '(без примечаний)';
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
              if ($bible_books[$key][0] === $book_current['book_nt']) {
                $border = 'border border-dark';
              }
              if ($bible_books[$key][0] === $book_current['book_ot']) {
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
