<?php
// Ajax
include_once "ajax.php";
// подключаем запросы
include_once "../db/classes/db_operations.php";
include_once "../db/ftt/ftt_request_db.php";
include_once "../db/classes/localities.php";
require_once "../db/classes/emailing.php";
// Подключаем ведение лога
include_once "../extensions/write_to_log/write_to_log.php";

$adminId = db_getMemberIdBySessionId (session_id());

if (!$adminId) {
    header("HTTP/1.0 401 Unauthorized");
    exit;
}

// Получаем страну по местности
if(isset($_GET['locality_key']) && $_GET['type'] === 'get_country_by_locality') {
    echo json_encode(["result"=>localities::db_getCountryByLocality($_GET['locality_key'])]);
    exit();
}

// Сохранение полей при заполнении заявления
if(isset($_GET['type']) && $_GET['type'] === 'set') {
  $data_post = false;
  if (isset($_POST['data_post'])) {
    $data_post = $_POST['data_post'];
  }
    echo json_encode(["result"=>setRequestField($adminId, $_GET['field'], $_GET['data'], $_GET['id'], $_GET['table'], $_GET['guest'], false, $data_post)]);
    exit();
}

// Сохранение полей с картинками при заполнении заявления
if(isset($_GET['type']) && $_GET['type'] === 'set_blob') {
    if (isset($_FILES['blob'])) {
      // check
      $target_file_temp = explode(".", $_FILES['blob']['name']);
      $fileExtension = strtolower(end($target_file_temp));
      $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png', 'webp', 'bmp', 'zip', 'rar', '7z', 'txt', 'xls', 'xlsx', 'doc', 'docx', 'odt', 'ods', 'rtf', 'pdf');
      if (!in_array($fileExtension, $allowedfileExtensions)) {
        echo json_encode(["result"=>'Неизвестный формат файла.']);
        exit();
      }
      // save
		  $target_file = 'img/'.time().basename($_FILES['blob']['name']);
	    move_uploaded_file($_FILES['blob']['tmp_name'],$target_file);
	    $blo = 'ajax/'.$target_file;
      // compress
      $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png', 'webp', 'bmp');
      if (in_array($fileExtension, $allowedfileExtensions)) {
        $imagick = new Imagick(__DIR__ . '/' . $target_file);
        $data = $imagick->identifyImage();
        if ($data['mimetype'] === 'image/jpeg' && $imagick->getImageLength() > 500000 && $imagick->getImageLength() < 2000000){
          $imagick->setCompression(Imagick::COMPRESSION_JPEG);
          $imagick->setImageCompressionQuality(60);
          $imagick->writeImage(__DIR__ . '/' . $target_file);
        } elseif ($data['mimetype'] === 'image/jpeg' && $imagick->getImageLength() >= 2000000 && $imagick->getImageLength() <= 5000000){
          $imagick->setCompression(Imagick::COMPRESSION_JPEG);
          $imagick->setImageCompressionQuality(50);
          $imagick->writeImage(__DIR__ . '/' . $target_file);
        } elseif ($data['mimetype'] === 'image/jpeg' && $imagick->getImageLength() > 5000000) {
          $imagick->setCompression(Imagick::COMPRESSION_JPEG);
          $imagick->setImageCompressionQuality(40);
          $imagick->writeImage(__DIR__ . '/' . $target_file);
        }
      }
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
    if (isset($_GET['type_dlt']) && $_GET['type_dlt'] === 'trash') {
      echo json_encode(["result"=>db_setTrashForRequest($_GET['id'])]);
    } else {
      echo json_encode(["result"=>db_deleteRequest($_GET['id'])]);
    }
    exit();
}

// Удалить картику из заявления
if(isset($_GET['type']) && $_GET['type'] === 'delete_pic') {
    $file = explode('ajax/', $_GET['patch']);
    if (isset($file[1]) && !empty($file[1])) {
      unlink($file[1]);
    }
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

// Отправление рекомендации СТАРЫЙ КОД /* */
if(isset($_GET['type']) && $_GET['type'] === 'recommendation') {
    echo json_encode(["result"=>db_setStatusRequestToSent($_GET['id'], 3)]);
    exit();
}

// Отправление рекомендации
if(isset($_GET['type']) && $_GET['type'] === 'set_status') {
    echo json_encode(["result"=>db_setStatusRequestToSent($_GET['id'], $_GET['status'], $adminId)]);
    exit();
}

// get ftt param
if(isset($_GET['type']) && $_GET['type'] === 'get_ftt_param') {
    echo json_encode(["result"=>getValueFttParamByName($_GET['param'])]);
    exit();
}

if(isset($_GET['type']) && $_GET['type'] === 'universal_set') {
    // Сохранение изменений в полях бланка
    // готовим данные
    $db_data = new DbData('set', $_GET['table']);
    $db_data->set('field', $_GET['field']);
    $db_data->set('value', $_GET['value']);
    $db_data->set('condition_field', $_GET['condition_field']);
    $db_data->set('condition_value', $_GET['condition']);
    if ($_GET['changed'] === "1") {
      $db_data->set('changed', 1);
    }

    // запрос
    echo json_encode(['result'=>DbOperation::operation($db_data->get())]);
    exit();
}
/**/
?>
