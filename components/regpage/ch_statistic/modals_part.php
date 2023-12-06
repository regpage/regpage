<!-- ADD | EDIT STATISTIC Modal -->
<div id="addEditStatisticModal" class="modal hide fade" data-width="500" tabindex="-1" role="dialog" aria-labelledby="regNameEdit" aria-hidden="true" data-status_val="" data-author="" data-archive="" data-period_start="" data-period_end="" data-id_statistic="">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 id="">Статистика <span id="periodId"></span></h4><strong style="float: right" id="adminShortName"></strong>
        <h5 id="">Период <span id="periodDate"></span></h5>
    </div>
    <div class="modal-body" style="height:auto !important">
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
          <div class="control-group row-fluid" id="desctopModalStatisticsBlank">
            <table class="table table-hover">
              <thead>
                <th style="text-align: center; vertical-align: middle"><a class="confirmFulfill">Заполнить из списка</a></th>
                <th style="text-align: center; vertical-align: middle"></th>
                <th style="text-align: center; vertical-align: middle"></th>
                <th style="text-align: center; vertical-align: middle">Всего</th>
                <th style="text-align: center; vertical-align: middle">В том числе школьников</th>
              </thead>
              <tbody>
                <tr>
                  <td style="text-align: center; vertical-align: middle">Крещены за полгода</td>
                  <td></td>
                  <td></td>
                  <td style="text-align: center; vertical-align: middle"><input type="number"  id="bptzAll" class="span10 check_valid_field field_desktop_mdl" min="0" data-name="Крещено"></td>
                  <td style="text-align: center; vertical-align: middle"><input type="number"  id="bptz17" class="span10 check_valid_field field_desktop_mdl" min="0" data-name="Крещено школьников"></td>
                  <!--<td style="text-align: center; vertical-align: middle"><input type="number"  id="bptz17_25" class="span10" min="0"></td>
                  <td style="text-align: center; vertical-align: middle"><input type="number"  id="bptz25" class="span10" min="0"></td>
                  -->
                </tr>
                <tr>
                  <td style="text-align: center; vertical-align: middle">Посещают собрания 12-17 лет</td>
                  <td style="text-align: center; vertical-align: middle">Посещают собрания 18-25 лет</td>
                  <td style="text-align: center; vertical-align: middle">Посещают собрания 26-60 лет</td>
                  <td style="text-align: center; vertical-align: middle">Посещают собрания старше 60 лет</td>
                  <td style="text-align: center; vertical-align: middle">Посещают собрания всего</td>
                </tr>
                <tr>
                  <td style="text-align: center; vertical-align: middle"><input type="number" id="attended17" class="span10 check_valid_field field_desktop_mdl" min="0" data-name="Посещают собрания 12-17 лет"></td>
                  <td style="text-align: center; vertical-align: middle"><input type="number"  id="attended17_25" class="span10 check_valid_field field_desktop_mdl" min="0" data-name="Посещают собрания 18-25 лет"></td>
                  <td style="text-align: center; vertical-align: middle"><input type="number"  id="attended25" class="span10 check_valid_field field_desktop_mdl" min="0" data-name="Посещают собрания 26-60 лет"></td>
                  <td style="text-align: center; vertical-align: middle"><input type="number"  id="attended60" class="span10 check_valid_field field_desktop_mdl" min="0" data-name="Посещают собрания старше 60 лет"></td>
                  <td style="text-align: center; vertical-align: middle"><input type="number"  id="attendedAll" class="span10 check_valid_field field_desktop_mdl" min="0" data-name="Посещают собрания всего" disabled></td>
                </tr>
                <tr>
                  <td colspan="4" style="text-align: right; vertical-align: middle">В среднем на трапезе</td>
                  <td style="text-align: center; vertical-align: middle"><input data-toggle="tooltip" title="Заполняется вручную!" type="number"  id="ltMeetingAverage" class="span10 check_valid_field field_desktop_mdl" min="0" data-name="В среднем на трапезе"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="" id="mblModalStatisticsBlank">
            <div>
              <div>
                <div style="text-align: center; vertical-align: middle"><a class="confirmFulfill">Заполнить из списка</a></div>
                <div style="text-align: center; vertical-align: middle">Крещены за полгода</div>
                <div style="text-align: center; vertical-align: middle">Всего</div>
                  <div style="text-align: center; vertical-align: middle"><input type="number"  id="bptzAllmbl" class="span10 check_valid_field field_mobile_mdl" min="0" data-name="Крещено"></div>
                <div style="text-align: center; vertical-align: middle">В том числе школьников</div>
                <div style="text-align: center; vertical-align: middle"><input type="number"  id="bptz17mbl" class="span10 check_valid_field field_mobile_mdl" min="0" data-name="Крещено школьников"></div>
              </div>
              <div>
                <div>
                  <div style="text-align: center; vertical-align: middle">Посещают собрания 12-17 лет</div>
                  <div style="text-align: center; vertical-align: middle"><input type="number" id="attended17mbl" class="span10 check_valid_field field_mobile_mdl" min="0" data-name="Посещают собрания 12-17 лет"></div>
                  <div style="text-align: center; vertical-align: middle">Посещают собрания 18-25 лет</div>
                  <div style="text-align: center; vertical-align: middle"><input type="number"  id="attended17_25mbl" class="span10 check_valid_field field_mobile_mdl" min="0" data-name="Посещают собрания 18-25 лет"></div>
                  <div style="text-align: center; vertical-align: middle">Посещают собрания 26-60 лет</div>
                  <div style="text-align: center; vertical-align: middle"><input type="number"  id="attended25mbl" class="span10 check_valid_field field_mobile_mdl" min="0" data-name="Посещают собрания 26-60 лет"></div>
                  <div style="text-align: center; vertical-align: middle">Посещают собрания старше 60 лет</div>
                  <div style="text-align: center; vertical-align: middle"><input type="number"  id="attended60mbl" class="span10 check_valid_field field_mobile_mdl" min="0" data-name="Посещают собрания старше 60 лет"></div>
                  <div style="text-align: center; vertical-align: middle">Посещают собрания всего</div>
                  <div style="text-align: center; vertical-align: middle"><input type="number"  id="attendedAllmbl" class="span10 check_valid_field field_mobile_mdl" min="0" data-name="Посещают собрания всего" disabled></div>
                </div>
                <div>
                  <div colspan="4" style="text-align: right; vertical-align: middle">В среднем на трапезе</div>
                  <div style="text-align: center; vertical-align: middle"><input data-toggle="tooltip" title="Заполняется вручную!" type="number"  id="ltMeetingAveragembl" class="span10 check_valid_field field_mobile_mdl" min="0" data-name="В среднем на трапезе"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="control-group row-fluid">
                <textarea id="comment" class="span12" placeholder="Поле для комментария" maxlength="500" ></textarea>
          </div>
        </div>
        <a href="#" id="btnDoDeleteStatistic">Удалить бланк статистики</a>
    </div>
    <div class="modal-footer">
        <label class="form-check-label" for="statisticCompleteChkbox" style="float: left"><input type="checkbox" id="statisticCompleteChkbox" class="" style="margin-bottom: 3px"> статистика заполнена</label>
        <button class="btn btn-info btnDoHandleStatistic">Сохранить</button>
        <button class="btn" id="cancelModalWindow" data-dismiss="modal" aria-hidden="true">Отмена</button>
    </div>
</div>
<!-- END ADD | EDIT STATISTIC Modal -->
<!-- YES | NO AUTOFULFILL Modal -->
<div id="autoFulfillModal" class="modal hide fade" data-width="400" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-status_val="" data-author="" data-archive="" data-periods="" data-id_statistic="">
    <div class="modal-header" style="height: 20px">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    </div>
    <div class="modal-body"style="height: 120px !important">
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
<!-- END -->

<!-- YES | NO DELETE BLANK -->
<div id="deleteStatisticBlankConfirm" class="modal hide fade" data-width="400" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-status_val="" data-author="" data-archive="" data-periods="" data-id_statistic="">
    <div class="modal-header" style="height: 20px">
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
<!-- END  -->

<!-- Message "no date birthday"  -->
<div id="modalBirthNamesList" class="modal hide fade" data-width="400" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-status_val="" data-author="" data-archive="" data-periods="" data-id_statistic="">
    <div class="modal-header" style="height: 20px">
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
<!-- END -->
