<?php
/**
 * __construct($sessionId, $memberId) — конструктор записывает данные поля согласия в соответствующие свойства свойства 1(Да)/0(Нет или отсутствует)
 * getAgreementPersonalData() — Получить данные поля согласия для персональных данных заданного пользователя
 * getAgreementСookie() — Получить данные поля согласия для куки заданного пользователя
 * getAgreement($sessionId, string $memberId) — Получить все активные строки согласий с полями agree и type для заданного пользователя
 * dltAgreement($sessionId, string $memberId) — удаляет запись согласия по ключу пользователя, при отсутствии ключа по сессии
 */
class AgreementDB //extends DBQuery
{
  private $agreement = 0;
  private $cookie = 0;

  function __construct($sessionId, string $memberId='')
  {
    foreach ($this->getAgreements($sessionId, $memberId) as $value) {
      if ($value['type'] === 'cookie') {
        $this->cookie = $value['agree'];
      } else {
        $this->agreement = $value['agree'];
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

  static function setAgreement($isNew, $sessionId, string $userAgent, $ip, $agree, string $memberId='', string $fio='', $type='personal data', string $comment='', $trash=0)
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
      return db_query("UPDATE `agreement` SET `fio` = '{$fio}', `session_id` = '{$sessionId}', `user_agent` = '{$ip}', `agree` = '{$agree}', `date_agreement` = NOW(), `member_key` = '{$memberId}', `type` = '{$type}', `comment` = '{$comment}' WHERE {$condition} AND `trash` = '{$trash}'");
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
}
