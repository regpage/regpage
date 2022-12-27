
<?php
if ($serviceone_role === 3 || ($is_recommendator == 1 && $request_data['stage'] > 1))
  include_once "components/ftt_application_page/recomend_part.php";

if ($serviceone_role === 3 || ($is_interviewer == 1 && $request_data['stage'] > 3))
  include_once "components/ftt_application_page/interview_part.php";

if ($serviceone_role === 3)
  include_once "components/ftt_application_page/decision_part.php";
?>
