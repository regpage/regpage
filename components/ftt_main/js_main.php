<script>
  // serving ones list
  let serving_ones_list_tmp = "<?php foreach ($serving_ones_list as $id => $name) echo $id.'_'.$name.'_'; ?>";
  serving_ones_list_tmp = serving_ones_list_tmp ? serving_ones_list_tmp.split('_') : [];
  let serving_ones_list = [];
  for (let i = 0; i < serving_ones_list_tmp.length; i = i + 2) {
    serving_ones_list[serving_ones_list_tmp[i]] = serving_ones_list_tmp[i+1];
  }

  // trainee list
  let trainee_list_tmp = "<?php foreach ($trainee_list as $id => $name) echo $id.'_'.$name.'_'; ?>";
  trainee_list_tmp = trainee_list_tmp ? trainee_list_tmp.split('_') : [];
  let trainee_list = [];
  for (let i = 0; i < trainee_list_tmp.length; i = i + 2) {
    trainee_list[trainee_list_tmp[i]] = trainee_list_tmp[i+1];
  }

  // trainee_access
  let ftt_access_trainee = "<?php echo strval($ftt_access['ftt_service']); ?>";
  ftt_access_trainee === 6 ? ftt_access_trainee = true : ftt_access_trainee = false;
  let coordinator = "<?php echo $serving_trainee; ?>";
  if (!ftt_access_trainee && coordinator) {
    ftt_access_trainee = true;
  }
  let trainee_access = false;
  trainee_access = "<?php if ($ftt_access['group'] === 'trainee') { echo "1"; } ?>";

  // admin key
  let admin_id_gl = "<?php echo $memberId;?>";
</script>
