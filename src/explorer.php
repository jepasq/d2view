<?php

$start_time = microtime(TRUE);

include_once('page_layout.php');
include_once('d2view.php');
include_once('global.php');
include_once('Breadcrumb.php');

$pwd = $_GET['pwd'];

if (empty($pwd)) {
    head("Explorer");
} else {
    head($pwd." - Explorer");
}
navbar("explorer");

echo "<section class='explorer-header'><p>Current working dir :";
$bc = new Breadcrumb($pwd);
$out = $bc->print();

echo "$out</p></section>";
echo "<section class='explorer'>
    <div class='explorer-content-header''>Content :</div>";

try {
    $d2 = new D2View($dota);
    $d2->listFiles($pwd);
    echo '</section>';
    echo '<section class="explorer-footer">';
    echo "<p>Total files :$d2->nb_files.</p>";
    echo '</section>';
} catch (VPKReader\Exception $e) {
    alert($e->getMessage());
}

footer($start_time);

?>
