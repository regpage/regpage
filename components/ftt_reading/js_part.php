<?php #print_r($bible_obj->getBooks()); ?>
<script>
// bible book
let bible_arr = [];
let bible_arr_temp = "<?php foreach ($bible_obj->getBooks() as $id => $name) {
  if ($id === 0) {
    echo $name[0].'_'.$name[1];
  } else {
    echo '_'.$name[0].'_'.$name[1];
  }
} ?>";
bible_arr_temp = bible_arr_temp ? bible_arr_temp.split('_') : [];
for (let i = 0; i < bible_arr_temp.length; i = i + 2) {
  bible_arr.push([bible_arr_temp[i], bible_arr_temp[i+1]]);
}

</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
<script src="/js/modules/date.js"></script>
<script src="/js/ftt/ftt_reading/script.js?v20"></script>
<script src="/js/ftt/ftt_reading/design.js?v8"></script>
