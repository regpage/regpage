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
  private $access;
  private $key;
  private $name;
  private $info;

  // получаем  мероприятие по ключу
  function __construct(EventDB $event)
  {
    $data = $event->getEvent();
    $this->html = $data['html'];
    if (!$data['access_start']) {
      $this->accessStart = '';
    } else {
      $this->accessStart = $data['access_start'];
    }
    if (!$data['access_stop']) {
      $this->accessStop = '';
    } else {
      $this->accessStop = $data['access_stop'];
    }
    $this->key = $data['key'];
    $this->name = $data['name'];
    $this->info = $data['info'];
    if (!empty($this->accessStart) && strtotime($this->accessStart) <= strtotime(date('Y-m-d')) && ((!empty($this->accessStop) && strtotime(date('Y-m-d')) <= strtotime($this->accessStop)) || empty($this->accessStop))) {
      $this->access = true;
    } else {
      $this->access = false;
    }
  }
  function getHtml() : string
  {
    return $this->html;
  }
  function getAccessStart(bool $rus = false) : ?string
  {
    if (!empty($this->accessStart) && $rus) {
      $date = date_create($this->accessStart);
      return date_format($date, 'd.m.Y');
    } else {
      return $this->accessStart;
    }
  }
  function getAccessStop(bool $rus = false) : ?string
  {
    if (!empty($this->accessStop) && $rus) {
      $date = date_create($this->accessStop);
      return date_format($date, 'd.m.Y');
    } else {
      return $this->accessStop;
    }
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
  function isAvailableNow() : bool
  {
    // доступы
    return $this->access;
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

$Members = new MembersEventDB('20250010');
$iteroDB = new EventDB('20250010');
$iteroCtrl = new EventCtrl($iteroDB);
$iteroRender = new EventRender($iteroCtrl);
