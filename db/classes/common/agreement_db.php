<?php
/**
 * __construct($sessionId, $memberId) — конструктор записывает данные поля согласия в соответствующие свойства свойства 1(Да)/0(Нет или отсутствует)
 * getAgreementPersonalData() — Получить данные поля согласия для персональных данных заданного пользователя
 * getAgreementСookie() — Получить данные поля согласия для куки заданного пользователя
 * getAgreementPersonalData($sessionId, string $memberId) — Получить все активные строки согласий с полями agree и type для заданного пользователя
 * dltAgreement($sessionId, string $memberId) — удаляет запись согласия по ключу пользователя, при отсутствии ключа по сессии
 */
class AgreementDB //extends DBQuery
{
  private $agreement = 2;
  private $cookie = 0;
  private $session_id = '';
  private $user_agent = '';

  function __construct($sessionId, string $memberId='')
  {
    foreach ($this->getAgreements($sessionId, $memberId) as $value) {
      if ($value['type'] === 'cookie') {
        $this->cookie = $value['agree'];
      } else {
        $this->agreement = $value['agree'];
        $this->user_agent = $value['user_agent'];
        $this->session_id = $value['session_id'];
      }
    }
  }
  function getAgreements($sessionId, string $memberId='') : array
  {
    $condition = $this->conditionBy($sessionId, $memberId);
    $result = [];
    $res = db_query("SELECT * FROM `agreement` WHERE {$condition} AND `trash` = 0");
    while ($row = $res->fetch_assoc()) $result[] = $row;
    return $result;
  }

  function setAgreement($isNew, $sessionId, string $userAgent, $ip, $agree, string $memberId='', string $fio='', $type='personal data', string $comment='', $trash=0)
  {
    $sessionId = db_real_escape_string($sessionId);
    $userAgent = db_real_escape_string($userAgent);
    $ip = db_real_escape_string($ip);
    $agree = db_real_escape_string($agree);
    $memberId = db_real_escape_string($memberId);
    $fio = db_real_escape_string($fio);
    $comment = db_real_escape_string($comment);
    $type = db_real_escape_string($type);
    $trash = db_real_escape_string($trash);

    if ($isNew) {
      return db_query("INSERT INTO `agreement`(`member_key`, `fio`, `session_id`, `ip`, `type`, `agree`, `date_agreement`, `user_agent`, `comment`, `trash`) VALUES
        ('{$memberId}', '{$fio}', '{$sessionId}', '{$ip}', '{$type}', '{$agree}', NOW(), '{$userAgent}', '{$comment}', '{$trash}')");
    } else {
      $condition = $this->conditionBy($sessionId, $memberId);
      return db_query("UPDATE `agreement` SET `fio` = '{$fio}', `session_id` = '{$sessionId}', `ip` = '{$ip}', `user_agent` = '{$userAgent}', `agree` = '{$agree}', `member_key` = '{$memberId}', `type` = '{$type}', `comment` = '{$comment}', `trash` = '{$trash}' WHERE {$condition} AND `trash` = 0");
    }
  }
  function dltAgreement($sessionId, string $memberId='')
  {
    $condition = $this->conditionBy($sessionId, $memberId);

    return db_query("DELETE FROM `agreement` WHERE {$condition}");
  }
  // условие: сессия или ключ участника
  function conditionBy($sessionId, string $memberId)
  {
    $sessionId = db_real_escape_string($sessionId);
    $memberId = db_real_escape_string($memberId);

    if (empty($memberId)) {
      return " `session_id` = '{$sessionId}' ";
    } else {
      return " `member_key` = '{$memberId}' ";
    }
  }
  function getAgreementPersonalData()
  {
    return $this->agreement;
  }
  function getAgreementСookie()
  {
    return $this->cookie;
  }
  function getSessionId()
  {
    return $this->session_id;
  }
  function getUserAgent()
  {
    return $this->user_agent;
  }
}
