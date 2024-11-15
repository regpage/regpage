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
  #reg_cancel_confirm .col {
    font-size: 1.1rem;
  }
  .badge {
    font-size: 1rem;
  }
}
</style>
<?php if (isset($_COOKIE['arrdep_finish']) && $_COOKIE['arrdep_finish'] === '1'): ?>
<div class="container mt-4 mb-3">
  <div class="row">
    <div class="col text-center">
      <button id="btn_again" type="button" class="btn btn-sm btn-primary">Редактировать данные</button>
    </div>
  </div>
</div>
<script>
showHint("Данные сохранены, спасибо.");
setCookie("arrdep_finish", 0);
$("#btn_again").click(function () {
  location.reload();
});
</script>
<?php
exit;
endif; ?>
<div id="arrdep" class="container" style="max-width: 400px;" data-member_key="<?php echo $info['member_key']; ?>" data-event_key="<?php echo $info['event_key']; ?>" data-regstate="<?php echo $info['regstate_key']; ?>">
  <div class="row">
    <div class="col text-center">
      <h4><?php echo $info['event_name']; ?></h4>
      <hr>
      <h5 class="mb-1">Участник <?php echo $memberName; ?></h5>
      <span><?php
      switch ($info['regstate_key']){
          case '01': echo '<span class="badge badge-warning">ожидание подтверждения</span>'; break;
          case '02': echo '<span class="badge badge-warning">ожидание подтверждения</span>'; break;
          case '03': echo '<span class="badge badge-warning">ожидание отмены</span>'; break;
          case '04': echo '<span class="badge badge-success">регистрация подтверждена</span>'; break;
          case '05': echo '<span class="badge badge-danger">регистрация отменена</span>'; break;
      }
      ?>
     </span>
      <p class="mt-1">
        Пожалуйста, подтвердите (укажите) дату и время приезда <span class="text-danger">к месту проведения мероприятия</span>, а также дату и время отъезда. Если вы не знаете точное время, укажите приблизительное. Любую дополнительную информацию можно указать в комментарии.
      </p>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col pr-0">
      <div class="mb-2" style="width: 150px;">
        <label>Дата приезда<sup>*</sup></label>
        <input id="arr_date" class="form-control f_required text-center" type="date" value="<?php echo $info['arr_date']; ?>" required>
      </div>
      <div class="mb-2" style="width: 150px;">
        <label>Дата отъезда<sup>*</sup></label>
        <input id="dep_date" class="form-control f_required text-center" type="date" value="<?php echo $info['dep_date']; ?>" required>
      </div>
    </div>
    <div class="col pr-0">
      <div class="mb-2" style="width: 150px;">
        <label title="Время приезда к месту проведения конференции (с учётом времени на дорогу от вокзала/аэропорта)">Время<sup>*</sup></label>
        <input id="arr_time" class="form-control f_required text-center" type="time" value="<?php echo strval($arrTime); ?>">
      </div>
      <div class="mb-2" style="width: 150px;">
        <label title="Время отъезда от места проведения конференции, а не от вокзала">Время<sup>*</sup></label>
        <input id="dep_time" class="form-control f_required text-center" type="time" value="<?php echo strval($depTime); ?>">
      </div>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="span12">Размещение<sup>*</sup></label>
      <select id="accom" class="form-control f_required">
        <?php echo strval($info['accom']); ?>
        <?php foreach ($accomOptions as $key => $value):
          $selected = '';
          if (isset($info['accom']) && $info['accom'] >= 0) {
            if ($info['accom'] === $value[0]) {
              $selected = 'selected';
            }
          } elseif ($key === 0) {
            $selected = 'selected';
          }
          ?>
          <option value="<?php echo $value[0]; ?>" <?php echo $selected; ?>><?php echo $value[1]; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col">
      <label class="">Комментарий</label>
      <textarea id="member_comment" class="form-control" name="name" rows="4"><?php echo $info['comment']; ?></textarea>
    </div>
  </div>
  <div class="btn_group row">
    <div class="col-6 text-right pr-1">
      <button id="reg_btn_save" type="button" class="btn btn-sm btn-success">Сохранить</button>
    </div>
    <div class="col-6 text-left pl-1">
      <button id="reg_btn_close" type="button" class="btn btn-sm btn-secondary">Закрыть</button>
    </div>
  </div>
  <div class="btn_group row mt-2">
    <div class="col-12 text-center pl-0">
      <button id="reg_cancel_btn_show_confirm" class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true" style="">Отменить регистрацию</button>
    </div>
  </div>
</div>
<!-- Окно отмены регистрации -->
<div id="reg_cancel_confirm" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="mb-0">Отмена регистрации</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col">
              <span>Регистрация участника <?php echo $memberName; ?> будет отменена.</span>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button id="reg_cancel_confirm_btn_yes" class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true" style="">Отменить регистрацию</button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<script>
// дизайн для моб версии
if ($(window).width()<=769) {

}

// поведение
if ($("#arrdep").attr("data-regstate") === "03" || $("#arrdep").attr("data-regstate") === "05") {
  $("#reg_cancel_btn_show_confirm").hide();
  $("#reg_btn_save").text("Зарегистрироваться снова").parent().removeClass("col-6").addClass("col-9");
  $("#reg_btn_close").parent().removeClass("col-6").addClass("col-3");
}

// кнопка отменить регистрацию, показать окно подтвержения
$("#reg_cancel_btn_show_confirm").click(function () {
  $("#reg_cancel_confirm").modal("show");
});
// кнопка отменить регистрацию
$("#reg_cancel_confirm_btn_yes").click(function () {
  fetch("ajax/regpage/reg_ajax.php?section=reg&type=regstate&event_key=" + $("#arrdep").attr("data-event_key")
    + "&member_key="+ $("#arrdep").attr("data-member_key")
    + "&reg_state=03"
    + "&member_comment=" + $("#member_comment").val())
  .then(response => response.text())
  .then(commits => {
    if (commits) {
      setCookie("arrdep_finish", 1);
      setTimeout(function () {
        location.reload();
      }, 30);
    } else {
      showError("Извините, что то пошло не так.");
    }
  });
});

// кнопка сохранить
  $("#reg_btn_save").click(function () {
    let valid = true;
    $(".f_required").each(function () {
      if ((!$(this).val() && $(this).val() !== "0") || $(this).val() === "_none_") {
        valid = false;
        $(this).css("border-color", "red");
      } else {
        $(this).css("border-color", "#ced4da");
      }
    });
    if (!valid) {
      showError("Пожалуйста, заполните обязательные поля.");
      return;
    }
    // создать отдельный файл апи для страницы регистрации
    fetch("ajax/regpage/reg_ajax.php?section=reg&type=arrdep&event_key=" + $("#arrdep").attr("data-event_key")
      + "&member_key="+ $("#arrdep").attr("data-member_key")
      + "&arr_date=" + $("#arr_date").val()
      + "&dep_date=" + $("#dep_date").val()
      + "&arr_time=" + $("#arr_time").val()
      + "&dep_time=" + $("#dep_time").val()
      + "&accom=" + $("#accom").val()
      + "&regstate=" + $("#arrdep").attr("data-regstate")
      + "&member_comment=" + $("#member_comment").val())
    .then(response => response.text())
    .then(commits => {
      if (commits) {
        setCookie("arrdep_finish", 1);
        setTimeout(function () {
          location.reload();
        }, 30);
      } else {
        showError("Извините, что то пошло не так.");
      }
    });
  });
  // кнопка закрыть
  $("#reg_btn_close").click(function () {
    setCookie("arrdep_finish", 1);
    setTimeout(function () {
      location.reload();
    }, 30);
  });
</script>
