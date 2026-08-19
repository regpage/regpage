<?php
// ITERO
require_once "db/classes/common/db_query.php";
/**
 *
 * получаем данные
 *
 */

class EventDB extends DBQuery
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
    if (isset($this->event[0])) {
      return $this->event[0];
    } else {
      return [];
    }
  }
}

/**
 *
 * получаем данные
 *
 */

class MembersEventDB extends DBQuery
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
