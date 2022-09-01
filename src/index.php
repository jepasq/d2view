<?php


include('page_layout.php');
include('D2view.php');


function alert_exe($path) {
    if (!is_executable($path)) {
        alert("DotA directory (<em>'$path'</em>) has permissions errors. ".
              "You may have issues running this.");
    }
}

function file_perms($dir) {
    $r=is_readable($dir);
    $x=is_executable($dir);
    if (!($x&&$r)) {
        echo "<div class='perms'>";
        echo "Tested dir is  is <tt>$dir</tt>";
        echo "<br>&nbsp;&nbsp;is readable : ".   btos($r);
        //    echo "<br>&nbsp;&nbsp;is writable : ".   btos(is_writable($dir));
        echo "<br>&nbsp;&nbsp;is executable : ". btos($x);
        echo "</div>";
    }
}


head();
navbar();

$cfg = '../config.php';
if (file_exists($cfg)) {
    include($cfg);
} else {
    alert("<em>$cfg</em> file can't be found. You <b>must</b> create it.");
    exit(1);
}
$dota = "$home/.steam/steam/steamapps/common/dota 2 beta/game/dota/";


alert_exe($dota);
file_perms($dota);
$f=$dota;
for ($i=0; $i<6; $i++) {
    $f=dirname($f);
    file_perms($f);
}


function btos($b) {
    return  $b ? "yes" : "no";
}

try {
    $d2 = new D2View($dota);
    echo "<p>Total files :$d2->nb_files.</p>";
    echo '</div>';
} catch (VPKReader\Exception $e) {
    alert($e->getMessage());
}


footer();

?>
