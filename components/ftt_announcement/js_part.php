<script src="extensions/nicedit/nicEdit.js"></script>
<script>
// text editor nicEditor
bkLib.onDomLoaded(function() {
  new nicEditor({fullPanel : true}).panelInstance("announcement_text_editor");
});
// списки
let recipients_group = [];
recipients_group["staff"] = [];
recipients_group["trainee_14"] = [];
recipients_group["trainee_56"] = [];
recipients_group["coordinators"] = [];

<?php
  foreach ($recipients_group as $key => $value) {
    foreach ($value as $key_2 => $value_2) {
      echo "recipients_group['{$key}']['{$key_2}'] = '{$value_2}'; ";
    }
  }

 ?>

</script>
<script src="js/ftt/ftt_announcement/script.js?v9"></script>
<script src="js/ftt/ftt_announcement/design.js?v2"></script>
