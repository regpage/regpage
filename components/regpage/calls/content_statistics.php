<div class="row">
  <div id="statistics_list" class="container pl-0 ml-0">
    <!-- заголовки колонок -->
    <div class="row pb-2 border-bottom d-none d-sm-flex">
      <div class="col-2">
        <b>Служащие</b>
      </div>
      <div class="col text-right">
        <b>Всего</b>
      </div>
      <div class="col text-right">
        <b>Входящие</b>
      </div>
      <div class="col text-right">
        <b>Недозвон</b>
      </div>
      <div class="col text-right">
        <b>Ошибка</b>
      </div>
      <div class="col text-right">
        <b>Отказ</b>
      </div>
      <div class="col text-right">
        <b>Повтор</b>
      </div>
      <div class="col text-right">
        <b>Уточнение</b>
      </div>
      <div class="col text-right">
        <b>Заказ</b>
      </div>
    </div>
    <?php foreach (CallsDB::getStatisticsCalls($fltAllUsers, $dateBegin, $dateEnd) as $key => $value): ?>
      <div class="row call_stat_str">
        <?php if ($value['name'] !== 'Всего обработано заявок'): ?>
          <div class="col-10 col-sm-2">
            <?php echo $value['name'] ?>
          </div>
          <div class="col text-right font-weight-bold">
            <?php $sum = $value['incomming'] + $value['no_answer'] + $value['error'] + $value['refused'] + $value['reply'] + $value['specify'] + $value['order'];
            echo $sum; ?>
          </div>
          <div class="col text-right d-none d-sm-block">
            <?php echo $value['incomming'] ?>
          </div>
          <div class="col text-right d-none d-sm-block">
            <?php echo $value['no_answer'] ?>
          </div>
          <div class="col text-right d-none d-sm-block">
            <?php echo $value['error'] ?>
          </div>
          <div class="col text-right d-none d-sm-block">
            <?php echo $value['refused'] ?>
          </div>
          <div class="col text-right d-none d-sm-block">
            <?php echo $value['reply'] ?>
          </div>
          <div class="col text-right d-none d-sm-block">
            <?php echo $value['specify'] ?>
          </div>
          <div class="col text-right d-none d-sm-block">
            <?php echo $value['order'] ?>
          </div>
        <?php endif; ?>
        <?php if ($value['name'] === 'Всего обработано заявок'): ?>
          <div class="col-12">
            <?php echo $value['name'] . ' — ' . $value['incomming'] ?>
          </div>
          <div class="col-12">
            <?php echo $value['no_answer'] . ' — ' . $value['error'] ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>
