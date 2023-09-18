<script>
// bible book
let bible_arr = [];
let bible_arr_temp = "<?php foreach ($bible_obj->getBooks() as $id => $name) echo $name[0].'_'.$name[1].'_'; ?>";
bible_arr_temp = bible_arr_temp ? bible_arr_temp.split('_') : [];
for (let i = 0; i < trainee_list_tmp.length; i = i + 2) {
  bible_arr.push([bible_arr_temp[i], bible_arr_temp[i+1]]);
}
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
<script src="/js/ftt/ftt_reading/script.js?v3"></script>
<script src="/js/ftt/ftt_reading/design.js?v2"></script>
