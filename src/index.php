<?php


include('D2view.php');


function navbar() {
    echo '<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home
          <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
    </ul>
  </div>
</nav>';
}

function alert($msg) {
    echo "<div class='alert alert-danger' role='alert'>$msg</div>";
}

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



/*
echo get_include_path();
echo ini_get('include_path');
*/



/*
$data = $vpk->read_file($dota.'pak01_000.vpk', 10000);
echo $data;
*/


// Based on https://stackoverflow.com/a/31685070
echo '<html><head>';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">';
echo '<link rel="icon" type="image/x-icon" href="../media/favicon.ico">';
echo '<link rel="stylesheet" type="text/css" href="style.css?5">';
echo '</head><body>';

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


echo '<div id="chaps">';

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

echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>';

echo '</body></html>';


?>
