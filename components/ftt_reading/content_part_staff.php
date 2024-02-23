<!-- ЧТЕНИЕ БИБЛИИ -->
<!-- СОЗДАТЬ ФОРМУ И СПИСОК КНИГ
ФОРМУ ДОБАВИТЬ В БЛАНК И КНОПКУ СТАРТА
ЕСЛИ ТЕКУЩИЙ БЛАНК НЕ ЗАПОЛНЕН СОВСЕМ ПРОВЕРЯТЬ БЫЛ ЛИ СТАРТ И ОТ ЭТОГО ЗАПОЛНЯТЬ
-->
<?php
if (isset($_COOKIE['flt_serving_one_read'])) {
  $flt_sevice_one_read = $_COOKIE['flt_serving_one_read'];
} else {
  $flt_sevice_one_read = $memberId;
}
?>
<div class="container">
  <br>
  <div id="" class="row mb-2">
    <div class="col-2 pl-0 pr-2">
      <select id="read_sevice_one_select" class="form-control form-control-sm">
        <option value="_all_">Все служащие</option>
        <?php foreach ($serving_ones_list as $key => $value):
          $selected = '';
          if ($key === $flt_sevice_one_read) {
            $selected = 'selected';
          }
          echo "<option value='{$key}' {$selected}>{$value}</option>";
        endforeach; ?>
      </select>
    </div>
    <!--<div class="col-4 pl-0">
      <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#mdl_bible_check_book" style="width: 220px !important;">Отметить прочитанные книги</button>
    </div>-->
  </div>
</div>
<hr class="m-0">
<div id="list_readin_bible" class="container">
    <div class="row">
    <?php
    $reading_data = getDataReadingForStaff($flt_sevice_one_read);    
    foreach ($reading_data as $key => $value) {
      $counter = 0;
      foreach ($value as $key_2 => $value_2) {
        if ($counter == 0) {
          echo "</div><div class='row border-bottom pb-1 pt-1'><div class='col-3 read_name'><button class='btn btn-link' data-member_key='{$key}'>{$trainee_list[$key]} ({$trainee_list_list[$key]['semester']})</button></div>";
        }

        $bg_success = '';
        $date_record = '';
        if (!empty($key_2)) {
          $date_record = date_convert::yyyymmdd_to_ddmm($key_2);
        }


        $title = '';
        if (!empty($value_2['book_ot'])) {
          $title = $value_2['book_ot'];
          if ($value_2['chapter_ot'] > 0) {
            $title .= ' ' . $value_2['chapter_ot'];
          } else {
            $title .= ' нет';
          }
          $title .= '; ';
        }

        if (!empty($value_2['book_nt'])) {
          $title .= $value_2['book_nt'];
          if ($value_2['chapter_nt'] > 0) {
            $title .= ' ' . $value_2['chapter_nt'];
          }
          $title .= ';';
        }

        if ((isset($value_2['chapter_ot']) && $value_2['chapter_ot'] > 0) || (isset($value_2['chapter_nt']) && $value_2['chapter_nt'] > 0)) {
          $bg_success = 'green_string';
        }
        echo "<div class='col-1 read_day mr-2 {$bg_success}' title='{$title}' data-toggle='tooltip'>{$date_record}</div>";
        $counter++;
      }
      echo "<div class='col-1' style='max-width: 20px;'><i class='fa fa-pencil cursor-pointer edit_read' aria-hidden='true'></i></div>";
      echo "<div class='col-1' style='max-width: 20px;'><i class='fa fa-check-square cursor-pointer edit_read_books_str align-bottom' aria-hidden='true'></i></div>";
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

<div class="row mb-2">
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
    </div> -->

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
    </div> -->
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
    </div> -->
    <!-- ПРИМЕЧАНИЯ ???
    <div class="row mb-4">
        <div class="col">
          <label for="read_footnotes">Чтение с примечаниями <input id="read_footnotes" type="checkbox" class="align-middle" value="" data-field="read_footnotes"></label>
        </div>
    </div>
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
  </div>
</div> -->
