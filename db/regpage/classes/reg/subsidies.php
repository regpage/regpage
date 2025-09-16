<?php
/**
 * ПОДДЕРЖКА В ПОЕЗДКАХ (ДОТАЦИИ)
 * в таблице event поле subsidies со значение по умолчанию 0 что значит что нет поддержки? другое положительное число означает на сколько человек  имееется поддержка
 *
 */

class Subsidies
{
  private $limit;
  private $currentCount;
  private $membersList;
  private $eventId;

  function __construct($eventId) {
    global $db;
    $eventId = $db->real_escape_string($eventId);
    // если дотации не предусмотрены
    $this->eventId = $eventId;
    $this->limit = $this->eventLimit();
    if ($this->limit == 0) { // !is_int($this->limit) || не работает заменить
      $this->membersList = [];
      $this->currentCount = 0;
      //if (!is_int($this->limit)) {
         //$this->limit = 0;
      //}
      //return;
    } else {
      $this->membersList = $this->membersList();
      $this->currentCount = count($this->membersList);
    }
  }

  // список братьев с дотацией
  function membersList($getAll=false)
  {
    $list = [];
    $condition = '';
    if (!$getAll) {
      $condition = ' AND `disregard` = 1 ';
    }
    $res = db_query("SELECT `member_key` FROM `subsidies` WHERE `event_key` = '{$this->eventId}' {$condition} ");
    while ($row = $res->fetch_assoc()) $list[$row['member_key']] = $row['member_key'];

    return $list;
  }

  function eventLimit()
  {
    $limit = 0;

    $res = db_query("SELECT `subsidies` FROM `event` WHERE `key` = '{$this->eventId}'");
    while ($row = $res->fetch_assoc()) return $row['subsidies'];

    //return $limit;
  }

  // добавление / удаление дотации
  function addMember($memberKey, $ticket) {
    $regstateKey = $this->getMemberRegStatus($memberKey);
    if ($this->isLimitReached() || empty($memberKey) || !$ticket || ($regstateKey !== '01' && $regstateKey !== '02' && $regstateKey !== '04')) {
      return false;
    }

    global $db;
    $memberKey = $db->real_escape_string($memberKey);
    $ticket = $db->real_escape_string($ticket);
    $isExist = $this->memberExist($memberKey);

    if (empty($isExist)) {
      $res = db_query("INSERT INTO `subsidies` (`event_key`, `member_key`) VALUES ('{$this->eventId}', '{$memberKey}')");
      if ($res) {
        return $this->currentCount++;
      }
    } else {
      return 'no changes';
    }
  }

  // массовое добавление дотации для пользователей по списку / все в таблице event для мероприятия с учётом лимита
  function bulkAddMembers($membersKeys = '') { //$memberKey, $ticket,
    // не должен обрабатываться общий скрипт случайна тк кто то может быть удалён с таблицы дотаций сознательно
    // УЧИТЫВАТЬ СТАТУС РЕФАКТОРИТЬ
    $list = [];

    if (empty($membersKeys)) {
      return 'error_001';
    } elseif ($membersKeys !== 'all') {
      $list = $this->getAllMembers($membersKeys);
    } else {
      $list = $this->getAllMembers();
    }

    foreach ($list as $value) {
      if ($this->isLimitReached()) {
        break;
      }
      $this->addMember($value['member_key'], !empty($value['flight_num_arr']));
    }

    // обновляем данные
    $this->membersList = $this->membersList();
    $this->currentCount = count($this->membersList);
  }

  // получить всех участников мероприятия
  function getAllMembers($membersKeys = '') {
    $membersKeys = $this->sanitizeAndPrepareStrWithComma($membersKeys);
    $condition = '';
    $list = [];

    if (!empty($membersKeys)) {
      $condition = "AND `member_key` IN ({$membersKeys})";
    }

    $res = db_query("SELECT `member_key`, `flight_num_arr` FROM `reg` WHERE `event_key` = '{$this->eventId}' {$condition}");
    while ($row = $res->fetch_assoc()) $list[$row['member_key']] = $row;

    return  $list;
  }

  // добавление / удаление дотации
  function dltMember($memberKey, $membersKeys='') {
    if (empty($memberKey)) {
      return 'error_001';
    }
    global $db;
    $memberKey = $db->real_escape_string($memberKey);
    $membersKeys = $this->sanitizeAndPrepareStrWithComma($membersKeys);

    $condition='';

    if ($memberKey === 'bulk' && !empty($membersKeys)) {
      $condition = "AND `member_key` IN ({$membersKeys})";
    } else {
      $condition = " AND `member_key`='{$memberKey}' ";
      if (empty($this->memberExist($memberKey))) {
        return 'no changes';
      }
    }

    $res = db_query("DELETE FROM `subsidies` WHERE `event_key` = '{$this->eventId}' {$condition}");
    if ($res && $memberKey !== 'bulk') {
      return $this->currentCount--;
    }
  }

  // без аргументов удаляет из субсидий тех кого нет в таблице рег (неперехваченная отмена регистрации)
  function bulkDltMembers($membersKeys='') {
    $result = [];

    if (empty($membersKeys)) {
      foreach ($this->checkMembers() as $value) {
        $result[] = $this->dltMember($value);
      }
    } else {
      $result[] = $this->dltMember('bulk', $membersKeys);
    }

    // обновляем данные
    $this->membersList = $this->membersList();
    $this->currentCount = count($this->membersList);

    return $result;
  }

  function sanitizeAndPrepareStrWithComma($membersKeys) {
    if (empty($membersKeys)) {
      return $membersKeys;
    }
    global $db;
    $membersKeysArr = explode(',', $membersKeys);
    $membersKeys = '';
    foreach ($membersKeysArr as $value) {
      $comma = ',';
      if (empty($membersKeys)) {
        $comma = '';
      }
      $membersKeys .= $comma . "'" . $db->real_escape_string($value) . "'";
    }
    return $membersKeys;
  }

  // проверка наличия субсидий для отменённых регистраций
  function checkMembers() {
    return array_diff_key($this->membersList(true), $this->getAllMembers());
  }


  // проверяем достигнут ли лимит
  function isLimitReached() {
    return $this->currentCount >= $this->limit;
  }
  // проверяем достигнут ли лимит
  function getLimit() {
    return $this->limit;
  }
  function getCount() {
    return $this->currentCount;
  }
  // записи льготников для мероприятия (1)
  function getMembersList() {
    return $this->membersList;
  }
  // все записи льготников для мероприятия включая игнорируемых (0)
  function getAllMembersList() {
    return $this->membersList(true);
  }
  // все записи для мероприятия
  function getAllMembersListEvent() {
    return $this->getAllMembers();
  }
  function getEventId() {
    return $this->eventId;
  }
  function memberExist($memberKey) {
    $isExist='';

    $res = db_query("SELECT `member_key` FROM `subsidies` WHERE member_key = '{$memberKey}' AND `event_key` = '{$this->eventId}'");
    while ($row = $res->fetch_assoc()) $isExist = $row['member_key'];

    return $isExist;
  }

  // проверка существующей записи
  function isBrother($memberKey) {
    $isBrother='';

    $res = db_query("SELECT `male` FROM `member` WHERE `key` = '{$memberKey}'");
    while ($row = $res->fetch_assoc()) $isBrother = $row['male'];

    return $isBrother;
  }

  // проверка существующей записи
  function getMemberRegStatus($memberKey) {
    $regstateKey='';

    $res = db_query("SELECT `regstate_key`  FROM `reg` WHERE `event_key` = '{$this->eventId}' AND `member_key` = '{$memberKey}'");
    while ($row = $res->fetch_assoc()) $regstateKey = $row['regstate_key'];

    return $regstateKey;
  }
}
