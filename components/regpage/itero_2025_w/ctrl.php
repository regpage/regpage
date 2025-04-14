<?php
// БД
require_once "db/regpage/itero_db.php";
/**
 * готовим данные
 *
 */
class EventCtrl
{
  private $html;
  private $accessStart;
  private $accessStop;
  private $key;
  private $name;
  private $info;

  // получаем  мероприятие по ключу
  function __construct(EventDB $event)
  {
    $data = $event->getEvent();
    $this->html = $data['html'];
    $this->accessStart = $data['access_start'];
    $this->accessStop = $data['access_stop'];
    $this->key = $data['key'];
    $this->name = $data['name'];
    $this->info = $data['info'];
  }
  function getHtml() : string
  {
    return $this->html;
  }
  function getAccessStart() : string
  {
    return $this->accessStart;
  }
  function getAccessStop() : string
  {
    return $this->accessStop;
  }
  function getKey() : string
  {
    return $this->key;
  }
  function getName() : string
  {
    return $this->name;
  }
  function getInfo() : string
  {
    return $this->info;
  }
}

/**
 *
 */
class EventRender
{
  private $htmlRender;
  private $nameRender;
  private $infoRender;
  function __construct(EventCtrl $event)
  {
    $this->htmlRender = $event->getHtml();
    $this->nameRender = $event->getName();
    $this->infoRender = $event->getInfo();
  }
  function showHtml() : void
  {
    echo $this->htmlRender;
  }
  function showName() : void
  {
    echo $this->nameRender;
  }
  function showInfo() : void
  {
    echo $this->infoRender;
  }
}

$iteroDB = new EventDB('20250010');
$iteroCtrl = new EventCtrl($iteroDB);
$iteroRender = new EventRender($iteroCtrl);
