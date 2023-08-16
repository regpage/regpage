<script>

// serving ones list
/*let serving_ones_list_tmp;
serving_ones_list_tmp = "<?php
$kbk_list = array_merge($serving_ones_list, $kbk_list);
foreach ($kbk_list as $id => $name) echo $id.'_'.$name.'_'; ?>";
*/
// full
serving_ones_list_full_tmp = "<?php foreach ($serving_ones_list_full as $id => $values) echo $id.'_'.$values[0].'_'.$values[1].'_'; ?>";
serving_ones_list_full_tmp = serving_ones_list_full_tmp ? serving_ones_list_full_tmp.split('_') : [];
let serving_ones_list_full = [];
for (let i = 0; i < serving_ones_list_full_tmp.length; i = i + 3) {
  serving_ones_list_full[serving_ones_list_full_tmp[i]] = {'name': serving_ones_list_full_tmp[i+1], 'male': serving_ones_list_full_tmp[i+2]};
}

// full
trainee_list_tmp = "<?php foreach ($trainee_list_full as $id => $value) echo $id.'_'.$value[0].'_'.$value[1].'_'.$value[4].'_'.$value[5].'_'; ?>";
trainee_list_tmp = trainee_list_tmp ? trainee_list_tmp.split('_') : [];
let trainee_list_full = [];
for (let i = 0; i < trainee_list_tmp.length; i = i + 5) {
  trainee_list_full[trainee_list_tmp[i]] = {'name': trainee_list_tmp[i+1], 'male': trainee_list_tmp[i+2], 'semester': trainee_list_tmp[i+3], 'time_zone': trainee_list_tmp[i+4]};
}
</script>
<script src="/js/ftt/ftt_fellowship/script.js?v1"></script>
<script src="/js/ftt/ftt_fellowship/design.js?v1"></script>
<script src="/js/modules/week.js?v1"></script>
<script src="/js/modules/time.js?v1"></script>
<script src="/js/modules/date.js?v1"></script>
<script src="/js/modules/blank.js?v1"></script>
