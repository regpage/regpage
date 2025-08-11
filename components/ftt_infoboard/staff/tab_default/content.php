<?php
// Здесь должен быть список активных позиций экрана по категориям с предорсмотром содержания в строке по клику открывается позиция
// типа ССУО — Тема и неделя такие то
// типа ЖИ — Название и главы такие то
// типа Стихи — такие то

 foreach (fttInfoboard::getToday() as $key => $value): ?>
  <?php
  // заменить на исправленный cutString
  /*if (mb_strlen($value['topic']) > 82) {
    $shortTopic = mb_substr($value['topic'], 0, 82).'...';
  } else {
    $shortTopic = $value['topic'];
  } */?>
  <div class="row list_str pl-1 mr-0" data-id="<?php echo $value['id'] ?>">
    <div class="col-md-1 col-2">
      <?php // echo date_convert::yyyymmddhhmmss_to_ddmm($value['date']); ?>
    </div>
    <div class="col-md-2 col-10 pr-0">

    </div>
    <div class="col-md-1 col-2 text-right">

    </div>
    <div class="col-md-7 col-10">

    </div>
     <div class="col-md-1 col-12">

    </div>
  </div>
  <hr class="my-0">
<?php endforeach; ?>
