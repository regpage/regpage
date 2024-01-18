<!-- Название раздела -->
<div class="container">
  <div id="list_header" class="row border-bottom pb-2">
  </div>
  <!-- Таблицы с данными ПВОМ -->
  <div class="row">
    <div class="col-1">
      <p>1.</p>
    </div>
    <div class="col-10">
      <h4>Удалить данные семестра ПВОМ (записи в таблицах и прикреплённые файлы)?</h4>
      <p>Включая данные таблиц:<br>
        <?php
        foreach (checkDataSemester() as $key => $value) {
          if ($value->num_rows === 1) {
            echo "<span>{$key} <span class='text-success'> (есть данные)</span>; </span><br>";
          } else {
            echo "<span>{$key} <span class='text-danger'> (пусто)</span>; </span><br>";
          }
        }
        ?>
        </p>
    </div>
    <div class="col-1">
      <button id="showModalUniversalConfirm" type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#modalUniversalConfirm">Удалить</button>
    </div>
  </div>
  <hr class="mb-2 mt-2">

  <!-- Другие таблицы с данными ПВОМ -->
  <div class="row">
    <div class="col-1">
      <p>2.</p>
    </div>
    <div class="col-10">
      <h4>Другие таблицы с данными ПВОМ</h4>
      <p>Включая данные таблиц:<br>
        <?php
        foreach (checkOtherDataSemester() as $key => $value) {
          if ($value->num_rows === 1) {
            echo "<span>{$key} <span class='text-success'> (есть данные)</span>; </span><br>";
          } else {
            echo "<span>{$key} <span class='text-danger'> (пусто)</span>; </span><br>";
          }
        }
        ?>
        </p>
    </div>
    <div class="col-1">

    </div>
  </div>
  <hr class="mb-2 mt-2">
  <!-- Таблицы заявления -->
  <div class="row">
    <div class="col-1">
      <p>3.</p>
    </div>
    <div class="col-10">
      <h4>Данные других таблиц ПВОМ</h4>
      <p>Включая данные таблиц:<br>
        <?php
        foreach (checkApplicationData() as $key => $value) {
          if ($value->num_rows === 1) {
            echo "<span>{$key} <span class='text-success'> (есть данные)</span>; </span><br>";
          } else {
            echo "<span>{$key} <span class='text-danger'> (пусто)</span>; </span><br>";
          }
        }
        ?>
        </p>
    </div>
    <div class="col-1">
      <button id="showModalUniversalConfirmApplication" type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#modalUniversalConfirm">Удалить заявления</button>
    </div>
  </div>
</div>
