<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/ftt_request_db.php";
// Подключаем ведение лога
include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Получаем страну по местности
if(isset($_GET['locality_key']) && $_GET['type'] === 'get_country_by_locality') {
    echo json_encode(["result"=>db_getCountryByLocality($_GET['locality_key'])]);
    exit();
}

// Сохранение полей при заполнении заявления
if(isset($_GET['type']) && $_GET['type'] === 'set') {
    if ($_GET['table'] === 'member') {
      $set_table = $_GET['table'];
    } else {
      $set_table = 'ftt_request';
    }
    echo json_encode(["result"=>setRequestField($adminId, $_GET['field'], $_GET['data'], $_GET['id'], $set_table, $_GET['guest'])]);
    exit();
}

// Сохранение полей с картинками при заполнении заявления
if(isset($_GET['type']) && $_GET['type'] === 'set_blob') {
    if (isset($_FILES['blob'])) {
		    $target_file = 'img/'.basename($_FILES['blob']['name']);
	      move_uploaded_file($_FILES['blob']['tmp_name'],$target_file);
	       $blo = 'ajax/'.$target_file;
	  } else {
		    $blo = 'none';
	  }
    echo json_encode(["result"=>setRequestField($adminId, $_GET['field'], $blo, $_GET['id'], 'ftt_request', $_GET['guest'], $_GET['next_blob'])]);
    exit();
}

// Удаление заявления
if(isset($_GET['type']) && $_GET['type'] === 'delete_request') {
    echo json_encode(["result"=>db_deleteRequest($_GET['id'])]);
    exit();
}

// Переместить заявление в корзину
if(isset($_GET['type']) && $_GET['type'] === 'to_trash_request') {
    echo json_encode(["result"=>db_setTrashForRequest($_GET['id'])]);
    exit();
}

// Удалить картику из заявления
if(isset($_GET['type']) && $_GET['type'] === 'delete_pic') {
    echo json_encode(["result"=>db_deletePicFromRequest($_GET['id'],$_GET['field'])]);
    exit();
}

// Получить картику из заявления
if(isset($_GET['type']) && $_GET['type'] === 'get_pic') {
    echo json_encode(["result"=>db_getPicForRequest($_GET['id'],$_GET['field'])]);
    exit();
}

// Отправление заявление
if(isset($_GET['type']) && $_GET['type'] === 'to_send_request') {
    echo json_encode(["result"=>db_setStatusRequestToSent($_GET['id'])]);
    exit();
}

// Отправление рекомендации
if(isset($_GET['type']) && $_GET['type'] === 'recommendation') {
    echo json_encode(["result"=>db_setStatusRequestToSent($_GET['id'], 3)]);
    exit();
}

/**/
?>
