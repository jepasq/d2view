<?php

define("VERSION", "0.0.0-10");
define("APPNAME", "d2view");

// Based on https://stackoverflow.com/a/31685070
function head($title) {
    echo '<!DOCTYPE html><html><head>';
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">';
    echo '<link rel="icon" type="image/x-icon" href="../media/favicon.ico">';
    echo '<link rel="stylesheet" type="text/css" href="style.css?v11">';
    if (empty($title)) {
        echo "<title>".APPNAME."</title>";
    } else {
        echo "<title>$title - ".APPNAME."</title>";
    }
    echo '</head><body>';
}

function navbar_item($active, $label, $href) {
    if ($active) {
        echo '<li class="nav-item active">';
    } else {
        echo '<li class="nav-item">';
    }
    echo "<a class='nav-link' href='$href'>$label</a></li>";

}

/** Print the navbar code
 *
 *  \param $active_item The activate item slug (one of 'home', 'explorer'
 *                      etc...).
 *
 */
function navbar($active_item) {
    echo '<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <img type="image/x-icon" src="../media/favicon.ico" class="brandicon">
        <a class="navbar-brand" href="/">
            <span>d2view</span>
            <span class="version">v'.VERSION.'</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" 
        data-target="#navbarNav" aria-controls="navbarNav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">';
    
    navbar_item($active_item=="home",     "Home",     '/');
    navbar_item($active_item=="explorer", "Explorer", 'explorer.php?pwd=/');
    navbar_item($active_item=="search",   "Search",   'search.php');
    navbar_item($active_item=="viewer",   "Viewer",   'viewer.php');
    
     echo '</ul>
       </div>
     </nav>';
}

function alert($msg) {
    echo "<div class='alert alert-danger' role='alert'>$msg</div>";
}


function footer($start_time) {
    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>';

    // From http://talkerscode.com/webtricks/get-page-loading-time-using-php.php
    $end_time = microtime(TRUE);
    $time_taken =($end_time - $start_time)*1000;
    $time_taken = round($time_taken,5);

    echo 'Page generated in '.$time_taken.' seconds.';
    echo '</body></html>';
}

?>
