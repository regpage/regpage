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
serving_ones_list_full_tmp = "<?php foreach ($serving_ones_list_full as $id => $values) echo $id.'_'.$values[0].'_'.$values[1].'_'.$values[2].'_'; ?>";
serving_ones_list_full_tmp = serving_ones_list_full_tmp ? serving_ones_list_full_tmp.split('_') : [];
let serving_ones_list_full = [];
for (let i = 0; i < serving_ones_list_full_tmp.length; i = i + 4) {
  serving_ones_list_full[serving_ones_list_full_tmp[i]] = {'name': serving_ones_list_full_tmp[i+1], 'male': serving_ones_list_full_tmp[i+2], 'gospel_team': serving_ones_list_full_tmp[i+3]};
}

// trainee list
let trainee_list_tmp = "<?php foreach ($trainee_list as $id => $name) echo $id.'_'.$name.'_'; ?>";
trainee_list_tmp = trainee_list_tmp ? trainee_list_tmp.split('_') : [];
let trainee_list = [];
for (let i = 0; i < trainee_list_tmp.length; i = i + 2) {
  trainee_list[trainee_list_tmp[i]] = trainee_list_tmp[i+1];
}

// full
trainee_list_tmp = "<?php foreach ($trainee_list_full as $id => $value) echo $id.'_'.$value[0].'_'.$value[1].'_'.$value[2].'_'.$value[3].'_'; ?>";
trainee_list_tmp = trainee_list_tmp ? trainee_list_tmp.split('_') : [];
let trainee_list_full = [];
for (let i = 0; i < trainee_list_tmp.length; i = i + 5) {
  trainee_list_full[trainee_list_tmp[i]] = {'name': trainee_list_tmp[i+1], 'male': trainee_list_tmp[i+2], 'gospel_group': trainee_list_tmp[i+3], 'gospel_team': trainee_list_tmp[i+4]};
}
// teams & groups
gospel_groups_tmp = "<?php if (is_array($gospel_groups)) foreach ($gospel_groups as $id => $value) echo $value['gospel_team'].'_'.$value['gospel_group'].'_'.$value['member_key'].'_'; ?>";
gospel_groups_tmp = gospel_groups_tmp ? gospel_groups_tmp.split('_') : [];
let gospel_groups = [];
for (let i = 0; i < gospel_groups_tmp.length; i = i + 3) {
  gospel_groups[i] = {'team': gospel_groups_tmp[i], 'group': gospel_groups_tmp[i+1], 'member_key': gospel_groups_tmp[i+2]};
}

// admin key
let admin_id_gl = "<?php echo $memberId;?>";


</script>
<script src="/js/ftt/ftt_gospel/script.js?v55"></script>
<script src="/js/ftt/ftt_gospel/designs.js?v12"></script>
