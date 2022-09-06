<?php

$version="0.0.0-3";

// Based on https://stackoverflow.com/a/31685070
function head() {
    echo '<!DOCTYPE html><html><head>';
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">';
    echo '<link rel="icon" type="image/x-icon" href="../media/favicon.ico">';
    echo '<link rel="stylesheet" type="text/css" href="style.css?5">';
    echo '</head><body>';
}

function navbar() {
    echo '<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
  <a class="navbar-brand" href="#">d2view</a>
    <span class="version">'.$version.'</span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" 
    data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
    aria-label="Toggle navigation">
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
        <a class="nav-link" href="explorer.php?pwd=/">Explorer</a>
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


function footer() {
    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>';

    echo '</body></html>';
}

?>
