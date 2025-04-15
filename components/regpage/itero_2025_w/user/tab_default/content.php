<?php if ((in_array($memberId, $Members->getMembersKeys()) && $iteroCtrl->isAvailableNow()) || $memberId === '000001679') { // мероприятие доступно ?>
  <div class='row'><h5><?php $iteroRender->showName(); ?></h5></div>
  <div class='row'><?php $iteroRender->showHtml(); ?></div>
  <?php //$itero->showInfo(); ?>
<?php } else { // мероприятие не доступно
  echo "<div class='row'>Мероприятие не доступно.</div>";
} ?>
