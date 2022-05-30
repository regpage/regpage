// Радиокнопки из чекбоксов (ИЛИ)
  $("input:checkbox").click(function(){
	   if ($(this).is(":checked")) {
      $(this).parent("div").find("input:checkbox").not(this).prop("checked", false);
		  //$('#group input:checkbox').not(this).prop('checked', false);
	   }
  });
