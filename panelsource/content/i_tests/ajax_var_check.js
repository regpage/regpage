let files_names = [
        'activity_log.php', 'ajax.php', 'archive.php', 'attend_ajax.php', 'ch_statistic_ajax.php', 'contacts.php', 'contactsfetch.php', 'dashboard.php',
         'event.php', 'excelList.php', 'excelUpload.php','excelUpload2.php', 'excelUpload3.php', 'excelUploadCnt.php', 'ftt_ajax.php', 'ftt_announcement_ajax.php',
         'ftt_attendance_ajax.php', 'ftt_extra_help_ajax.php', 'ftt_fellowship_ajax.php','ftt_gospel_ajax.php', 'ftt_list_ajax.php', 'ftt_reading_ajax.php',
         'ftt_request_ajax.php', 'ftt_settings_ajax.php', 'ftt_template_ajax.php', 'get.php', 'guest.php','list.php', 'localities.php', 'localities2.php',
         'localities3.php', 'log_admins.php', 'login.php', 'meeting.php', 'members.php','practices.php', 'reference.php', 'set.php', 'setting.php', 'statistic.php',
         'visits.php', 'vtraining_ajax.php', 'youth.php'
    ];

$("#ajax_itest").click(function () {
  $(".test_monitor").text("AJAX itests");
  for (let i = 0; i < files_names.length; i++) {
    setTimeout(function() {
        fetch('ajax/' + files_names[i])
        .then(response => response.json())
        .then(commits => {
        console.log(commits);
        $(".test_monitor").append("X ");
       /*try {
  	       //
  	   } catch(Throwable ex)	{
    	//
  	   }*/
     });
    }, 100);
  }
});
