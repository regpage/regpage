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

<!--ПРОЧИТАННЫЕ КНИГИ -->
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

<!-- Статистика чтения Библии -->
<div class="modal fade" id="mdl_bible_statistic">
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
<div class="modal fade" id="mdl_bible_check_book">
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
            <select id="ftr_trainee_reading_check_mbl" class="form-control">
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
        <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Сохранить</button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- ЧТЕНИЕ СТАРТ-->
<?php include_once 'components/ftt_reading/modals_part_start.php'; ?>
