<?php
// сам этот файл - контроллер
// db
require_once 'model/config/config.php';
require_once 'model/regpage/calls/manager/query.php';
// modules
require_once 'controllers/modules/utilits/short_name.php';

cntrlCallUsersPage(getCallsUsers());
