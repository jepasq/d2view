<?php

$start_time = microtime(TRUE);

include_once('page_layout.php');
include_once('d2view.php');
include_once('global.php');

$file = $_GET['file'];
$type = $_GET['type']; // Used to force type ?


function getFileType($filename) {
    $path_parts = pathinfo($filename);
    return $path_parts['extension'];
}

if (empty($file)) {
    head("Viewer");
} else {
    head($file." - Viewer");
}
navbar("viewer");

if (empty($file) && empty($type)) {
    alert("This file viewer can be hard to use directly as a standalone
        feature. You may want to use it from the explorer instead.");
} else {
    echo "<section class='exporer-header'>";
    echo "Currently viewing : $file <br>";
    $type = getFileType($file);
    echo "File type :  $type <br>";
    echo "</section>";
}

Echo "Viewer :<br>";

$d2 = new D2View($dota);
$content = $d2->get_file($file);
echo $content;

footer($start_time);

?>
