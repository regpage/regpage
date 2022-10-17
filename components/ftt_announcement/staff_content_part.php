  <!-- announcement -->
  <div class="container">
    <div id="list_header" class="row border-bottom pb-2">
      <!--<select id="" class="form-control form-control-sm mr-2">
        <?php // FTT_Select_fields::rendering($serving_ones_list); ?>
      </select>-->
    </div>
    <div id="list_announcement" class="row">
      <div id="sample">
        <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
        <script type="text/javascript">
          bkLib.onDomLoaded(function() {
            new nicEditor({fullPanel : true}).panelInstance('announcement_editor');            
          });
        </script>
        <h4>
          Текст объявления
        </h4>
        <textarea id="announcement_editor" name="announcement_editor" style="width: 400px; height: 300px;"></textarea>
      </div>
    </div>
  </div>
