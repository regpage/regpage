<!-- ADD | EDIT STATISTIC Modal -->
<div id="addEditStatisticModal" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" data-status_val="" data-author="" data-archive="" data-period_start="" data-period_end="" data-id_statistic="">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header pt-2 pb-2">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    </div>
    <div class="modal-body" style="height:auto !important">
      <h4 id="">Статистика <span id="periodId"></span></h4>
      <strong id="adminShortName"></strong>
      <h5 id="">Период <span id="periodDate"></span></h5>
        <div class="desctop-visible tablets-visible">
            <div class="control-group row-fluid">
                <div style="margin-bottom: 5px">
                  <select id="statisticLocalityModal">
                      <?php
                          foreach ($localities as $id => $name) {
                              echo "<option value='$id' ". ($id == $singleLocality || $isSingleCity ? 'selected="selected"' :   '') ." >".htmlspecialchars ($name)."</option>";
                            }
                              ?>
                  </select>
                  <select id="localityStatus" class="col-sm">
                    <?php
                      foreach ($localityStatus as $id => $name) {
                        echo "<option value='$id'>$name</option>";
                      }
                      ?>
                  </select>
                </div>
          </div>
          <div class="" id="desctopModalStatisticsBlank">
              <div>
                <div style="text-align: center; vertical-align: middle"><button class="confirmFulfill">Заполнить из списка</button></div>
                <div style="text-align: center; vertical-align: middle">Всего</div>
                <div style="text-align: center; vertical-align: middle"><input type="number"  id="bptzAll" class="check_valid_field field_desktop_mdl" min="0" data-name="Крещено"></div>
                <div style="text-align: center; vertical-align: middle">В том числе школьников</div>
                <div style="text-align: center; vertical-align: middle"><input type="number"  id="bptz17" class="check_valid_field field_desktop_mdl" min="0" data-name="Крещено школьников"></div>
              </div>
              <div>
                <div>
                  <div style="text-align: center; vertical-align: middle">Крещены за полгода</div>
                  <!--<td style="text-align: center; vertical-align: middle"><input type="number"  id="bptz17_25" class="span10" min="0"></td>
                  <td style="text-align: center; vertical-align: middle"><input type="number"  id="bptz25" class="span10" min="0"></td>-->
                </div>
                <div>
                  <div style="text-align: center; vertical-align: middle">Посещают собрания 12-17 лет</div>
                  <div style="text-align: center; vertical-align: middle"><input type="number" id="attended17" class="check_valid_field field_desktop_mdl" min="0" data-name="Посещают собрания 12-17 лет"></div>
                  <div style="text-align: center; vertical-align: middle">Посещают собрания 18-25 лет</div>
                  <div style="text-align: center; vertical-align: middle"><input type="number"  id="attended17_25" class="check_valid_field field_desktop_mdl" min="0" data-name="Посещают собрания 18-25 лет"></div>
                  <div style="text-align: center; vertical-align: middle">Посещают собрания 26-60 лет</div>
                  <div style="text-align: center; vertical-align: middle"><input type="number"  id="attended25" class="check_valid_field field_desktop_mdl" min="0" data-name="Посещают собрания 26-60 лет"></div>
                  <div style="text-align: center; vertical-align: middle">Посещают собрания старше 60 лет</div>
                  <div style="text-align: center; vertical-align: middle"><input type="number"  id="attended60" class="check_valid_field field_desktop_mdl" min="0" data-name="Посещают собрания старше 60 лет"></div>
                  <div style="text-align: center; vertical-align: middle">Посещают собрания всего</div>
                  <div style="text-align: center; vertical-align: middle"><input type="number"  id="attendedAll" class="check_valid_field field_desktop_mdl" min="0" data-name="Посещают собрания всего" disabled></div>
                </div>
                <div>
                  <div style="text-align: center; vertical-align: middle">В среднем на трапезе</div>
                  <div style="text-align: center; vertical-align: middle"><input data-toggle="tooltip" title="Заполняется вручную!" type="number"  id="ltMeetingAverage" class="check_valid_field field_desktop_mdl" min="0" data-name="В среднем на трапезе"></div>
                </div>
              </div>
          </div>
          <div style="text-align: center; vertical-align: middle"><textarea id="comment" class="mt-2" placeholder="Поле для комментария" maxlength="500" ></textarea></div>
        </div>
        <a href="#" id="btnDoDeleteStatistic">Удалить бланк статистики</a>
    </div>
    <div class="modal-footer">
        <label class="form-check-label" for="statisticCompleteChkbox" style="float: left"><input type="checkbox" id="statisticCompleteChkbox" class="" style="margin-bottom: 3px"> статистика заполнена</label>
        <button class="btn btn-info btnDoHandleStatistic">Сохранить</button>
        <button class="btn" id="cancelModalWindow" data-dismiss="modal" aria-hidden="true">Отмена</button>
    </div>
    </div>
  </div>
</div>
<!-- END ADD | EDIT STATISTIC Modal -->
<!-- YES | NO AUTOFULFILL Modal -->
<div id="autoFulfillModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-status_val="" data-author="" data-archive="" data-periods="" data-id_statistic="">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header pt-2 pb-2">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    </div>
    <div class="modal-body">
        <div class="desctop-visible tablets-visible">
          <div class="control-group row-fluid">
            <div style="margin-bottom: 5px">
              <p class="text-center">
                <strong>На странице “Список” должны быть отмечены:</strong><br>
                все, кто посещает собрания, и у них<br>
                должна быть указана дата рождения.<br>
                У крещённых школьников должна быть<br>
                указана дата крещения.<br>
                Эти условия выполнены?
              </p>
            </div>
          </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-info btnDoHandleFulfillStatistic">Да</button>
        <button class="btn" id="cancelModalWindow" data-dismiss="modal" aria-hidden="true">Нет</button>
    </div>
    </div>
  </div>
</div>
<!-- END -->

<!-- YES | NO DELETE BLANK -->
<div id="deleteStatisticBlankConfirm" class="modal hide fade" data-width="400" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-status_val="" data-author="" data-archive="" data-periods="" data-id_statistic="">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header pt-2 pb-2">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    </div>
    <div class="modal-body"style="height: 40px !important">
        <div class="desctop-visible tablets-visible">
          <div class="control-group row-fluid">
            <div style="margin-bottom: 5px">
              <p class="text-center">
                <strong>Удалить бланк статистики?</strong>
              </p>
            </div>
          </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger btnDoConfirmDeleteStatistic">Удалить</button>
        <button class="btn" id="cancelModalWindow" data-dismiss="modal" aria-hidden="true">Отмена</button>
    </div>
    </div>
  </div>
</div>
<!-- END  -->

<!-- Message "no date birthday"  -->
<div id="modalBirthNamesList" class="modal hide fade" data-width="400" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-status_val="" data-author="" data-archive="" data-periods="" data-id_statistic="">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header pt-2 pb-2">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    </div>
    <div class="modal-body"style="height: 150px !important">
        <div class="desctop-visible tablets-visible">
          <div class="control-group row-fluid">
            <div style="margin-bottom: 5px">
              <p class="text-center">
                <strong id="msgNoDateBirth"></strong>
              </p>
              <div id="noBirthNamesList" >
              </div>
              <p class="text-center">
                <strong id="msgNoBaptizeSchoolboy"></strong>
              </p>
              <div id="noBaptizeNamesList" >
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" id="" data-dismiss="modal" aria-hidden="true">Ок</button>
    </div>
    </div>
  </div>
</div>
<!-- END -->
