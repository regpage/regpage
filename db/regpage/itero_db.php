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
  private function getEventDB($key) : array
  {
    return DBQuery::get('list', 'event', '*', 'key', $key);
  }

  function getEvent() : array
  {
    return $this->event[0];
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
  private function getMembersEventDB($key) : array
  {
    return DBQuery::get('arr', 'reg', 'member_key', 'event_key', $key);
  }

  function getMembersKeys() : array
  {
    return $this->membersKeys;
  }
}
