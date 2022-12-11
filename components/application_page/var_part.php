<?php
// Функции для работы с БД
include_once "db/ftt/ftt_request_db.php";
include_once "components/ftt_blocks/FTTRenderPoints.php";

/**** Р О Л И  ****/
/*
$hasMemberRightToSeePage = db_isAdmin($memberId);
*/

// BEGIN VERSION 2
$points = db_getRequestPoints();
// END VERSION 2
// Массив с данными заявления
$request_data;
// Ключ заявителя
$member_key;
// Заявитель
$applicant;
// Дающий рекомендация
$serviceone_role = -1;
// ключ служащего
$serviceones_pvom;

// Заявитель или служащий (то есть не заявитель)
// если служащий
if (isset($_GET['member_key']) && $_GET['member_key'] !== $memberId) { // Если указан ключ участника
  $member_key = $_GET['member_key'];
  // get data
  $request_data = getMemberData($member_key);
  // если по КЛЮЧУ не найдено данных
  if (!$request_data['fr_id']) {
    ?>
    <div><br><br><br><h5>Заявление не найдено</h5><a href="index">ВЕРНУТЬСЯ НА ГЛАВНУЮ</a></div>
    <?php
    die();
  }
  // Проверка на ответственного, что бы избежать попадания третьим лицам!!!
  // Определение роли служащего
  if ($memberId === $request_data['recommendation_name']) {
    $serviceone_role = 1;
  } elseif ($memberId === $request_data['interview_name']) {
    $serviceone_role = 2;
  } else {
    // Получаем служащих по зоне ПВОМ
    // НУЖНА ФУНКЦИЯ ДЛЯ ПОЛУЧЕНИЕ СЛУЖАЩИХ БРАТЬЕВ НА ПВОМ
    /*foreach ( SOME_VAR as $key => $value) {
      if ($memberId === $key) {
        $serviceones_pvom[$key] = $value;
        $serviceone_role = 3;
      }
    }*/
  }
} else { // Если не указан ключ участника // Если заявитель
  $applicant = 1;
  $serviceone_role = 0;
  $member_key = $memberId;
  // get data
  $request_data = getMemberData($member_key);
  // если по КЛЮЧУ не найдено данных
  if (!$request_data['fr_id']) {
    $request_data = getStartMemberData($member_key);
  }
}

// Проверка доступа
if ($serviceone_role === -1) {
  ?>
  <div><br><br><br><h5>Заявление не найдено</h5><a href="index">ВЕРНУТЬСЯ НА ГЛАВНУЮ</a></div>
  <?php
  die();
}

// Is like guest
$is_guest = '';
if ((!$request_data['fr_id'] && isset($_GET['guest'])) || $request_data['guest'] === '1') {
  $is_guest = 1;
}

/**** Д О П.   Д А Н Н Ы Е ****/
// ФИО рекомендатора
if ($request_data['recommendation_name']) {
  $recommendation_name = db_getAdminNameById($request_data['recommendation_name']);
}
// ФИО собеседующего
if ($request_data['interview_name']) {
  $interview_name = db_getAdminNameById($request_data['interview_name']);
}


// Get countries
$countries1 = db_getCountries(true);
$countries2 = db_getCountries(false);

// Get localities
$gl_localities = db_getLocalities();

// Payment data
$ftt_monthly_pay = getValueFttParamByName('monthly_pay');
$ftt_min_pay = getValueFttParamByName('min_pay');
$ftt_consecration = getValueFttParamByName('consecration');

/**** П Р А В И Л А ****/
// Кнопка возврата
if (isset ($_COOKIE['application_back']) && $_COOKIE['application_back'] === '1') {
  $btn_close = 'ftt';
} else {
  $btn_close = 'index';
}

$application_prepare = '';
if (isset ($_COOKIE['application_prepare']) && $_COOKIE['application_prepare'] === '1') {
  $application_prepare = 1;
}

/**** П О Д Г О Т О В К А   Н Е К О Т О Р Ы Х   Д А Н Н Ы Х ****/
// Birth date correct
if ($request_data['birth_date']) {
  //$birth_date = explode('-', $request_data['birth_date']);
  //$birth_date = $birth_date[0].'-'.$birth_date[2].'-'.$birth_date[1];
  $birth_date = $request_data['birth_date'];
} else {
  $birth_date = $request_data['birth_date'];
}

// Age
if ($request_data['age'][1] == 0 || ($request_data['age'][1] > 4 && $request_data['age'][1] <= 9)) {
  $age_word = 'лет';
} elseif ($request_data['age'][1] == 1) {
  $age_word = 'год';
} elseif ($request_data['age'][1] > 1 && $request_data['age'][1] < 5) {
  $age_word = 'года';
} else {
  $age_word = 'лет';
}

// Baptized date
if ($request_data['baptized'] && $request_data['baptized'] !== '0000-00-00') {
  $baptized_date = explode('-', $request_data['baptized']);
  $baptized_date = $baptized_date[2].'.'.$baptized_date[1].'.'.$baptized_date[0];
} else {
  $baptized_date= $request_data['baptize_date'];
}

// Request date
if ($request_data['request_date']) {
  $request_date = explode(' ', $request_data['request_date']);
  $request_date = $request_date[0];
} else {
  $request_date = '';
}

// TP date
if ($request_data['tp_date']) {
  $tp_date = explode('-', $request_data['tp_date']);
  $tp_date = $tp_date[0].'-'.$tp_date[2].'-'.$tp_date[1];
} else {
  $tp_date = '';
}

// Информация об иждевенцах и их содержании
if ($request_data['support_info']) {
  $support_info = explode(';', $request_data['support_info']);
  $support_info_part1 = $support_info[0];
  $support_info_part2 = $support_info[1];
  $support_info_part3 = $support_info[2];
  $support_info_part4 = $support_info[3];
  $support_info_part5 = $support_info[4];
  $support_info_part6 = $support_info[5];
  $support_info_part7 = $support_info[6];
  $support_info_part8 = $support_info[7];
  $support_info_part9 = $support_info[8];
  $support_info_part10 = $support_info[9];
  $support_info_part11 = $support_info[10];
  $support_info_part12 = $support_info[11];
  $support_info_part_who = $support_info[12];
} else {
  $support_info_part1 = '';
  $support_info_part2 = '';
}
// скрывать или показывывать дату отправки заявления после отправки заявления. Дата заполняется автоматически.
$status_application;
$status_application_show = 'style="display: none;"';

$gl_gender_candidate = $request_data['male'];

if ($request_data['male'] == 1) {
  $razveden = 'разведен';
  $vdova = 'вдовец';
  $suprug = 'супруги';
  $who = 'Она';
  $ego = 'её';
  $verujuschiy = 'верующая';
  $v_brake = 'женат';
  $pomolvlen = 'помолвлен';
  $vashego = 'вашей';
} else {
  $razveden = 'разведена';
  $vdova = 'вдова';
  $suprug = 'супруга';
  $who = 'Он';
  $ego = 'его';
  $verujuschiy = 'верующий';
  $v_brake = 'замужем';
  $pomolvlen = 'помолвлена';
  $vashego = 'вашего';
}

// статус в заголовке предосмотра
$status_application_label = '<>';

if ($request_data['request_status'] > 1) {
  $status_phrase = "Заявление отправлено служащим Полновременного обучения в Москве {$request_data['send_date']}.";
} elseif ($request_data['request_status'] == 1) {
  $status_phrase = getValueFttParamByName('request_bottom');
}
// POLICY AGREE
if ($request_data["agreement"] == 1) {
  $agreement = "checked";
} else {
  $agreement = "";
}

// SKANS AND PDF
$img_link_spouse_consent;
$img_scan_1;
$img_scan_2;
$img_scan_3;

if (isset($request_data['spouse_consent'])) {
  $img_temp = explode('.', $request_data['spouse_consent']);
  if ($img_temp[1] === 'pdf' || $img_temp[1] === 'Pdf' || $img_temp[1] === 'PDF') {
    $img_link_spouse_consent = 'img/pdf.jpeg';
  } else {
    $img_link_spouse_consent = $request_data['spouse_consent'];
  }
}
if (isset($request_data['passport_scan'])) {
  $img_temp = explode('.', $request_data['passport_scan']);
  if ($img_temp[1] === 'pdf' || $img_temp[1] === 'Pdf' || $img_temp[1] === 'PDF') {
    $img_scan_1 = 'img/pdf.jpeg';
  } else {
    $img_scan_1 = $request_data['passport_scan'];
  }
}
if (isset($request_data['passport_scan_2'])) {
  $img_temp = explode('.', $request_data['passport_scan_2']);
  if ($img_temp[1] === 'pdf' || $img_temp[1] === 'Pdf' || $img_temp[1] === 'PDF') {
    $img_scan_2 = 'img/pdf.jpeg';
  } else {
    $img_scan_2 = $request_data['passport_scan_2'];
  }
}
if (isset($request_data['passport_scan_3'])) {
  $img_temp = explode('.', $request_data['passport_scan_3']);
  if ($img_temp[1] === 'pdf' || $img_temp[1] === 'Pdf' || $img_temp[1] === 'PDF') {
    $img_scan_3 = 'img/pdf.jpeg';
  } else {
    $img_scan_3 = $request_data['passport_scan_3'];
  }
}
//$request_data['passport_scan'];
?>
