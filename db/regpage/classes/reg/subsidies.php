<?php
// ITERO
//require_once "db/classes/common/db_query.php";
/**
 *
 * получаем данные
 *
 */
/*
class EventDBTEMP extends DBQuery
{
  // получаем  мероприятие по ключу
  private $event;

  function __construct (string $key) {
    $this->event = $this->getEventDB($key);
  }
  private function getEventDB($key) : ?array
  {
    return DBQuery::get('list', 'event', '*', 'key', $key);
  }

  function getEvent() : ?array
  {
    //if (isset($this->event[0])) {
      return $this->event[0];
    // } else {
     return [];
    //}
  }
}
*/
/**
 *
 * получаем данные
 *
 */
/*
class MembersEventDBTEMP extends DBQuery
{
  // получаем  мероприятие по ключу
  private $membersKeys;

  function __construct(string $key) {
    $this->membersKeys = $this->getMembersEventDB($key);
  }
  private function getMembersEventDB($key) : ?array
  {
    //return DBQuery::get('arr', 'reg', 'member_key', 'event_key', $key); ['event_key', '=', $key, 'AND', 'regstate_key', '=', '04']
    // ДОБАВИТЬ МЕТОД В КЛАСС DBQuery В КОТОРЫЙ МОЖНО ПЕРЕДАТЬ УСЛОВИЕ ПРОИЗВОЛЬНОЙ СТРОКОЙ,
    // или передавать массивы с полями и значениями, следующий элемент в массиве должен передавать условие AND или OR
    $key = db_real_escape_string($key);
    $result = [];
    $res=db_query ("SELECT `member_key` FROM `reg` WHERE `event_key` = '{$key}' AND `regstate_key` = '04'");
    while ($row = $res->fetch_assoc()) $result[]=$row['member_key'];

    return $result;
  }

  function getMembersKeys() : ?array
  {
    return $this->membersKeys;
  }
}
*/
/**
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
  function membersList()
  {
    $list = [];

    $res = db_query("SELECT `member_key` FROM `subsidies` WHERE `event_key` = '{$this->eventId}'");
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

  // добавление / удаление дотации
  function bulkAddMembers() { //$memberKey, $ticket,
    // УЧИТЫВАТЬ СТАТУС РЕФАКТОРИТЬ
    $res = db_query("SELECT `member_key`, `flight_num_arr` FROM `reg` WHERE `event_key` = '{$this->eventId}'");
    while ($row = $res->fetch_assoc()) {
      if ($this->isLimitReached()) {
        break;
      }
      $this->addMember($row['member_key'], !empty($row['flight_num_arr']));
    }
    // обновляем данные
    $this->membersList = $this->membersList($this->eventId);
    $this->currentCount = count($this->membersList);
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
  function getMembersList() {
    return $this->membersList;
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

/*
  // количество записей
  function db_brothersDotationCheck($memberKey=false)
  {
    global $db;
    $memberKey = $db->real_escape_string($memberKey);
    $isExist = '';
    if ($memberKey) {
      $isExist = db_brothersDotationExist($memberKey);
    }
    $isFilled = 0;
    if (empty($isExist)) {
      $res = db_query("SELECT count(`member_key`) AS total FROM `brothers_dotation`");
      while ($row = $res->fetch_assoc()) $isFilled = $row['total'];
    } else {
      $isFilled = 'exist';
    }

    return $isFilled;
  }

  // братья с билетами
  function db_brothersHaveTicketsCount($eventKey = '20250013')
  {
    global $db;
    $eventKey = $db->real_escape_string($eventKey);
    $brothersHaveTickets = 0;
    $res = db_query("SELECT COUNT(r.member_key) AS total
      FROM reg r
      JOIN member m ON m.key = r.member_key
      WHERE r.flight_num_arr != ''  AND r.flight_num_dep != '' AND m.male = 1 AND r.event_key = '{$eventKey}'");
    while ($row = $res->fetch_assoc()) $brothersHaveTickets = $row['total'];


    return $brothersHaveTickets;
  }

  function db_brothersHaveTickets($eventKey = '20250013') {
    global $db;
    $eventKey = $db->real_escape_string($eventKey);
    $result = [];
    $res = db_query("SELECT `member_key` FROM `reg` WHERE `flight_num_arr` != ''  AND `flight_num_dep` != '' AND `event_key` = '{$eventKey}'");
    while ($row = $res->fetch_assoc()) $result[$row['member_key']] = $row['member_key'];

    return $result;
  }

  function db_brotherHaveTickets($memberKey, $eventKey = '20250013') {
    global $db;
    $memberKey = $db->real_escape_string($memberKey);
    $eventKey = $db->real_escape_string($eventKey);

    $result = '';
    $res = db_query("SELECT `member_key` FROM `reg` WHERE `member_key` = '{$memberKey}' AND `flight_num_arr` != '' AND `flight_num_dep` != '' AND `event_key` = '{$eventKey}'");
    while ($row = $res->fetch_assoc()) $result = $row['member_key'];

    return $result;
  }



  // пакетное добавление в таблицу дотаций
  function db_brothersDotationGroup($membersKeys, $eventId)
  {
    global $db;
    $membersKeys = $db->real_escape_string($membersKeys);
    $eventId = $db->real_escape_string($eventId);
    $membersKeys = explode(',', $membersKeys);
    foreach ($membersKeys as $value) {
      $isExist = db_brothersDotationExist($value);
      $isBrother = db_isBrother($value);
      if (empty($isExist) && $isBrother == 1) {
        $haveTickets = db_brotherHaveTickets($value);
        if (!empty($haveTickets)) {
          $isFilled = db_brothersDotationCheck();
          if ($isFilled < 80) {
            db_query("INSERT INTO `brothers_dotation` (`member_key`) VALUES ('{$value}')");
            return true;
          } else {
            return false;
          }
        }
      }
    }
  }
  */
}


/* BEGIN ПОДДЕРЖКА В ПОЕЗДКАХ */


// в таблице event должно быть поле со значение по умолчанию 0 что значит что нет поддержки другое положительное число означает наличие поддержки на указанное число человек


// Куплены билеты
/*
if (isset($_GET['type']) && $_GET['type'] === 'get_members_subsidies') {
    echo json_encode(["result"=> db_get_members_subsidies($_GET['event_key'])]);
    exit;
}

// Проверки наличия в таблице
if (isset($_GET['type']) && $_GET['type'] === 'get_members_subsidies_check') {
  if (isset($_GET['member_key'])) {
    echo json_encode(["result"=> db_memberSubsidiesCheck($_GET['member_key'])]);
  } else {
    echo json_encode(["result"=> db_brothersSubsidiesCheck()]);
  }
  exit;
}

if (isset($_GET['type']) && $_GET['type'] === 'brothers_subsidies') {
    echo json_encode(["result"=> db_brothersSubsidies($_GET['member_key'], $_GET['ticket'], $_GET['event_id'])]);
    exit;
}

if (isset($_GET['type']) && $_GET['type'] === 'brothers_subsidies_group') {
    echo json_encode(["result"=> db_brothersSubsidiesGroup($_GET['members_keys'], $_GET['event_id'])]);
    exit;
}

if (isset($_GET['type']) && $_GET['type'] === 'get_have_tickets_count') {
    // echo json_encode(["result"=> db_brothersSubsidiesCheck()]);
    echo json_encode(["result"=> db_ticketsCount($_GET['event_key'])]);
    exit;
}

if (isset($_GET['type']) && $_GET['type'] === 'get_have_tickets') {
    echo json_encode(["result"=> db_haveTickets()]);
    exit;
}
*/
/* END */
