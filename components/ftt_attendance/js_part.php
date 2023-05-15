<script>
let ftt_access_trainee = "<?php echo strval($ftt_access['ftt_service']); ?>";
ftt_access_trainee === 6 ? ftt_access_trainee = true : ftt_access_trainee = false;
let coordinator = "<?php echo $serving_trainee; ?>";
if (!ftt_access_trainee && coordinator) {
  ftt_access_trainee = true;
}
let trainee_access = false;
trainee_access = "<?php if ($ftt_access['group'] === 'trainee') { echo "1"; } ?>";

// serving ones list
let serving_ones_list_tmp = "<?php foreach ($serving_ones_list as $id => $name) echo $id.'_'.$name.'_'; ?>";
serving_ones_list_tmp = serving_ones_list_tmp ? serving_ones_list_tmp.split('_') : [];
let serving_ones_list = [];
for (let i = 0; i < serving_ones_list_tmp.length; i = i + 2) {
  serving_ones_list[serving_ones_list_tmp[i]] = serving_ones_list_tmp[i+1];
}
// full
serving_ones_list_full_tmp = "<?php foreach ($serving_ones_list_full as $id => $values) echo $id.'_'.$values[0].'_'.$values[1].'_'; ?>";
serving_ones_list_full_tmp = serving_ones_list_full_tmp ? serving_ones_list_full_tmp.split('_') : [];
let serving_ones_list_full = [];
for (let i = 0; i < serving_ones_list_full_tmp.length; i = i + 3) {
  serving_ones_list_full[serving_ones_list_full_tmp[i]] = {'name': serving_ones_list_full_tmp[i+1], 'male': serving_ones_list_full_tmp[i+2]};
}

// trainee list
let trainee_list_tmp = "<?php foreach ($trainee_list as $id => $name) echo $id.'_'.$name.'_'; ?>";
trainee_list_tmp = trainee_list_tmp ? trainee_list_tmp.split('_') : [];
let trainee_list = [];
for (let i = 0; i < trainee_list_tmp.length; i = i + 2) {
  trainee_list[trainee_list_tmp[i]] = trainee_list_tmp[i+1];
}
// full
trainee_list_tmp = "<?php foreach ($trainee_list_full as $id => $value) echo $id.'_'.$value[0].'_'.$value[1].'_'.$value[4].'_'.$value[5].'_'; ?>";
trainee_list_tmp = trainee_list_tmp ? trainee_list_tmp.split('_') : [];
let trainee_list_full = [];
for (let i = 0; i < trainee_list_tmp.length; i = i + 5) {
  trainee_list_full[trainee_list_tmp[i]] = {'name': trainee_list_tmp[i+1], 'male': trainee_list_tmp[i+2], 'semester': trainee_list_tmp[i+3], 'time_zone': trainee_list_tmp[i+4]};
}

// переход по ссылке
let link_pb = "<?php if (isset($_GET['pb'])) {echo $_GET['pb'];} else {echo '';}  ?>";

// admin key
let admin_id_gl = "<?php echo $memberId;?>";

function filterSkip() {
  $("#list_skip .skip_string").each(function () {
    let status = '';
    if ($("#flt_skip_done").val() === "0" && ($(this).attr("data-status") === "0" || $(this).attr("data-status") === "1")) {
      status = '0';
    } else if ($("#flt_skip_done").val() === "2" && $(this).attr("data-status") === "2") {
      status = '2';
    }

    if ((($('#flt_sevice_one_skip').val() === "_all_" || !$('#flt_sevice_one_skip').val()) || $('#flt_sevice_one_skip').val() === $(this).attr("data-serving_one"))
    && (($('#ftr_trainee_skip').val() === "_all_" || !$('#ftr_trainee_skip').val()) || $('#ftr_trainee_skip').val() === $(this).attr("data-member_key"))
    && ($("#flt_skip_done").val() === status)) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });  
}
filterSkip();
</script>
<script src="/js/ftt/ftt_attendance/script.js?v127"></script>
<script src="/js/ftt/ftt_attendance/design.js?v27"></script>
