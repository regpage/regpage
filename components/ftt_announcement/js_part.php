<script src="extensions/nicedit/nicEdit.js?v33"></script>
<?php if ($tab_three_active !== 'active'): ?>
<script>
// text editor nicEditor
if ($(window).width()<=769) {
  $("#announcement_text_editor").css("width", "335px");
}
bkLib.onDomLoaded(function() {
  new nicEditor().panelInstance("announcement_text_editor");
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
<script src="js/ftt/ftt_announcement/script.js?v33"></script>
<script src="js/ftt/ftt_announcement/design.js?v5"></script>
<?php endif; ?>
<?php if ($tab_three_active === 'active'): ?>
<script>
  // text editor nicEditor
  if ($(window).width()<=769) {
    $("#mdl_niceditor_field").css("width", "335px");
  }
  bkLib.onDomLoaded(function() {
    new nicEditor().panelInstance("mdl_niceditor_field");
  });
</script>
<script src="js/ftt/ftt_announcement/infoboard.js?v1"></script>
<?php endif; ?>
