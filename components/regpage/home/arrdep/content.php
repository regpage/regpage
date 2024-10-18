<?php
// контролер раздела
require_once "components/regpage/home/arrdep/cntrl.php";
?>
<style media="screen">
  @media screen and (max-width: 800px) {
  label, input, textarea, button, p {
    font-size: 1.1rem !important;
  }
  #main_container_reg {
    padding-left: 15px;
  }
}

</style>
<div id="arrdep" class="container" style="max-width: 360px;" data-member_key="<?php echo $info['member_key']; ?>" data-event_key="<?php echo $info['event_key']; ?>">
  <div class="row">
    <div class="col text-center">
      <h4><?php echo $info['event_name']; ?></h4>
      <hr>
      <h5>Участник <?php echo $memberName; ?></h5>
      <p>Пожалуйста, подтвердите даты и время приезда и отъезда:</p>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col pr-0">
      <div class="mb-2" style="width: 150px;">
        <label class="">Дата приезда<sup>*</sup></label>
        <input id="arr_date" class="form-control text-center" type="date" value="<?php echo $info['arr_date']; ?>" required>
      </div>
      <div class="mb-2" style="width: 150px;">
        <label class="">Дата отъезда<sup>*</sup></label>
        <input id="dep_date" class="form-control text-center" type="date" value="<?php echo $info['dep_date']; ?>" required>
      </div>
    </div>
    <div class="col pr-0">
      <div class="mb-2" style="width: 150px;">
        <label class="" title="Время приезда к месту проведения конференции (с учётом времени на дорогу от вокзала/аэропорта)">Время</label>
        <input id="arr_time" class="form-control text-center" type="time" min="18:00" max="12:00" value="<?php echo strval($depTime); ?>">
      </div>
      <div class="mb-2" style="width: 150px;">
        <label class="" title="Время отъезда от места проведения конференции, а не от вокзала">Время</label>
        <input id="dep_time" class="form-control text-center" type="time" min="18:00" max="12:00" value="<?php echo strval($arrTime); ?>">
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="">Комментарий</label>
      <textarea id="member_comment" class="form-control" name="name" rows="4"><?php echo $info['comment']; ?></textarea>
    </div>
  </div>
  <div class="row">
    <div class="col text-right">
      <button type="button" class="btn btn-success">Сохранить</button>
    </div>
    <div class="col">
      <button type="button" class="btn btn-secondary">Закрыть</button>
    </div>
  </div>
</div>
<script>
// кнопка сохранить
  $(".btn-success").click(function () {
    // создать отдельный файл апи для страницы регистрации
    fetch("ajax/regpage/reg_ajax.php?section=reg&type=arrdep&event_key=" + $("#arrdep").attr("data-event_key")
      + "&member_key="+ $("#arrdep").attr("data-member_key")
      + "&arr_date=" + $("#arr_date").val()
      + "&dep_date=" + $("#dep_date").val()
      + "&arr_time=" + $("#arr_time").val()
      + "&dep_time=" + $("#dep_time").val()
      + "&member_comment=" + $("#member_comment").val())
    .then(response => response.text())
    .then(commits => {
      if (commits) {
        showHint("Данные сохранены, спасибо.");
      } else {
        showError("Извините, что то пошло не так.");
      }
    });
  });
  // кнопка закрыть
  $(".btn-secondary").click(function () {
    location.href = "index";
  });
</script>
