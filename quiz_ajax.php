<?php
include_once 'db.php';
// удаляем данные
function delete_data() {
    global $db;
    //$id = $db->real_escape_string($id);
    $res = db_query("DELETE FROM questionnaire_data WHERE 1");

    return $res;
}

  delete_data();

 ?>
