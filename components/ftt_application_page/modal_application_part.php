<!-- MODAL WINDOWS  -->
<!-- Universal Info Modal -->
<!-- IF THE COOKIE WAS INSTALLED AS "NOT SHOW" CHANGE SHOW TO HIDE THE PAGES DURING LOADING"  -->
<div id="modalStartInfo" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="universalInfoTitle">Информация</h5>
      </div>
      <div class="modal-body"><div id="universalInfoText"><?php
       if ($serviceone_role === 3 ) {
        echo getValueFttParamByName("request_recommend_info");
        echo getValueFttParamByName("request_interview_info");
       } else {
        echo getValueFttParamByName("request_candidate_info");
       }
       ?></div></div>
      <div class="modal-footer">
        <div class="">
          <input type="checkbox" id="donotshowmethat" class="input-request" value="">
          <label title="Этот раздел также доступен в пункте справка." for="donotshowmethat">  больше не показывать эту страницу </label>
        </div>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">Прочитано</button>
      </div>
    </div>
  </div>
</div>

<!-- Удаление своего заявления  -->
<!-- Использовать как универсальное для окон подтверждения-->
<div id="modalDeleteMyRequest" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header pb-2 pl-2 pt-2 pr-2">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>
      <div class="modal-body">
        <h5>Удалить заявление?</h5>
      </div>
      <div class="modal-footer pb-2 pl-2 pt-2 pr-2">
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">ОТМЕНА</button>
        <button class="btn btn-sm btn-danger" id="btnMdlDeleteMyRequest" data-dismiss="modal" aria-hidden="true">УДАЛИТЬ</button>
      </div>
    </div>
  </div>
</div>

<!-- Отправить своё заявление  -->
<div id="modalSendMyRequest" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
      </div>-->
      <div class="modal-body">
        <h5>Заявление будет отправлено служащим Полновременного обучения в Москве и станет недоступным для редактирования.</h5>
      </div>
      <div class="modal-footer">
        <div class="">
        </div>
        <button class="btn btn-sm btn-secondary" data-dismiss="modal" aria-hidden="true">ОТМЕНА</button>
        <button class="btn btn-sm btn-success" id="btnMdlSendMyRequest" data-dismiss="modal" aria-hidden="true">ОТПРАВИТЬ</button>
      </div>
    </div>
  </div>
</div>

<!-- ОКНО ИНФОРМАЦИИ -->
<div id="modal_info" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="mb-0">Справка</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="container pl-0 pr-0">
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
