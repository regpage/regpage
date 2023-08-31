<!-- Название раздела -->
<!-- СОЗДАТЬ ФОРМУ И СПИСОК КНИГ
ФОРМУ ДОБАВИТЬ В БЛАНК И КНОПКУ СТАРТА
ЕСЛИ ТЕКУЩИЙ БЛАНК НЕ ЗАПОЛНЕН СОВСЕМ ПРОВЕРЯТЬ БЫЛ ЛИ СТАРТ И ОТ ЭТОГО ЗАПОЛНЯТЬ
-->
<div class="container">
  <div id="" class="row border-bottom pb-2 d-none">
    <div class="container border mt-3 mb-3 p-2" style="max-width: 400px;">
      <div class="row">
        <div class="col-5" style="max-width: 170px;">
          <select id="bible_book_ot" class="col mr-3 form-control" data-field="book_ot" style="min-width: 95px; min-height: 35px; margin-left: 0px !important;">
            <option value="_none_">
              <option value="0">Нет
                <?php
                $bible_books = $bible_obj->get();
                foreach ($bible_books as $key => $value) {
                  if ($key < 39) {
                    for ($i=1; $i <= $value[1]; $i++) {
                      echo "<option value='{$i}' data-book='{$value[0]}' data-chapter='{$i}'>{$value[0]} {$i}";
                    }
                  }
                }
                ?>
          </select>
        </div>
        <div class="col-5" style="max-width: 170px;">
          <select id="bible_book_nt" class="col mr-3 form-control" data-field="book_nt" style="min-width: 95px; min-height: 35px; margin-left: 0px !important;">
            <option value="_none_">
              <option value="0">Нет
                <?php
                $bible_books = $bible_obj->get();
                foreach ($bible_books as $key => $value) {
                  if ($key > 38) {
                    for ($i=1; $i <= $value[1]; $i++) {
                      echo "<option value='{$i}' data-book='{$value[0]}' data-chapter='{$i}'>{$value[0]} {$i}";
                    }
                  }
                }
                ?>
          </select>
        </div>
      <div class="col-2 pl-0">
        <button type="button" id="show_me_start" class="col bg-secondary text-light short_select_field rounded" data-toggle="modal" data-target="#mdl_bible_start" style="min-width: 54px !important; height: 38px;" disabled>...</button>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-5" style="max-width: 170px;">
        <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
      </div>
      <div class="col-7">
        <button class="btn btn-sm btn-success float-right w-100 h-100" type="button" data-toggle="modal" data-target="#mdl_bible_start" disabled>Записать</button>
      </div>
    </div>

      <!--<div class="row mb-2">
          <div class="col">
            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#mdl_bible_start">Выбрать начало чтения</button>
          </div>
      </div>
      <div class="row mb-2">
          <div class="col">
            <button type="button" class="btn btn-warning btn-sm bible_statistic_btn" data-toggle="modal" data-target="#mdl_bible_statistic" style="height: 30px;">Статистика</button>
          </div>
      </div>
      <div class="row mb-2">
          <div class="col">
            <h5>Чтение Библии</h5>
          </div>
      </div>
      <?php if ($ftt_access['group'] === 'staff'): ?>
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
      <div class="row mb-3">
          <div class="col">
            <input type="date" class="form-control" value="<?php echo date('Y-m-d') ?>" min="<?php echo date('Y-m-d') ?>">
          </div>
      </div>
    <?php endif; ?>-->
        <!-- ВЗ
      <div class="row mb-2">
          <div class="col">
            <h5>Ветхий Завет</h5>
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
      </div>-->
      <!-- НЗ
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
      </div>-->
      <!-- ПРИМЕЧАНИЯ ???
      <div class="row mb-4">
          <div class="col">
            <label for="read_footnotes">Чтение с примечаниями <input id="read_footnotes" type="checkbox" class="align-middle" value="" data-field="read_footnotes"></label>
          </div>
      </div> -->
    </div>
  </div>
  <div id="" class="row">
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
