<!-- Статистика благовестия -->
<div id="gospel_modal_statistic" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="mb-0">Статистика благовестия</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col">
              <b>Понедельная статистика благовестия по группам (со среды по вторник):</b><br><br>
              <?php
              if ($ftt_access['group'] === 'staff') {
                foreach ($teamsList as $key => $value){
                  echo "<h5>$value</h5>";
                  gospelStatFun($key, $teamsList);
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- Статистика благовестия личная -->
<div id="gospel_modal_statistic_personal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="mb-0">Персональная статистика благовестия</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col">
              <b>Понедельная статистика благовестия персональная (со среды по вторник):</b><br><br>
              <?php
              if ($ftt_access['group'] === 'staff') {
                foreach ($teamsList as $key => $value){
                  gospelStatFunPersonal($key, $teamsList);
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
