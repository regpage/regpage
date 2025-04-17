<?php if ((in_array($memberId, $Members->getMembersKeys()) && $iteroCtrl->isAvailableNow()) || ($memberId === '000001679' || $memberId === '000002178' || $memberId === '000003029' || $memberId === '000002395' || $memberId === '000003220' || $memberId === '000002845')) { // мероприятие доступно ?>
  <div class='row'><div class='col'><h4><?php $iteroRender->showName(); ?></h4></div></div>
  <?php $iteroRender->showHtml(); ?>
  <?php //$itero->showInfo(); ?>
<?php } else { // мероприятие не доступно
  echo "<div class='row'>Мероприятие не доступно.</div>";
} ?>
