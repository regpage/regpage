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
          <!-- ВЗ -->
          <div class="row mb-2">
              <div class="col-1">
                <input type="checkbox" class="align-middle">
              </div>
              <div class="col pl-2">
                <h5 class="">Ветхий Завет</h5>
              </div>
          </div>
          <div class="row mb-3">
              <div class="col-1">

              </div>
              <div class="col-5">
                <select class="form-control" data-field="book_ot">
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
              <div class="col-5">
                <select class="form-control" data-field="chapter_ot">
                  <option value="0">0
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
              <div class="col-1">

              </div>
              <div class="col">
                <label for="read_footnotes_ot"><input id="read_footnotes_ot" type="checkbox" class="align-middle" value="" data-field="read_footnotes_ot"> с примечаниями</label>
              </div>
          </div>
          <hr>
          <!-- НЗ -->
          <div class="row mb-2">
            <div class="col-1">
              <input type="checkbox" class="align-middle">
            </div>
              <div class="col pl-2">
                <h5>Новый Завет</h5>
              </div>
          </div>
          <div class="row mb-3">
              <div class="col-1">

              </div>
              <div class="col-5">
                <select class="form-control" data-field="book_nt">
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
              <div class="col-5">
                <select class="form-control" data-field="chapter_ot">
                  <option value="0">0
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
              <div class="col-1">

              </div>
              <div class="col">
                <label for="read_footnotes_nt"><input id="read_footnotes_nt" type="checkbox" class="align-middle" value="" data-field="read_footnotes_nt"> с примечаниями</label>
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
