<?php

include('../config.php');

include('D2view.php');

/*
echo get_include_path();
echo ini_get('include_path');
*/

$dota = "$home/.steam/steam/steamapps/common/dota 2 beta/game/dota/";


/*
$data = $vpk->read_file($dota.'pak01_000.vpk', 10000);
echo $data;
*/


// Based on https://stackoverflow.com/a/31685070
echo '<html><head>';
echo '<script type="text/javascript">
$("#chaps > li").click(function() {
  $(this).find("ul.assignments").toggleClass("hide");
});
</script>';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">';
echo '</head><body>';
echo "home is ".$home;

echo "<p>  is readable : ".   btos(is_readable($dota));
echo "<p>  is writable : ".    btos(is_writable($dota));
echo "<p>  is executable : ". btos(is_executable($dota));

echo '<link href="style.css?1" rel="stylesheet" type="text/css">
</head>';

if (!is_executable($dota)) {
    echo '<div class="alert alert-danger" role="alert">
  DotA directory isn\'t executable. You may have issues running this.
</div>';
}

echo '<div id="chaps">';

function btos($b) {
    return  $b ? "yes" : "no";
}


$d2 = new D2View($dota);


echo '</div>';
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>';

echo '</body></html>';

echo 'Total files :'.$d2->nb_files.'\n';

?>
