<?php

$start_time = microtime(TRUE);

include_once('page_layout.php');
include_once('d2view.php');
include_once('global.php');


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

function btos($b) {
    return  $b ? "yes" : "no";
}

head("Home");
navbar("home");


alert_exe($dota);
file_perms($dota);
$f=$dota;
for ($i=0; $i<6; $i++) {
    $f=dirname($f);
    file_perms($f);
}

// Homepage text
echo "<section class='welcome'>
      <p>Welcome to <em>d2view</em>, A
      <strong>DotA2</strong> local data viewer and
      quizz generator. You need a local installation of the game to
      use this.</p>
      <p>The first and only implemented feature as now is the
      <a href='explorer.php?pwd=/'>Explorer</a> that let's you
  explore the content of the game archive</p>
    </section>";

footer($start_time);

?>
