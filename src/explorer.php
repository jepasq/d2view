<?php

$start_time = microtime(TRUE);

include_once('page_layout.php');
include_once('d2view.php');
include_once('global.php');

$pwd = $_GET['pwd'];

if (empty($pwd)) {
    head("Explorer");
} else {
    head($pwd." - Explorer");
}
navbar("explorer");


echo "<p>Current working dir : $pwd</p>";
echo "<p>Content :</p>";

try {
    $d2 = new D2View($dota);
    $d2->list_files($pwd);
    echo "<p>Total files :$d2->nb_files.</p>";
    echo '</div>';
} catch (VPKReader\Exception $e) {
    alert($e->getMessage());
}


footer($start_time);

?>
