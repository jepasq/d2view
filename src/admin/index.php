<?php

$start_time = microtime(TRUE);

include_once('../page_layout.php');
//include_once('../d2view.php');
include_once('./global.php');

head("Admin");
navbar("admin");

footer($start_time);

?>
