<!-- ЧТЕНИЕ СТАРТ РАЗДЕЛ ПОСЕЩАЕМОСТЬ-->
<div id="mdl_bible_start_reading" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-member_key="" data-serving_one="" data-status="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Выбор начала чтения</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">
        <div class="container border mt-3 mb-3 p-2" style="max-width: 450px;">
          <?php if ($ftt_access['group'] === 'staff'): ?>
          <!-- ОБУЧАЮЩИЙСЯ -->
          <div class="row mb-3">
            <div class="col">
              <select id="ftr_trainee_reading" class="form-control">
                <option value="">Обучающиеся</option>
                <?php foreach ($trainee_list as $key => $value):
                  /*$selected = '';
                  if ($key === $ftr_trainee_skip) {
                    $selected = 'selected';
                  }*/
                  echo "<option value='{$key}' {$selected}>{$value}</option>";
                endforeach; ?>
              </select>
            </div>
          </div>
          <!-- ДАТА -->
          <div class="row mb-3">
              <div class="col">
                <input type="date" class="form-control" value="<?php echo date('Y-m-d') ?>" min="<?php echo date('Y-m-d') ?>">
              </div>
          </div>
          <?php endif; ?>
          <!-- ВЗ -->
          <div class="row mb-2">
              <div class="col">
                <input type="checkbox"> <h5>Ветхий Завет</h5>
              </div>
          </div>
          <div class="row mb-3">
              <div class="col">
                <select class="form-control" data-field="book_ot" <?php echo $ftt_access['group'] !== 'staff' ? 'disabled' : '' ?>>
                  <?php
                  $bible_books = $bible_obj->get();
                  foreach ($bible_books as $key => $value) {
                    if ($key === 39) {
                      break;
                    }
                    echo "<option value='{$value[0]}'>{$value[0]}";
                  }
                  ?>
                </select>
              </div>
              <div class="col">
                <select class="form-control" data-field="chapter_ot">
                  <option value="0">Нет
                  <?php
                  for ($i=1; $i <= $bible_books[0][1]; $i++) {
                    echo "<option value='{$i}'>{$i}";
                  }
                  ?>
                </select>
              </div>
          </div>
          <!-- НЗ -->
          <div class="row mb-2">
              <div class="col">
                <h5>Новый Завет</h5>
              </div>
          </div>
          <div class="row mb-4">
              <div class="col">
                <select class="form-control" data-field="book_nt" <?php echo $ftt_access['group'] !== 'staff' ? 'disabled' : '' ?>>
                  <?php
                  $bible_books = $bible_obj->get();
                  foreach ($bible_books as $key => $value) {
                    if ($key > 38) {
                      echo "<option value='{$value[0]}'>{$value[0]}";
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col">
                <select class="form-control" data-field="chapter_ot">
                  <option value="0">Нет
                  <?php
                  for ($i=1; $i <= $bible_books[0][1]; $i++) {
                    echo "<option value='{$i}'>{$i}";
                  }
                  ?>
                </select>
              </div>
          </div>
          <!-- ПРИМЕЧАНИЯ -->
          <div class="row mb-4">
              <div class="col">
                <label for="read_footnotes">Чтение с примечаниями <input id="read_footnotes" type="checkbox" class="align-middle" value="" data-field="read_footnotes"></label>
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="text-right w-100">
          <button class="btn btn-sm btn-success" type="button">Сохранить</button>
          <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal" aria-hidden="true">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- НЕ ИСПОЛЬЗУЕТСЯ  ПРОЧИТАННЫЕ КНИГИ
<div id="mdl_bible_read_before" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-member_key="" data-serving_one="" data-status="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Отметка прочитанных к началу семестра книг</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <div class="text-right w-100">
          <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal" aria-hidden="true">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>
 -->
<!-- Статистика чтения Библии -->
<div id="mdl_bible_statistic" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content" style="width: 600px;">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Статистика чтения Библии</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div id="bible_statistic_list" class="container">
          <canvas></canvas>
        </div>
        <div id="bible_statistic_list_dates" class="container">
          <canvas></canvas>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- Отметка книг служащими -->
<div id="mdl_bible_check_book" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Прочитанные книги Библии</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col">
            <select id="ftr_trainee_reading_check_mbl" class="form-control" disabled>
              <option value="_none_">Обучающиеся</option>
              <?php foreach ($trainee_list as $key => $value):
                /*$selected = '';
                if ($key === $ftr_trainee_skip) {
                  $selected = 'selected';
                }*/
                echo "<option value='{$key}' {$selected}>{$value}</option>";
              endforeach; ?>
            </select>
          </div>
        </div>
        <div id="mdl_bible_books_check" class="row mb-3">
          <div class="col-6">
            <h5>ВЗ</h5>
          </div>
          <div class="col-6">
            <h5>НЗ</h5>
          </div>
          <div class="col-3 pr-0" data-part="ot">
            <?php
            $bible_books = $bible_obj->get();
            foreach ($bible_books as $key => $value) {
              if ($key === 20) {
                echo "</div><div class='col-3 pr-0' data-part='ot'>";
              }
              if ($key === 39) {
                echo "</div><div class='col-3 pr-0' data-part='nt'>";
              }
              if ($key === 59) {
                echo "</div><div class='col-3 pr-0' data-part='nt'>";
              }
              echo "<label class='mb-2'><input type='checkbox' id='mdl_book_check_{$key}' data-book='{$value[0]}' data-chapter='{$value[1]}'> {$value[0]}</label><br>";
            }
            ?>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Сохранить</button>-->
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- Статистика чтения Библии -->
<div class="modal fade" id="mdl_reading_archive">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Чтение Библии</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">

        <div class="container pl-0">
          <div class="row">
            <div class="col-6 text-center">
              <h5 id="mdl_history_read_name"></h5>
              <div id="mdl_lest_reading_bible" style="font-size: 16px;">

              </div>
            </div>
            <div id="mdl_cal_reading_bible" class="col-6">
              <div class="calendar-wrapper mt-0">
          		  <button id="btnPrev" type="button">Предыдущий</button>
          		  <button id="btnNext" type="button">Следующий</button>
      			    <div id="divCal"></div>
      		    </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- правка чтения Библии -->
<?php if ($ftt_access['group'] === 'staff'): ?>
<div class="modal fade" id="mdl_edit_read" data-member_key="">
  <div class="modal-dialog" style="max-width: 440px;">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title">Чтение Библии</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <h5 id="mdl_edit_read_name"></h5>
        <div class="container border ml-0 mr-0 mt-3 mb-3 p-2" style="max-width: 400px;">
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
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- ЧТЕНИЕ СТАРТ-->
<?php include_once 'components/ftt_reading/modals_part_start.php'; ?>
