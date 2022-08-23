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

echo "home is ".$home;

echo '<link href="style.css" rel="stylesheet" type="text/css">
</head>';

echo '<html><div id="chaps">';




$d2 = new D2View($dota);


echo '</div></html>';

echo 'Total files :'.$d2->nb_files.'\n';

?>
