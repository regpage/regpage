<?php if (!(in_array($memberId, $Members->getMembersKeys()) && $iteroCtrl->isAvailableNow())) {
  if ($memberId !== '000001679') {
    echo "<div class='row'>Страница не найдена.</div>";
    exit;
  }
} ?>

<div class='row'><h5><?php $iteroRender->showName(); ?></h5></div>
<div class='row'><?php $iteroRender->showHtml(); ?></div>
<?php //$itero->showInfo(); ?>
