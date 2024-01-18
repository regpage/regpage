<!-- Настройки ПВОМ -->
<div class="container">
  <!-- Таблицы с данными ПВОМ -->
  <div class="row pt-3">
    <div class="col-12">
      <h4>Таблицы с данными ПВОМ</h4>
        <?php
        foreach (checkDataSemester() as $key => $value) {
          if ($value->num_rows === 1) {
            echo "<span><i>{$key} </i> <span class='text-success'> (есть данные)</span>; </span><br>";
          } else {
            echo "<span><i>{$key} </i> <span class='text-danger'> (пусто)</span>; </span><br>";
          }
        }
        ?>
        </p>
    </div>
  </div>
  <hr class="mb-2 mt-2">
  <!-- Другие таблицы с данными ПВОМ -->
  <div class="row">
    <div class="col-12">
      <h4>Ещё таблицы с данными ПВОМ</h4>
        <?php
        foreach (checkOtherDataSemester() as $key => $value) {
          if ($value->num_rows === 1) {
            echo "<span><i>{$key} </i> <span class='text-success'> (есть данные)</span>; </span><br>";
          } else {
            echo "<span><i>{$key} </i> <span class='text-danger'> (пусто)</span>; </span><br>";
          }
        }
        ?>
        </p>
    </div>
  </div>
  <hr class="mb-2 mt-2">
  <!-- Таблицы заявления -->
  <div class="row">
    <div class="col-12">
      <h4>Данные заявлений на ПВОМ</h4>
        <?php
        foreach (checkApplicationData() as $key => $value) {
          if ($value->num_rows === 1) {
            echo "<span><i>{$key} </i> <span class='text-success'> (есть данные)</span>; </span><br>";
          } else {
            echo "<span><i>{$key} </i> <span class='text-danger'> (пусто)</span>; </span><br>";
          }
        }
        ?>
        </p>
    </div>
    <!-- <div class="col-2">
      <button id="showModalUniversalConfirmApplication" type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#modalUniversalConfirm">Удалить заявления</button>
    </div>-->
  </div>
<!--  -->
  <div class="row pt-3">
    <div class="col-10">
      <h4>Удалить ВСЕ данные семестра ПВОМ (записи в таблицах и прикреплённые файлы) КРОМЕ чтения Библии?</h4>
      <p>Включая список обучающихся и данные разделов: расписание, объявления, посещаемость, листы отсутствия, пропущенные занятия, общение, служение, благовестие, доп.помощь, опоздания.<br>
    </div>
    <div class="col-2">
      <button id="showModalUniversalConfirm" type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#modalUniversalConfirm">Удалить всё</button>
    </div>
  </div>

<!--  -->
  <div class="row pt-3">
    <div class="col-10">
      <h4>Частично удалить данные семестра ПВОМ, кроме долгов т.е. доп. занятий, пропущенных занятий, чтение Библии, расписание и посещаемости?</h4>
    </div>
    <div class="col-2">
      <button id="showModalUniversalConfirmThree" type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#modalUniversalConfirm">Удалить, но оставить долги</button>
    </div>
  </div>
  <hr class="mb-2 mt-2">
  <!--  -->
  <div class="row pt-3">
    <div class="col-10">
      <h4>Удалить сданные долги по пропущенным занятиям</h4>
    </div>
    <div class="col-2">
      <button id="" type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#modalUniversalConfirm">Удалить, но оставить долги</button>
    </div>
  </div>
  <hr class="mb-2 mt-2">

  <!--  -->
  <div class="row pt-3">
    <div class="col-10">
      <h4>Удалить выполненную доп. помощь?</h4>
    </div>
    <div class="col-2">
      <button id="" type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#modalUniversalConfirm">Удалить, но оставить долги</button>
    </div>
  </div>
  <hr class="mb-2 mt-2">

  <!--  -->
  <div class="row pt-3">
    <div class="col-10">
      <h4>Удалить историю чтения Библии закончивших обучение? Списк обучающихся должен быть актуальным.</h4>
    </div>
    <div class="col-2">
      <button id="" type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#modalUniversalConfirm">Удалить историю</button>
    </div>
  </div>
  <hr class="mb-2 mt-2">

</div>
