<?php

$start_time = microtime(TRUE);

include_once('../page_layout.php');
//include_once('../d2view.php');
include_once('./global.php');

head("Admin");
navbar("admin");

alert("This page could show sensitive informations. <br>".
"Please be sure you protected access to this page with a password.");


footer($start_time);

?>
