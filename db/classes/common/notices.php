<?php
/**
 *
 */
class Notices
{
  // check of a notice
  function checkNotice ($adminId)
  {
      $adminId = db_real_escape_string($adminId);
      $check;
      $notices = array();
      $res2=db_query ("SELECT `id`, `responsible` FROM contacts WHERE `responsible` = '$adminId' AND `notice` = 1");
      while ($row2 = $res2->fetch_assoc()) $notices[$row2['responsible']]=$row2['id'];

  // check
      if ($notices){
        return;
      } else {
        return 'display: none';
      }
  }
}
