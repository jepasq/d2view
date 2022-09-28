<?php

$start_time = microtime(TRUE);

include_once('page_layout.php');
include_once('d2view.php');
include_once('global.php');

$path = $_GET['path'];
$type = $_GET['type'];

if (empty($path)) {
    head("Viewer");
} else {
    head($path." - Viewer");
}
navbar("viewer");

if (empty($path) && empty($type)) {
    alert("This file viewer can be hard to use directly as a standalone
        feature. You may want to use it from the explorer instead.");
}


footer($start_time);

?>
