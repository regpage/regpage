<?php
/**
 * now_trainee($trainee_id) Возвращает список встреч на сегодня для обучающегося
 * now_serving_one($serving_one_id) Возвращает список встреч на сегодня для служащего
 */

class Fellowship
{
  function now_trainee($trainee_id)
  {
    $result=[];
    global $db;
    $trainee_id = $db->real_escape_string($trainee_id);
    $res = db_query("SELECT ff.time, m.name
      FROM ftt_fellowship ff
      LEFT JOIN member m ON m.key = ff.serving_one
      WHERE ff.trainee = '$trainee_id' AND ff.date = CURDATE()
      ORDER BY ff.time");
    while ($row = $res->fetch_assoc()) $result[] = $row;

    return $result;
  }

  function now_serving_one($serving_one_id)
  {
    $result=[];
    $res = db_query("SELECT ff.time, m.name
      FROM ftt_fellowship ff
      LEFT JOIN member m ON m.key = ff.trainee
      WHERE ff.serving_one = '$serving_one_id' AND ff.date = CURDATE()
      ORDER BY ff.time");
    while ($row = $res->fetch_assoc()) $result[] = $row;

    return $result;
  }
}
 ?>
