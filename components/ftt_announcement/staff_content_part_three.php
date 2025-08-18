<!-- Электронная доска
Здесь должен быть список активных позиций экрана по категориям с предорсмотром содержания в строке по клику открывается позиция
ССУО — Тема и неделя такие то
ЖИ — Название и главы такие то
Стихи — такие то
-->
<ul id="announcement_nav_tabs" class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#announcement_tab_2">
      Входящие <?php echo "<sup style='color: red;'> <b> {$announcement_unread_count}</b></sup>"; ?>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#announcement_tab_1">Исходящие </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php echo $tab_three_active; ?>" data-toggle="tab" href="#announcement_tab_3">Эл. доска </a>
  </li>
</ul>
<br>
<!-- Tab panes -->
<div id="" class="tab-content">
  <div class="row pb-2">
    <div class="col-md-2">
      <b>Блок</b>
    </div>
    <div class="col-md-10">
      <b>Содержание</b>
    </div>
  </div>
  <hr class="my-0">
<?php
 foreach (fttInfoboard::getToday() as $key => $value): ?>
  <?php
  // заменить на исправленный cutString
  /*if (mb_strlen($value['topic']) > 82) {
    $shortTopic = mb_substr($value['topic'], 0, 82).'...';
  } else {
    $shortTopic = $value['topic'];
  } */?>
  <div class="row list_str py-2" data-id="<?php echo $value['id'] ?>" data-type="<?php echo $value['type'] ?>">
    <div class="col-md-2 col-12">
      <?php echo $types[$value['type']]; ?>
    </div>
    <div class="col-md-10 col-12">
      <?php echo $value['text']; ?>
    </div>
  </div>
  <hr class="my-0">
<?php endforeach; ?>
</div>
