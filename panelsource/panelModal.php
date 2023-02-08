<!-- Modal windows for panel-->

<!-- START Modal SPINNER -->
<div id="modalSpinnerPanel" class="modal" style="background-color: rgba(255, 255, 255, 0.3);" >
  <div class="modal-dialog">
    <div class="modal-content" style="border: none; background: none;" >
      <div class="modal-body">
        <div id="saveSpinner" style="margin: 30% 50%; width: 3rem; height: 3rem;" class="spinner-border text-primary"></div>
      </div>
    </div>
  </div>
</div>
<!-- STOP Modal SPINNER -->

<!-- START Modal status statistics contact -->
  <div id="statuWindowStatistic" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Статистика по статусам</h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        </div>
        <div class="modal-body">
          <div id="tableStatStatisticsPrint" class="row" style="max-height:400px; overflow-y: auto; padding-left: 7px;">
            <table  style="width:760px;">
              <thead>
                <tr class="tbl-statistics-header"><th class="bg-light">Что?</th><th>Сколько?</th></tr>
              </thead>
              <tbody id="listStatStatistics">
              </tbody>
            </table>
          </div>
        </div>
          <div class="modal-footer">
            <button id="printStatusesStatistics" class="btn  btn-sm btn-warning">Печать</button>
            <button class="btn  btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Закрыть</button>
          </div>
        </div>
      </div>
    </div>
<!-- STOP Modal status statistics contact -->

<!-- START confirm universal Modal -->
  <div id="modalUniversalConfirm" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="modalUniversalTitle">?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        </div>
        <div class="modal-body">
          <div id="modalUniversalText" class="">
            ?
          </div>
        </div>
          <div class="modal-footer">
            <button id="modalUniversalOK" class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true">Да</button>
            <button class="btn  btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Отмена</button>
          </div>
        </div>
      </div>
    </div>
<!-- STOP confirm universal Modal -->
<!--  Modal windows for panel Stop -->
