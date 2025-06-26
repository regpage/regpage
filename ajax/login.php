<?php
include_once "ajax.php";

header('Content-type: text/plain');

if(isset($_GET["logout"])){
    if (isset($_GET["memberId"]) && isset($_GET['sessionId'])){
        db_logoutAdmin ($_GET['memberId'], $_GET['sessionId']);
    }
    exit();
}
else if(isset($_GET["logout_total"])){
    if (isset($_GET["memberId"])){
        db_logoutAdminTotal ($_GET['memberId']);
    }
    exit();
}
else if (isset($_GET["signup"])) {
  require_once '../db/classes/common/agreement_db.php';
    $res = db_signUpMember(session_id(), $_GET['signupLogin'], $_GET['password'], $_GET['name'],  $_GET['birthDate'], $_GET['gender'], $_GET['citizenship'], $_GET['locality'], $_GET['newLocality']);

    if($res){
        db_loginUserByLogin (session_id(), $_GET['signupLogin']);
    }
    exit();
}
else if(isset($_GET['remove_account'])){
    db_removeAccount($_POST['member'], $_POST['reason']);

    exit();
}
else if (isset($_GET["login"]) && isset($_GET["password"])) {
    $memberId = db_loginAdmin (session_id(), $_GET["login"], $_GET["password"]);
    // проверка согласия
    if ($memberId) {
      require_once '../db/classes/common/agreement_db.php';
      $AgreementCheck = new AgreementDB(session_id(), $memberId);
      if ($AgreementCheck->getAgreementPersonalData() > 1) {
        $AgreementCheck->setAgreement(true, session_id(), $_SERVER['HTTP_USER_AGENT'], $_SERVER['REMOTE_ADDR'], 1, $memberId, db_getMemberNameMate($memberId), 'personal data', 'Добавлены данные при входе');
      } elseif ($AgreementCheck->getAgreementPersonalData() == 1 && (empty($AgreementCheck->getSessionId()) || empty($AgreementCheck->getUserAgent()))) {
        $AgreementCheck->setAgreement(false, session_id(), $_SERVER['HTTP_USER_AGENT'], $_SERVER['REMOTE_ADDR'], 1, $memberId, db_getMemberNameMate($memberId), 'personal data', 'Добавлены данные сессии при входе');
      }
    }

    print $memberId ? "success" : "error" ;
}
else if (isset($_GET["signupLogin"])) {
    $email = ($_GET["signupLogin"]);
    $memberId = db_isAdminExist ($email);

    if(isset($_GET["password"])){
        if(!$memberId){
            UTILS::sendConfirmationEmailToCreateAccount($email, $_GET);
        }
    } else {
        print !$memberId ? "success" : "error";
    }
}
else if(isset($_GET['checklogin'])){
    $memberId = db_isAdminExist ($_GET['checklogin']);
    print !$memberId ? "new" : "existing";
    exit();
}
?>
