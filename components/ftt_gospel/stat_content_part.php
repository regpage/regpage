<button id="report_modal_open" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#gospel_modal_statistic">Отчёт2</button>
<button id="report_modal_open" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#gospel_modal_statistic_personal">Отчёт3</button>
<div class="">
  <?php
 // Группы
 if ($ftt_access['group'] === 'staff') {
   foreach ($teamsList as $key => $value){
     echo '<div class="">';
     gospelStatFun($key, $teamsList, false);
     echo '</div>';
   }
 }

?>
<script>
  $("h5").click(function () {
    let text = $(this).text();
    if ($(this).next().hasClass("d-none")) {
      $(this).next().removeClass("d-none");
      $(this).text(text.replace("+","-"));      
    } else {
      $(this).next().addClass("d-none");
      $(this).text(text.replace("-","+"));
    }
  });
</script>

</div>
