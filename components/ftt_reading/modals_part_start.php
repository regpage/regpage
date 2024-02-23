<!-- ЧТЕНИЕ СТАРТ РАЗДЕЛ ПОСЕЩАЕМОСТЬ-->
<div id="mdl_bible_start" class="modal hide fade" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" data-id="" data-member_key="" data-serving_one="" data-status="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="mb-0">Выбор начала чтения</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size: 1.5rem;">x</button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row mb-2">
              <div class="col-12">
                <h6 class="">Выбор другой книги возможен только на сегодняшнюю дату и в том случае, если текущая книга дочитана до последней главы.</h6>
              </div>
          </div>
          <!-- ВЗ -->
          <div class="row mb-2">
              <div class="col-1">
                <input id="mdl_ot_start" type="checkbox" class="align-middle">
              </div>
              <div class="col pl-2">
                <h5 class="">Ветхий Завет</h5>
              </div>
          </div>
          <div class="row mb-3">
              <div class="col-1" style="max-width: 22px;">

              </div>
              <div class="col-5">
                <select id="mdl_book_ot_start" class="form-control" data-field="book_ot">
                  <?php
                  $bible_books = $bible_obj->get();
                  foreach ($bible_books as $key => $value) {
                    if ($key === 39) {
                      break;
                    }
                    if (!in_array($value[0], $read_book_arr)) {
                      echo "<option value='{$value[0]}'>{$value[0]}";
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-5">
                <select id="mdl_chapter_ot_start" class="form-control" data-field="chapter_ot">
                  <?php
                  for ($i=1; $i <= $bible_books[0][1]; $i++) {
                    echo "<option value='{$i}'>{$i}";
                  }
                  ?>
                </select>
              </div>
          </div>
          <!-- ПРИМЕЧАНИЯ -->
          <div class="row">
              <div class="col-1" style="max-width: 22px;">

              </div>
              <div class="col">
                <label for="mdl_footnotes_ot_start"><input id="mdl_footnotes_ot_start" type="checkbox" class="align-middle" value="" data-field="read_footnotes_ot"> с примечаниями</label>
              </div>
          </div>
          <hr>
          <!-- НЗ -->
          <div class="row mb-2">
            <div class="col-1">
              <input id="mdl_nt_start" type="checkbox" class="align-middle">
            </div>
              <div class="col pl-2">
                <h5>Новый Завет</h5>
              </div>
          </div>
          <div class="row mb-3">
              <div class="col-1" style="max-width: 22px;">

              </div>
              <div class="col-5">
                <select id="mdl_book_nt_start" class="form-control" data-field="book_nt">
                  <?php
                  $bible_books = $bible_obj->get();
                  foreach ($bible_books as $key => $value) {
                    if ($key > 38) {
                      if (!in_array($value[0], $read_book_arr)) {
                        echo "<option value='{$value[0]}'>{$value[0]}";
                      }
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-5">
                <select id="mdl_chapter_nt_start" class="form-control" data-field="chapter_ot">
                  <?php
                  for ($i=1; $i <= $bible_books[39][1]; $i++) {
                    echo "<option value='{$i}'>{$i}";
                  }
                  ?>
                </select>
              </div>
          </div>
          <!-- ПРИМЕЧАНИЯ -->
          <div class="row">
              <div class="col-1" style="max-width: 22px;">

              </div>
              <div class="col">
                <label for="mdl_footnotes_nt_start"><input id="mdl_footnotes_nt_start" type="checkbox" class="align-middle" value="" data-field="read_footnotes_nt"> с примечаниями</label>
              </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="text-right w-100">
          <button id="set_start_reading_bible" class="btn btn-sm btn-success" type="button">Сохранить</button>
          <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal" aria-hidden="true">Закрыть</button>
        </div>
      </div>
    </div>
  </div>
</div>
