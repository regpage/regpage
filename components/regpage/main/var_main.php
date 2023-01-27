<?php
// components
require_once 'components/ftt_blocks/FTT_Select_fields.php';
// db
require_once 'db/classes/member_properties.php';
require_once 'db/classes/access.php';

// Access
$global_isAdmin = Access::isAdmin($memberId);

if ($_SERVER['PHP_SELF'] === '/attend.php' && !$global_isAdmin) {
  header("Location: index");
}
