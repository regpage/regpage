<?php include_once 'db/classes/ftt_lists.php'; ?>
<div class="container">
  <!-- РУЧНОЕ ДОБАВЛЕНИЕ ЗАПИСЕЙ НА ОБЩЕНИЕ ПВОМ -->
  <div class="row">
    <div class="col-10">
      <h4>РУЧНОЕ ДОБАВЛЕНИЕ ЗАПИСЕЙ НА ОБЩЕНИЕ НА 2 НЕДЕЛИ ВПЕРЁД</h4>
      <p>По умолчанию функция отключена. Список служащих задаётся вручную. День старта по умолчанию завтра. Перед использованием рекомендуется выгрузить базу и дополнительно таблицу ftt_fellowship</p>
      <a href="add_fellowship">Запустить скрипт</a>
    </div>
  </div>
  <hr class="mb-2 mt-3">
  <!-- Таблицы с данными ПВОМ -->
  <div class="row">
    <div class="col-1">
      <p>1.</p>
    </div>
    <div class="col-10">
      <h4>Удалить данные семестра ПВОМ?</h4>
      <p>Включая данные таблиц:
        <?php
        foreach (checkDataSemester() as $key => $value) {
          if ($value->num_rows === 1) {
            echo "<span>{$key} <span class='text-success'> (есть данные)</span>; </span>";
          } else {
            echo "<span>{$key} <span class='text-danger'> (пусто)</span>; </span>";
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
      <p>Включая данные таблиц:
        <?php
        foreach (checkOtherDataSemester() as $key => $value) {
          if ($value->num_rows === 1) {
            echo "<span>{$key} <span class='text-success'> (есть данные)</span>; </span>";
          } else {
            echo "<span>{$key} <span class='text-danger'> (пусто)</span>; </span>";
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
      <p>Включая данные таблиц:
        <?php
        foreach (checkApplicationData() as $key => $value) {
          if ($value->num_rows === 1) {
            echo "<span>{$key} <span class='text-success'> (есть данные)</span>; </span>";
          } else {
            echo "<span>{$key} <span class='text-danger'> (пусто)</span>; </span>";
          }
        }
        ?>
        </p>
    </div>
    <div class="col-1">
      <button id="showModalUniversalConfirmApplication" type="button" class="btn btn-danger btn-sm" name="button" data-toggle="modal" data-target="#modalUniversalConfirm">Удалить заявления</button>
    </div>
  </div>
  <!-- auth -->
  <?php include_once 'panelsource/content/ftt/auth.php'; ?>
</div>
