<?php

/*
echo get_include_path();
echo ini_get('include_path');
*/

$home = $_SERVER['HOME'];
$dota = "$home/.steam/steam/steamapps/common/dota 2 beta/game/dota/";


$vpk_file = $dota.'pak01_dir.vpk';
$vpk = new VPKReader\VPK($vpk_file);
$ent_tree = $vpk->vpk_entries;

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

echo '<link href="style.css" rel="stylesheet" type="text/css">
</head>';

echo '<html><div id="chaps">';






echo '</div></html></head>';

echo 'Total files :'.$count_files($ent_tree).'\n';

?>
