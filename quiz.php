<?php
include_once "db.php";

// получаем количество ответов
function checkLimits($id) {
    global $db;
    $id = $db->real_escape_string($id);
    $result = '';
    $res = db_query("SELECT COUNT(`id_list`) AS count_id FROM questionnaire_data WHERE `id_list`='$id'");
    while ($row = $res->fetch_assoc()) $result = $row['count_id'];
    return $result;
}
if (isset($_POST['sent'])) {
  // Добавляем ответы
  function setQuestionnaireAnswer($answers='') {
    // попробовать через filter_input_array
    global $db;
    //$id = $db->real_escape_string($_POST['']);
    foreach ($_POST as $key => $value) {
      if ($value) {
        $limits = '';
        $value_exist = checkLimits($key);
        if ($key !== 'sent') {
          $res = db_query("SELECT ql.id, ql.limits FROM questionnaire_list AS ql WHERE ql.id='$key'");
          while ($row = $res->fetch_assoc()) $limits = $row['limits'];

          if ($limits) {
            if ($limits > 0 && $value_exist < $limits) {
              $insert = db_query("INSERT INTO questionnaire_data (`id_list`, `value`) VALUES ('$key', '$value')");
              //$update = db_query("UPDATE questionnaire_data SET `value`=`value`+1 WHERE `id_list`='{$key}'");
            } else {
              echo "Лимит исчерпан, попытайтесь заполнить <a href=quiz>ещё раз</a>.";
              exit;
            }
          } else {
            $insert = db_query("INSERT INTO questionnaire_data (`id_list`, `value`) VALUES ('$key', '$value')");
            //$update = db_query("UPDATE questionnaire_data SET `value`=`value`+1 WHERE `id_list`='{$key}'");
          }
        }
      }
    }
  }
  setQuestionnaireAnswer($_POST);
}
// получаем анкету
function getQuestionnaire() {
    $result = [];
    $res = db_query("SELECT q.id, q.name, q.header, q.comment,
      ql.id AS ql_id, ql.id_blank, ql.name AS ql_name, ql.type, ql.sort, ql.limits, ql.required
      FROM questionnaire AS q
      INNER JOIN questionnaire_list ql ON ql.id_blank = q.id
      WHERE 1 ORDER BY ql.sort");
    while ($row = $res->fetch_assoc()) $result[] = $row;
    return $result;
}

$questionnaire = getQuestionnaire();
$questionnaire_name = $questionnaire[0]['name'];
$questionnaire_id = $questionnaire[0]['id'];
$header_text = $questionnaire[0]['header'];
$comment = $questionnaire[0]['comment'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Опрос</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!--<link href="extensions/bootstrap_5.1.3/bootstrap.min.css" rel="stylesheet">
    <script src="extensions/bootstrap_5.1.3/bootstrap.bundle.min.js"></script>
    <script src="extensions/jquery_3.6.0/jquery.min.js"></script>-->
  </head>
  <body>
    <div class="container-sm" style="max-width: 500px;">
      <div class="row" style="font-size: 1.3em; margin: 25px 15px;">
        <h1 class="mb-3 text-center"><?php echo $questionnaire_name; ?></h1>
        <p>Поставьте галочку и нажмите синюю кнопку <b>«ОТПРАВИТЬ»</b>.</p>
      <?php if (!isset($_POST['sent']) && !isset($_GET['stop'])): ?>
        <form action="/quiz.php" class="was-validated" method="post">
        <?php foreach ($questionnaire as $key => $value):
          $id_ql = $value['ql_id'];
          $value_limits = checkLimits($id_ql);
          $name_ql = $value['ql_name'];
          $required = '';
          if ($value['required'] === 1) {
            $required = 'required';
          }
          $kol_vo = '';
          $disabled = '';
          if ($value['limits'] && $value_limits && ($value_limits >= (int)$value['limits'])) {
            $disabled = 'disabled';
            $kol_vo = "Нужное количество набрано.";
          } else {
            $kol_vo_tmp = (int)$value['limits'] - $value_limits;
            $kol_vo = "Нужно ещё {$kol_vo_tmp} чел.";
          }

          if (!$value['limits']) {
            $kol_vo = "Лимит не установлен.";
          }

          if ($value['type'] === 'ch') {
            echo "<div class='form-check mb-2'><input type='checkbox' class='form-check-input' id='check{$id_ql}' name='{$id_ql}' value='1' {$required} {$disabled}>
            <label class='form-check-label' for='check{$id_ql}'><b>{$name_ql}</b></label>
            <span class='grey_text'>{$kol_vo}</span>";
          } elseif ($value['type'] === 'in') {
            echo "<p>{$header_text}</p>";
            echo "<p>{$comment}</p>";
            echo "<div class='mb-2'><input type='text' class='input-google' id='input{$id_ql}' placeholder='{$name_ql}' name='{$id_ql}' {$required} {$disabled}>";
          } ?>
          </div>
        <?php endforeach; ?>
        <input type="hidden" name="sent" value="<?php echo $questionnaire_id; ?>">
        <?php if ($questionnaire_id): ?>
        <span id="text_error"></span>
        <button type="submit" class="btn btn-primary btn-lg mt-3" disabled><b>ОТПРАВИТЬ</b></button>
        <?php endif; ?>
      </form>
      <?php endif; ?>
      <?php if (isset($_POST['sent'])): ?>
        <h3>Подождите <span class="spinner-border spinner-border-sm"></span></h3>
        <script>
        setTimeout(function () {
          window.location = "quiz.php?stop";
        }, 1000);
        </script>
      <?php endif; ?>
      <?php if (isset($_GET['stop'])): ?>
        <h3>Данные отправлены. Спасибо.</h3>
        <h6><a href="quiz">Вернуться к опросу.</h6>
      <?php endif; ?>
      </div>
    </div>
  </body>
  <script>
  function check_field_value() {
    let check = 0;
    $("input").each(function () {
      if ($(this).attr("type") === "checkbox") {
        if ($(this).prop("checked")) {
          check++;
        }
      } else if ($(this).attr("type") === "text") {
        if ($(this).val()) {
          check++;
        }
      }
    });
    if (check === 0) {
      $(".btn-primary").attr("disabled", true);
      $("#text_error").text("Заполните данные.");
    } else {
      $(".btn-primary").attr("disabled", false);
      $("#text_error").text("");
    }
  }
  $("input").change(function () {
    check_field_value();
  });
  $("input").keyup(function () {
    check_field_value();
  });
    // Проверка при отправки формы на лимит
  </script>
  <style>
  /* Стилизация полей ввода для модального окна */
  .form-check-input {
    border-radius: 0 !important;
  }
  .input-google {
    padding-left: 5px;
    width: 100%;
    border-radius: 0;
    border-top: none !important;
    border-left: none !important;
    border-right: none !important;
    border-bottom: 1px #198754 solid;
    box-shadow: none !important;
    font-weight: bold;
  }
  /* form starting stylings -------------------------------*/
  .input-google:focus {
    border-bottom: 2px #198754 solid;
    outline: none;
  }
  .grey_text {
    font-size: 14px;
    color: gray;
    display: block;
  }
  #text_error {
    color: red;
    display: block;
  }
  </style>
</html>
