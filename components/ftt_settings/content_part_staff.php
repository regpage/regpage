<!-- Настройки ПВОМ -->
<div class="container">
  <!-- Таблицы с данными ПВОМ -->
  <div class="row pt-3">
    <div class="col-12">
      <h6>Таблицы с данными семестра ПВОМ</h6>
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
      <h6>Таблицы с данными ПВОМ не зависящие от семестра</h6>
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
      <h6>Данные заявлений на ПВОМ</h6>
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
  <hr class="mb-2 mt-2">
<!--  -->
  <div class="row pt-3">
    <div class="col-10">
      <h6>Удалить ВСЕ данные семестра ПВОМ (записи в таблицах и прикреплённые файлы), КРОМЕ чтения Библии?</h6>
      <p>Включая список обучающихся и данные разделов: расписание, объявления, посещаемость, листы отсутствия, пропущенные занятия, общение, служение, благовестие, доп.помощь, опоздания.</p>
    </div>
    <div class="col-2">
      <button id="showModalUniversalConfirm" type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#modalUniversalConfirm">Удалить всё</button>
    </div>
  </div>
<hr class="mb-2 mt-2">
<!--  -->
  <div class="row pt-3">
    <div class="col-10">
      <h6>Частично удалить данные семестра ПВОМ, кроме чтения Библии и долгов т.е. доп. занятий, пропущенных занятий, расписания и посещаемости?</h6>
      <p>Включая данные разделов: объявления, листы отсутствия, общение, служение, благовестие, опоздания.<br>
      В разделах: доп.помощь, пропущенные занятия <b>останутся только долги</b>. </p>
    </div>
    <div class="col-2">
      <button id="showModalUniversalConfirmThree" type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#modalUniversalConfirm">Удалить, но оставить долги</button>
    </div>
  </div>
  <hr class="mb-2 mt-2">
  <!--  -->
  <div class="row pt-3">
    <div class="col-10">
      <h6>Удалить пропущенные занятия, кроме долгов?</h6>
    </div>
    <div class="col-2">
      <button id="" type="button" class="btn btn-danger btn-sm partial_removal" name="button" data-toggle="modal" data-target="#modalUniversalConfirm" data-type="partial_reset_skip">Удалить, но оставить долги</button>
    </div>
  </div>
  <hr class="mb-2 mt-2">

  <!--  -->
  <div class="row pt-3">
    <div class="col-10">
      <h6>Удалить доп. помощь, кроме долгов?</h6>
    </div>
    <div class="col-2">
      <button id="" type="button" class="btn btn-danger btn-sm partial_removal" name="button" data-toggle="modal" data-target="#modalUniversalConfirm" data-type="partial_reset_extra_help">Удалить, но оставить долги</button>
    </div>
  </div>
  <hr class="mb-2 mt-2">

  <!--  -->
  <div class="row pt-3">
    <div class="col-10">
      <h6>Удалить долги участников закончивших обучение. Включая данные и прикрепленные файлы таблиц посещаемость, доп. помощь, проп. занятия? Списк обучающихся должен быть актуальным.</h6>
    </div>
    <div class="col-2">
      <button id="" type="button" class="btn btn-danger btn-sm partial_removal" name="button" data-toggle="modal" data-target="#modalUniversalConfirm" data-type="reset_graduate">Удалить долги закончивших обучение</button>
    </div>
  </div>
  <hr class="mb-2 mt-2">

  <!--  -->
  <div class="row pt-3">
    <div class="col-10">
      <h6>Удалить историю чтения Библии закончивших обучение? Списк обучающихся должен быть актуальным. Если список обучающихся пуст, тогда будут удалена вся история чтения Библии.</h6>
    </div>
    <div class="col-2">
      <button id="" type="button" class="btn btn-danger btn-sm partial_removal" name="button" data-toggle="modal" data-target="#modalUniversalConfirm" data-type="partial_reset_bible">Удалить историю</button>
    </div>
  </div>
  <hr class="mb-2 mt-2">

</div>
