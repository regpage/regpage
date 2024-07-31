<?php
// components
require_once 'components/ftt_blocks/FTT_Select_fields.php';
// db
require_once 'db/classes/member_properties.php';

if (THIS_PAGE === 'attend' && !IS_ZONE_ADMIN) {
  header("Location: index");
}
