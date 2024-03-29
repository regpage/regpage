<?php
// Функции для работы с БД и классы
include_once "db/ftt/ftt_request_db.php";
include_once "components/ftt_blocks/FTTRenderPoints.php";
include_once 'db/classes/ftt_lists.php';
include_once 'db/classes/date_convert.php';
// служащий ПВОМ
/*$accessToPage = 0;
// Права
include_once "db/modules/ftt_page_access.php";

if ($accessToPage === 3 || $accessToPage === 4) {

} else {
  echo '<h1 style="margin-top: 70px; margin-left: 70px;">Пожалуйста, выберите другой раздел.</h1>';
  die();
}
*/
/**** Р О Л И  ****/
// Массив с данными заявления
$request_data;
// Ключ заявителя
$member_key;
// Заявитель
$applicant;
// Рекомендатор, служащий ПВОМ, собеседующий.
$serviceone_role = -1;
$is_recommendator;
$is_interviewer;
// Списки служащих ПВОМ
$serviceones_pvom = ftt_lists::serving_ones();
$brothers_in_church = db_getChurchLifeBrothers();
function oneToChecked($one)
{
  if ($one == 1) {
    echo 'checked';
  } else {
    echo '';
  }
}

// Заявитель или служащий (то есть не заявитель)
// если служащий
if (isset($_GET['member_key']) && $_GET['member_key'] !== $memberId) { // Если указан ключ участника
  $member_key = $_GET['member_key'];
  // get data
  $request_data = getMemberData($member_key);

  // если по КЛЮЧУ не найдено данных
  if (!$request_data['id']) { ?>
    <div><br><br><br><h5>Заявление не найдено</h5><a href="index">ВЕРНУТЬСЯ НА ГЛАВНУЮ</a></div>
    <?php
    die();
  }
  // Проверка на ответственного, что бы избежать попадания третьим лицам!!!
  // Определение роли служащего
  // Получаем служащих по зоне ПВОМ
  foreach ($serviceones_pvom as $key => $value) {
    if ($memberId === $key) {
      $serviceone_role = 3;
    }
  }
  if ($memberId === $request_data['recommendation_name']) {
    $is_recommendator = 1;
    if ($serviceone_role === -1) {
      $serviceone_role = 1;
    }
  } elseif ($memberId === $request_data['interview_name']) {
    $is_interviewer = 1;
    if ($serviceone_role === -1) {
      $serviceone_role = 2;
    }
  }
} else { // Если не указан ключ участника // Если заявитель
  $applicant = 1;
  $serviceone_role = 0;
  $member_key = $memberId;
  // get data
  $request_data = getMemberData($member_key);
  // если по КЛЮЧУ не найдено данных
  if (!$request_data['id']) {
    echo '<div><br><br><br><h5>Ваше заявление не найдено, отправьте заявку с главной страницы или обратитесь к служащим.</h5><a href="index">ВЕРНУТЬСЯ НА ГЛАВНУЮ</a></div>';
    die();
    // $request_data = getStartMemberData($member_key);
  }
}

// Проверка доступа

if ($serviceone_role === -1) {
  ?>
  <div><br><br><br><h5>Страница не найдена</h5><a href="index">ВЕРНУТЬСЯ НА ГЛАВНУЮ</a></div>
  <?php
  die();
}

// Is like guest
$is_guest = '';
if ((!$request_data['id'] && isset($_GET['guest'])) || $request_data['guest'] === '1') {
  $is_guest = 1;
}
$guest_text_h = '';
if ($is_guest) {
  $guest_text_h = 'в качестве гостя';
}


/**** ДАННЫЕ ****/
// Вопросы
$points = db_getRequestPoints();

/**** СПИСКИ ****/
// служащие братья на ПВОМ
$serviceones_pvom_brothers = ftt_lists::serving_ones_brothers();

// Get countries
$countries1 = db_getCountries(true);
$countries2 = db_getCountries(false);

// Get localities
$gl_localities = db_getLocalities();

// END VERSION 2

// START REFACTORING
/**** Д О П.   Д А Н Н Ы Е ****/
// ФИО рекомендатора
if ($request_data['recommendation_name']) {
  $recommendation_name = db_getAdminNameById($request_data['recommendation_name']);
}
// ФИО собеседующего
if ($request_data['interview_name']) {
  $interview_name = db_getAdminNameById($request_data['interview_name']);
}

// Payment data
$ftt_monthly_pay = getValueFttParamByName('monthly_pay');
$ftt_min_pay = getValueFttParamByName('min_pay');
$ftt_monthly_pay_eu = getValueFttParamByName('monthly_pay_dlr');
$ftt_min_pay_eu = getValueFttParamByName('min_pay_dlr');
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
  $application_prepare = $_COOKIE['application_prepare'];
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

// статус в заголовке предосмотра
$status_application_label = '<span class="badge badge-secondary">черновик</span>';

if ($request_data['stage'] > 0) {
  $date_send = date_convert::yyyymmdd_time_to_ddmmyyyy_time($request_data['send_date']);
  $date_send = explode(' ', $date_send);
  $status_phrase = "Заявление отправлено служащим Полновременного обучения в Москве {$date_send[0]} в {$date_send[1]}.";
} elseif ($request_data['stage'] == 0) {
  $status_phrase = '';
}

//Label
if ($request_data['stage'] == 1 || $request_data['stage'] == 2 || $request_data['stage'] == 3
|| $request_data['stage'] == 4 || $request_data['stage'] == 5) {
  $status_application_label = '<span class="badge badge-warning">на рассмотрении</span>';
} elseif ($request_data['stage'] == 6) {
  /*
  $text_decision_status;
  if ($request_data['decision'] === "approve") {
    $gl_gender_candidate ? $text_decision_status = 'принят' : $text_decision_status = 'принята';
    $status_application_label = "<span class='badge badge-success'>{$text_decision_status}</span>";
  } else {
    $gl_gender_candidate ? $text_decision_status = 'не принят' : $text_decision_status = 'не принята';
    $status_application_label = "<span class='badge badge-danger'>{$text_decision_status}</span>";
  }

  */
  $status_application_label = "<span class='badge badge-success'>Решение принято</span>";
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
