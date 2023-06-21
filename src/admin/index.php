<?php

$start_time = microtime(TRUE);

function show_value($var, $val) {
    echo "$var : $val<br>";
}

include_once('../page_layout.php');
//include_once('../d2view.php');
include('./global.php');

head("Admin");
navbar("admin");

alert("This page could show sensitive informations. <br>".
"Please be sure you protected access to this page with a password.");

echo "<secion>";
show_value("Home directory", $home);
show_value("Dota directory", $dota);
show_value("Extraction directory", $extractdir);
echo "</secion>";

footer($start_time);

?>
