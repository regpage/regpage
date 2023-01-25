<div class="mt-5">
  <!-- Список подразделов -->
  <select class="controls span5 members-lists-combo" tooltip="Выберите нужный вам список здесь" style="margin-right: 7px;">
    <option value="members">Общий список</option>
    <option value="attend" selected>Список посещаемости</option>
    <option value="youth">Молодые люди</option>
    <option value="list">Ответственные за регистрацию</option>
    <?php if ($roleThisAdmin===2) { ?>
      <option value="activity">Активность ответственных</option>
    <?php } ?>
  </select>
</div>
