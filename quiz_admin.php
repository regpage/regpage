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

// получаем ответы из текстовых полей
function getIdTextField($id) {
  global $db;
  $id = $db->real_escape_string($id);
  $result = [];
  $res = db_query("SELECT `id`, `id_blank`, `name` FROM questionnaire_list WHERE `id_blank` = '$id' AND `type` = 'in' ORDER BY `id`");
  while ($row = $res->fetch_assoc()) $result[$row['id']] = $row['name'];

  $values = [];
  if (count($result) > 0) {
    foreach ($result as $key => $value) {
      $res2 = db_query("SELECT `id_list`, `value`, `date`  FROM questionnaire_data WHERE `id_list` = '$key'");
      while ($row = $res2->fetch_assoc()) $values[] = [$row['id_list'], $row['value'], $row['date'], $value];
    }
  }
  return $values;
}

$questionnaire = getQuestionnaire();
$questionnaire_name = $questionnaire[0]['name'];
$questionnaire_id = $questionnaire[0]['id'];
$header_text = $questionnaire[0]['header'];
$comment = $questionnaire[0]['comment'];
$value_text = getIdTextField($questionnaire_id);
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
        <?php foreach ($questionnaire as $key => $value):
          $point = $value['ql_name'];
          $limits = $value['limits'];
          $value['limits'] ? $limits = 'из '.$value['limits'].'.' : $limits = '';
          $total = checkLimits($value['ql_id']);
          echo "<p>{$point}: {$total} чел. {$limits}</p>";
          endforeach; ?>

          <?php
          $prev_field = '';
          foreach ($value_text as $key => $value):
          $field = $value[3];
          $value_text = $value[1];
          if ($prev_field !== $field ) {
            echo  "<h3>{$field}</h3>";
          }
          echo "<p>{$value_text}</p>";
          $prev_field = $field;
          endforeach; ?>
      </div>
      <button id="clear_data" class="btn btn-danger" style="margin-left: 110px;" type="button" name="button">Очистить форму</button>
    </div>
  </body>
  <script>
  $("#clear_data").click(function () {
    if (confirm("Удалить ответы из опроса?")) {
      fetch("quiz_ajax.php?type=delete")
      .then(response => response.text())
      .then(commits => {
        if (commits) {
          //location.reload();
        }
      });
    }
  });
  </script>
  <style>
  .grey_text {
    font-size: 14px;
    color: gray;
    display: block;
  }
  </style>
</html>
